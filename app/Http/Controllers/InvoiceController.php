<?php

namespace App\Http\Controllers;

use App\Jobs\Invoice as JobsInvoice;
use App\Mail\InvoiceMail;
use App\Models\Carratage;
use App\Models\Customer;
use App\Models\Interest;
use App\Models\Invoice;
use App\Models\IssuingAmount;
use App\Models\Payment;
use App\Models\Report;
use DateTime;
use Illuminate\Http\Request;
// reference the Dompdf namespace
use Dompdf\Dompdf;
use PDF;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{
    public function index()
    {
        //    return Carratage::where('carratage_value',18)->value('value_per_gram');
        $carratage = Carratage::all();
        return view('invoice.invoice', compact('carratage'));
    }

    public function getcarratage(Request $request)
    {
        $id = $request->id;
        $val_per_gram = Carratage::where('carratage_value', $id)->value('value_per_gram');
        return response()->json(['status_code' => '200', 'data' => $val_per_gram]);
    }

    public function saveInvoice(Request $request)
    {
        $old = Customer::where('email', '=', $request->data["email"])->first();

        // dd ($request->data["TableData"]);
        if ($old == null) {
            $customer = new Customer();
            $customer->nic = $request->data["nic"];
            $customer->customer_name = $request->data["customer"];
            $customer->passport = $request->data["passport"];
            $customer->address = $request->data["address"];
            $customer->phone = $request->data["phone"];
            $customer->email = $request->data["email"];
            $customer->save();
        }

        $invoice = new Invoice();
        $invoice->nic = $request->data["nic"];
        $invoice->customer_name = $request->data["customer"];
        $invoice->passport = $request->data["passport"];
        $invoice->address = $request->data["address"];
        $invoice->phone = $request->data["phone"];
        $invoice->email = $request->data["email"];
        $invoice->article_details = $request->data["TableData"];
        $invoice->total = $request->data["total"];
        $invoice->issuable = $request->data["issuable"];
        $invoice->expected = $request->data["expected"];
        $invoice->status = "Active";
        $invoice->save();

        $interest = Interest::where('created_at', '<=', $invoice->created_at)
            ->orderBy('created_at', 'DESC')
            ->first();

        $payment = new Payment();
        $payment->bill_no = $invoice->id;
        $payment->add_date = $invoice->created_at;
        $payment->maturity_date = $invoice->created_at->addYear();
        $payment->issued_amount = $request->data["issuable"];
        $payment->interest_rate = $interest->current_interest_rate;
        $payment->total_interest = (($request->data["issuable"]) * ($interest->current_interest_rate) / 100);
        $payment->daily_interest = (($request->data["issuable"]) * ($interest->current_interest_rate) / 36500);
        $payment->paid_amount = 0.00;
        $payment->paid_interest = 0.00;
        $payment->payable_amount = $request->data["issuable"];
        $payment->payable_interest = (($request->data["issuable"]) * ($interest->current_interest_rate) / 100);
        $payment->total_payable = (($request->data["issuable"]) + (($request->data["issuable"]) * ($interest->current_interest_rate) / 100));
        $payment->save();

        $report = new Report();
        $report -> invoice_no = $invoice->id;
        $report -> name = $request->data["customer"];
        $report -> status = "Active";
        $report -> first_reminder = $invoice->created_at->addYear()->subDays(30);
        $report -> second_reminder = $invoice->created_at->addYear()->subDays(15);
        $report -> third_reminder = $invoice->created_at->addYear()->subDays(5);
        $report -> first_reminder_desc = null;
        $report -> second_reminder_desc = null;
        $report -> third_reminder_desc = null;
        $report->save();

        // $customer = $old;
        // $email = $customer->email;
        // return $invoice;
        // Mail::to($customer->email)->send(new InvoiceMail($invoice));
        $job = new JobsInvoice($invoice);
        dispatch($job);
        //  laravel queue DOC on: https://www.iankumu.com/blog/laravel-queues/

        return response()->json(
            [
                'success' => true,
                'message' => 'Data inserted successfully'
            ]
        );
    }

    public function view()
    {
        return view('invoice.view');
    }

    public function getInvoice(Request $request)
    {
        $id = $request->id;
        $invoice = Invoice::find($id);
        $interest = Interest::where('created_at', '<=', $invoice->created_at)
            ->orderBy('created_at', 'DESC')
            ->first();
        $payment = Payment::where('bill_no', '=', $id)
            ->orderBy('created_at', 'DESC')
            ->first();


        // dd ($payment);
        return response()->json(['status_code' => '200', 'data' => $invoice, 'interest' => $interest, 'payment' => $payment]);
    }

    public function pdf(Request $request, $id)
    {
        $invoice = Invoice::find($id);
        $article = $invoice->article_details;
        $cou = count($article);

        //    return $article;
        //   return view('invoice.view',compact('article','cou'));
        //    $article = json_decode($article, true);
        //    $article=explode(',' $article);
        //
        // return $invoice->article_details;
        $pdf = PDF::loadView('invoice.view', [
            'data' => $invoice,
            'article' => $article,
            'cou' => $cou,
            'footer' => 'by Nirujan@pawning'
        ]);

        return $pdf->download('sample.pdf');
        // instantiate and use the dompdf class
        //     $dompdf = new Dompdf();
        //     $html = "<h1>Invoice No:".$id."</h1>

        //     $dompdf->loadHtml($html);

        //     // (Optional) Setup the paper size and orientation
        //     $dompdf->setPaper('A4', 'landscape');

        //     // Render the HTML as PDF
        //     $dompdf->render();

        //     // Output the generated PDF to Browser
        //     $dompdf->stream();
    }

    public function savePayment(Request $request)
    {
        // $payment = Payment::where('bill_no','=',$request->data["bill_no"])->get();
        $payment = new Payment();
        $payment->bill_no = $request->data["bill_no"];
        $payment->add_date = $request->data["add_date"];
        $payment->maturity_date = $request->data["maturity_date"];
        $payment->issued_amount = $request->data["issued_amount"];
        $payment->interest_rate = $request->data["interest_rate"];
        $payment->total_interest = $request->data["total_interest"];
        $payment->daily_interest = $request->data["daily_interest"];
        $payment->paid_amount = $request->data["paid_amount"];
        $payment->paid_interest = $request->data["paid_interest"];
        $payment->payable_amount = $request->data["payable_amount"];
        $payment->payable_interest = $request->data["payable_interest"];
        $payment->total_payable = $request->data["total_payable"];
        $payment->save();

        if ($request->data["total_payable"] == 0) {
            $invoice = Invoice::find($request->data["bill_no"]);
            $invoice->status = "Released";
            $invoice->update();

            $report = Report::find($request->data["bill_no"]);
            $report->status = "Closed";
            $report->update();
        }

        return response()->json(
            [
                'success' => true,
                'message' => 'Payment Updated successfully'
            ]
        );
    }
}
