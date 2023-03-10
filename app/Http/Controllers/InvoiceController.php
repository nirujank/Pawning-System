<?php

namespace App\Http\Controllers;

use App\Models\Carratage;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\IssuingAmount;
use Illuminate\Http\Request;
// reference the Dompdf namespace
use Dompdf\Dompdf;
use PDF;

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
        $invoice->save();



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
        // dd ($invoice);
        return response()->json(['status_code' => '200', 'data' => $invoice]);
    }

    public function pdf(Request $request, $id)
    {
       $invoice = Invoice::find($id);
       $article = $invoice->article_details;
       $cou=count($article);

    //    return $article;
    //   return view('invoice.view',compact('article','cou'));
    //    $article = json_decode($article, true);
    //    $article=explode(',' $article);
    //
    // return $invoice->article_details;
       $pdf = PDF::loadView('invoice.view', [
        'data' => $invoice,
        'article' => $article,
        'cou'=> $cou,
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
}
