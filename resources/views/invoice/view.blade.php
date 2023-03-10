<!DOCTYPE html>
<html>

<head>
    <title>Invoive</title>
</head>
<style>
table.blueTable {
    border: 1px solid #000000;
    background-color: #f6f4f4;
    width: 100%;
    text-align: left;
    border-collapse: collapse;
}
table.blueTable td,
        table.blueTable th {
            border: 1px solid #020202;
            padding: 3px 2px;
        }

        table.blueTable tbody td {
            font-size: 13px;
        }

        table.blueTable tr:nth-child(even) {
            background: #fdfbfb;
        }

        table.blueTable thead {
            background: #1c6ea4;
            background: -moz-linear-gradient(top,
                #5592bb 0%,
                #327cad 66%,
                #1c6ea4 100%);
            background: -webkit-linear-gradient(top,
                #5592bb 0%,
                #327cad 66%,
                #1c6ea4 100%);
            background: linear-gradient(to bottom,
                #5592bb 0%,
                #327cad 66%,
                #1c6ea4 100%);
            border-bottom: 2px solid #444444;
        }

        table.blueTable thead th {
            font-size: 15px;
            font-weight: bold;
            color: #ffffff;
            border-left: 2px solid #d0e4f5;
        }

        table.blueTable tfoot td {
            font-size: 14px;
        }

        table.blueTable tfoot .links {
            text-align: right;
        }

</style>

<body>
    <h1>INDRA PAWNING SHOP</h1>
    <h2>Invoice No:{{$data->id}}</h2>
    <table class="blueTable">
        <tbody>
            <tr>
                <th>
                    <h4>NIC:</h4>
                </th>
                <td  colspan="5">
                    <h5>{{ $data->nic }}</h5>
                </td>
            </tr>
            <tr>
                <th>
                    <h4>Customer Name:</h4>
                </th>
                <td  colspan="5">
                    <h5>{{ $data->customer_name }}</h5>
                </td>
            </tr>
            <tr>
                <th>
                    <h4>Address:</h4>
                </th>
                <td  colspan="5">
                    <h5>{{ $data->address }}</h5>
                </td>
            </tr>
            <tr>
                <th>
                    <h4>Article Name</h4>
                </th>
                <th>
                    <h4>Carratage Value</h4>
                </th>
                <th>
                    <h4>Value Per Gram</h4>
                </th>
                <th>
                    <h4>Gross Weight</h4>
                </th>
                <th>
                    <h4>Net Weight</h4>
                </th>
                <th>
                    <h4>Value</h4>
                </th>
            </tr>
            @while ($cou > 0)
                <tr>
                    @foreach ($article[$cou - 1] as $disease)
                        <td>
                            <h5>{{ $disease }}</h5>
                        </td>
                    @endforeach
                </tr>
                <?php $cou--; ?>
            @endwhile

            <tr>
                <th>
                    <h4>Total Price:</h4>
                </th>
                <td  colspan="5">
                    <h5>{{ $data->total }}</h5>
                </td>
            </tr>
            <tr>
                <th>
                    <h4>Issuable Amount:</h4>
                </th>
                <td  colspan="5">
                    <h5>{{ $data->issuable }}</h5>
                </td>
            </tr>
            <tr>
                <th>
                    <h4>Expected Amount:</h4>
                </th>
                <td  colspan="5">
                    <h5>{{ $data->expected }}</h5>
                </td>
            </tr>
        </tbody>
    </table>
    <br>

    {{-- <p style="text-align: center;">{!! $footer !!}</p> --}}
</body>

</html>
