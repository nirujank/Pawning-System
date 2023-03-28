<x-mail::message>
    Hello {{ $invoice->customer_name }}

    Your Invoice No:{{ $invoice->id }} is Added on the System.

    Description

    Total Amount: {{ $invoice->total }}
    Issuable Amount: {{ $invoice->issuable }}


    <x-mail::button :url="''">
        Button Text
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
