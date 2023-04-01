<?php

namespace App\Console\Commands;

use App\Mail\PawnExpire as MailPawnExpire;
use App\Models\Invoice;
use App\Models\Payment;
use DateTime;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;

class PawnExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:pawnexpire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $today = now();
        $payments = Payment::all();
        foreach ($payments as $payment) {
            $invoice = Invoice::find($payment->bill_no);
            $date1 =  $payment->maturity_date;
            $date1 = date('Y-m-d', strtotime($date1));
            $date2 = date('Y-m-d');
            $D1 = new DateTime($date1);
            $D2 = new DateTime($date2);
            echo $diff = $D2->diff($D1)->format('%R%a');

            // Phone Notification
            $receiverNumber = $invoice->phone;
            // $message = "This is testing from CodeSolutionStuff.com";
            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_TOKEN");
            $twilio_number = getenv("TWILIO_FROM");
            $client = new Client($account_sid, $auth_token);

            if ($diff <= 30 && $invoice->status == "Active") {
                if ($diff == 0) {
                    $invoice = Invoice::find($payment->bill_no);
                    $data = "Hi ".$invoice->customer_name." Your Pawn(Invoice No:".$invoice->id.") is Expired  and Going to Auxion";
                    Mail::to($invoice->email)->send(new MailPawnExpire($data, $invoice));
                    try {
                        $client->messages->create($receiverNumber, [
                            'from' => $twilio_number,
                            'body' => $data
                        ]);
                        echo ('SMS Sent Successfully.');
                    } catch (Exception $e) {
                        echo ("Error: " . $e->getMessage());
                    }
                }
                if ($diff == 15) {
                    $invoice = Invoice::find($payment->bill_no);
                    $data = "Hi ".$invoice->customer_name." Your Pawn(Invoice No:".$invoice->id.") is Going to Expire in 15 Days!";
                    Mail::to($invoice->email)->send(new MailPawnExpire($data, $invoice));
                    try {
                        $client->messages->create($receiverNumber, [
                            'from' => $twilio_number,
                            'body' => $data
                        ]);
                        echo ('SMS Sent Successfully.');
                    } catch (Exception $e) {
                        echo ("Error: " . $e->getMessage());
                    }
                }
                if ($diff == 5) {
                    $invoice = Invoice::find($payment->bill_no);
                    $data = "Hi ".$invoice->customer_name." Your Pawn(Invoice No:".$invoice->id.") is Going to Expire in 5 Days! ";
                    Mail::to($invoice->email)->send(new MailPawnExpire($data, $invoice));
                    try {
                        $client->messages->create($receiverNumber, [
                            'from' => $twilio_number,
                            'body' => $data
                        ]);
                        echo ('SMS Sent Successfully.');
                    } catch (Exception $e) {
                        echo ("Error: " . $e->getMessage());
                    }
                }


                if ($diff == 30) {
                    $invoice = Invoice::find($payment->bill_no);
                    $data = "Hi ".$invoice->customer_name." Your Pawn(Invoice No:".$invoice->id.") is Going to Expire in 30 Days!!!!";
                    Mail::to($invoice->email)->send(new MailPawnExpire($data, $invoice));
                    try {
                        $client->messages->create($receiverNumber, [
                            'from' => $twilio_number,
                            'body' => $data
                        ]);
                        echo ('SMS Sent Successfully.');
                    } catch (Exception $e) {
                        echo ("Error: " . $e->getMessage());
                    }
                }
            }
            //  else {
            //     $invoice = Invoice::find($payment->bill_no);
            //     // echo "Hello".$invoice->email."Good";
            //     Mail::to($invoice->email)->send(new MailPawnExpire());
            // }
        }
    }
}
