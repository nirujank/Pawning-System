@extends('adminlte::page')

@section('title', 'Invoice')

@section('content_header')
    <h1>Invoice</h1>
@stop

@section('content')
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addTodoModal">Create
        Invoice</button></br></br>
    <table id="invoice-table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Invoice No</th>
                <th>Customer</th>
                <th>NIC</th>
                <th>Contact No</th>
                <th>Email</th>
                <th>Total</th>
                <th>Issuable</th>
                <th>Status</th>
                <th>View</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>


    <div class="modal fade bd-example-modal-lg" id="addTodoModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="display: inline">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Invoice</h4>
                </div>
                <div class="tabsbody">
                    <div class="tabs">
                        <input type="radio" name="tabs" id="tabone" checked="checked">
                        <label for="tabone">Person</label>
                        <div class="tab">
                            <h4>Fill Person Details</h4>
                            <div class="person">
                                <ul id="saveform_errList"></ul>
                                <form id="person-form">
                                    <div class="form-group">
                                        <label for="name">NIC*</label>
                                        <input type="text" class="form-control required" id="nic" name="nic"
                                            placeholder="Enter NIC Number" required>
                                        <span id="taskError" class="alert-message"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Passport Number</label>
                                        <input type="text" class="form-control" id="passport" name="passport"
                                            placeholder="Enter Passport Number" required>
                                        <span id="taskError" class="alert-message"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Customer Name*</label>
                                        <input type="text" class="form-control required" id="customer_name"
                                            name="customer_name" placeholder="Enter Customer Name" required>
                                        <span id="taskError" class="alert-message"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Address*</label>
                                        <textarea class="form-control required" id="address" name="address" placeholder="Enter Address" required>
                                </textarea>
                                        <span id="taskError" class="alert-message"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Contact Number*</label>
                                        <input type="number" class="form-control required" id="phone" name="phone"
                                            placeholder="Enter Contact Number" required>
                                        <span id="taskError" class="alert-message"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Email Address*</label>
                                        <input type="email" class="form-control required" id="email" name="email"
                                            placeholder="Enter Email" required>
                                        <span id="taskError" class="alert-message"></span>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary"
                                            onclick="CheckRequired();">Next</button>
                                    </div>
                                </form>

                            </div>
                        </div>

                        <input type="radio" name="tabs" id="tabtwo">
                        <label for="tabtwo">Article</label>
                        <div class="tab">
                            <h4>Fill Article Details</h4>
                            <div class="person">
                                <table id="data-table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Article Name</th>
                                            <th>Carratage Value</th>
                                            <th>Value Per 1 Gram</th>
                                            <th>Gross Weight</th>
                                            <th>Net Weight</th>
                                            <th>Value</th>

                                        </tr>
                                    </thead>
                                </table>


                                <table id="total-table" class="col-md-12">
                                    <tr>
                                        <th colspan="5"></th>
                                        <td>
                                            <nobr><button class="btn btn-sm btn-success" id="add"
                                                    style="float: right"><i class="fa fa-plus-circle"
                                                        aria-hidden="true"></i>&nbsp; Add</button>&nbsp;
                                                {{-- <button class="btn btn-sm btn-success" id="get"
                                                    style="float: right"><i class="fa fa-plus-circle"
                                                        aria-hidden="true"></i>&nbsp; get</button></br></br> --}}
                                            </nobr>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="5">Total Price</th>
                                        <td><input id="total" style="margin: 5px" class="col-md total"></td>
                                    </tr>
                                    <tr>
                                        <th colspan="5">Issuable Amount</th>
                                        <td><input id="issuable" style="margin: 5px" class="col-md issuable"></td>
                                    </tr>
                                    <tr>
                                        <th colspan="5">Expected Amount</th>
                                        <td><input id="expected" style="margin: 5px" class="col-md"></td>
                                    </tr>

                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" style='float: left;'
                                    onclick="$('#tabone').trigger('click');">Back</button>
                                <button type="button" class="btn btn-primary" onclick="tabthree()">Next</button>
                            </div>
                        </div>

                        <input type="radio" name="tabs" id="tabthree">
                        <label for="tabthree">Confirmation</label>
                        <div class="tab">
                            <h4>Details Confirmation</h4>
                            <table id="show-table" class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th>NIC</th>
                                        <td class="nic" colspan="5"></td>
                                    </tr>
                                    <tr>
                                        <th>Customer Name</th>
                                        <td colspan="5"></td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td colspan="5"></td>
                                    </tr>
                                    <tr>
                                        <th>Article Name</th>
                                        <th>Carratage Value</th>
                                        <th>Value Per Gram</th>
                                        <th>Gross Weight</th>
                                        <th>Net Weight</th>
                                        <th>Value</th>
                                    </tr>
                                    <tr id="article">



                                    </tr>
                                    <tr>
                                        <th>Total Price</th>
                                        <td id="total" colspan="5"></td>
                                    </tr>
                                    <tr>
                                        <th>Issuable Amount</th>
                                        <td id="issuable" colspan="5"></td>
                                    </tr>
                                    <tr>
                                        <th>Expected Amount</th>
                                        <td id="expected" colspan="5"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" style='float: left;'
                                    onclick="$('#tabtwo').trigger('click');">Back</button>
                                <button type="button" class="btn btn-primary" onclick="saveInvoice()">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="viewModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Invoice</h4>
                </div>
                <div class="modal-body">

                    <table id="view-table" class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>Invoice No:</th>
                                <td class="invoice_no" colspan="5"></td>
                            </tr>
                            <tr>
                                <th>NIC</th>
                                <td class="nic" colspan="5"></td>
                            </tr>
                            <tr>
                                <th>Customer Name</th>
                                <td class="customer" colspan="5"></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td class="address" colspan="5"></td>
                            </tr>
                            <tr>
                                <th>Article Name</th>
                                <th>Carratage Value</th>
                                <th>Value Per Gram</th>
                                <th>Gross Weight</th>
                                <th>Net Weight</th>
                                <th>Value</th>
                            </tr>
                            <tr id="article">



                            </tr>
                            <tr>
                                <th colspan="5">Total Price</th>
                                <td id="total"></td>
                            </tr>
                            <tr>
                                <th colspan="5">Issuable Amount</th>
                                <td id="issuable"></td>
                            </tr>
                            <tr>
                                <th colspan="5">Expected Amount</th>
                                <td id="expected"></td>
                            </tr>
                        </tbody>
                    </table>


                </div>
                <div class="modal-footer">
                    <a href="" type="button" class="btn btn-primary printpdf" onclick="">Print</a>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="billingModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Billing</h4>
                </div>
                <div class="modal-body">
                    <form id="billing-form">
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Pawn Bill Number</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="bill_no" placeholder="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Customer Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="customer" placeholder="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">NIC</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nic" placeholder="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="email" placeholder="">
                            </div>
                        </div>
                        </hr>
                        <div class="form-group row">
                            <div class="row col-md-6">
                                <label for="" class="col-sm-4 col-form-label">Add Date</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="add_date" placeholder="">
                                </div>
                            </div>
                            <div class="row col-md-6">
                                <label for="" class="col-sm-4 col-form-label">Maturity Date</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="maturity_date" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="row col-md-6">
                                <label for="" class="col-sm-4 col-form-label">Issued Amount</label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control" id="issued_amount" placeholder="">
                                </div>
                            </div>
                            <div class="row col-md-6">
                                <label for="" class="col-sm-4 col-form-label">Interest Rate</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="interest_rate" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="row col-md-6">
                                <label for="" class="col-sm-4 col-form-label">Total Interest</label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control" id="total_interest" placeholder="">
                                </div>
                            </div>
                            <div class="row col-md-6">
                                <label for="" class="col-sm-4 col-form-label">Daily Interest</label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control" id="daily_interest" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="row col-md-6">
                                <label for="" class="col-sm-4 col-form-label">Paid Amount</label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control" id="paid_amount" placeholder="">
                                </div>
                            </div>
                            <div class="row col-md-6">
                                <label for="" class="col-sm-4 col-form-label">Paid Interest</label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control" id="paid_interest" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="row col-md-6">
                                <label for="" class="col-sm-4 col-form-label">Payable Amount</label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control" id="payable_amount" placeholder="">
                                </div>
                            </div>
                            <div class="row col-md-6">
                                <label for="" class="col-sm-4 col-form-label">Payable Interest</label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control" id="payable_interest" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="row col-md-6">
                                <label for="" class="col-sm-4 col-form-label">Total Payable</label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control" id="total_payable" placeholder="">
                                </div>
                            </div>
                            <div class="row col-md-6">
                                <p>
                                    <a class="full_payment">Do FullPayment and Release Artical</a></br>
                                    <a class="half_payment">Do Half Payment</a>
                                </p>

                                {{-- <label for="" class="col-sm-4 col-form-label">Payable Interest</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="payable_interest" placeholder="">
                            </div> --}}
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="payment" class="btn btn-primary">Pay</button>
                </div>
            </div>

        </div>
    </div>




@stop


@section('css')
    <style>
        .modal-lg {
            max-width: 1200px;
        }

        .error {
            border: 2px solid red;
        }

        .tabs {
            display: flex;
            flex-wrap: wrap;
            height: 95%;
            width: 100%;
        }

        .person {
            width: 100%;
            height: 100%;
            padding: 1rem;
            background: #fff;
            padding: 20px;
        }

        .person .form-group label {
            all: unset
        }

        .tabs label {
            order: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem 2rem;
            margin-right: 0.2rem;
            cursor: pointer;
            background-color: rgb(34, 146, 244);
            font-weight: bold;
            transition: background ease 0.3s;
        }

        .tabs .tab {
            order: 9;
            flex-grow: 1;
            width: 100%;
            height: 100%;
            display: none;
            padding: 1rem;
            background: #fff;
            /* padding: 20px; */
            /* box-shadow: -10px 10px 0px 0px black; */
        }

        .tabs input[type="radio"] {
            display: none;
        }

        .tabs input[type="radio"]:checked+label {
            background: #fff;
        }

        .tabs input[type="radio"]:checked+label+.tab {
            display: block;
        }

        @media (max-width: 465px) {

            .tabs .tab,
            .tabs label {
                order: initial;
            }

            .tabs label {
                width: 100%;
                margin-left: 50px;
            }
        }

        .tabsbody {
            background: rgb(241, 241, 244);
            min-height: 100vh;
            box-sizing: border-box;
            /* padding-top: 10vh; */
            font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
            font-weight: 300;
            line-height: 1.5;
            max-width: 100%;
            max-height: 100%;
            margin: 0 auto;
            font-size: 110%;
            display: flex;
            /* justify-content: center; */
            /* align-items: center; */
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script>
        function fetchInvoice() {
            $.ajaxSetup({
                header: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('#invoice-table').DataTable({
                // dom: "Bfrtip",
                order: [
                    [0, 'desc']
                ],
                autoWidth: false,
                processing: true,
                serverSide: true,
                ajax: '{{ route('fetchinvoice') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'customer_name',
                        name: 'customer_name'
                    },
                    {
                        data: 'nic',
                        name: 'nic'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'issuable',
                        name: 'issuable'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(status, type, row, meta) {
                            if (status == 'Active') {
                                status = '<td><span  class="badge badge-primary">' + status + '</span></td>'
                            } else if (status == 'Released') {
                                status = '<td><span  class="badge badge-success">' + status + '</span></td>'
                            } else {
                                status = '<td><span class="badge badge-secondary">' + status +
                                    '</span></td>'
                            }
                            return status;
                        }
                    },
                    {
                        data: 'view',
                        name: 'view',
                        render: function(status, type, row, meta) {
                            action = '<a data-id="' + row.id + '" onclick="viewInvoice(' + row.id +
                                ')" class="btn btn-info viewBtn">Article &nbsp<i class="fa fa-eye" aria-hidden="true"></i></a>&nbsp<a data-id="' +
                                row.id + '" onclick="billing(' + row.id +
                                ')" class="btn btn-info viewBtn">Payment &nbsp<i class="fa fa-eye" aria-hidden="true"></i></a>'
                            return action;
                        }
                    },
                ],

            });

        }
        $(document).ready(function() {
            fetchInvoice();
        });



        function CheckRequired(event) {
            var $val = 0;
            $(".required").each(function() {
                var check = $(this).val();
                if (check == '') {
                    console.log($(this).attr("id"));
                    $(this).addClass("error");
                    $val = 1
                } else {
                    $(this).removeClass("error");

                }
            });

            // validate email field
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            var email = $('#email').val();
            var valid_email;
            if (!regex.test(email)) {
                valid_email = 0;
            } else {
                valid_email = 1;
            }
            //  ------------------

            if ($val > 0) {
                alert('Please enter the hightlighted values');
                return false;
            } else if (valid_email != 1) {
                alert('Please enter valid email address!');
                return false;
            } else {
                $("#tabtwo").trigger("click");
            }


        }


        let rowIdx = 0;

        $("#add").click(function() {

            $('#data-table tr:last').after(`<tr id="R${++rowIdx}">
        <td class="article_name"><select id="article_name" name="article_name" class="col-md">
                                        <option value="">Select One</option>
                                        @foreach (App\Models\Article::all() as $article)
                                            <option value="{{ $article->name }}">
                                                {{ $article->name }}
                                            </option>
                                        @endforeach
                                    </select></td>
        <td  class="carratage">
                                    <select  id="carratage" name="carratage" class="col-md">
                                        <option value="">Select One</option>
                                        @foreach (App\Models\Carratage::all() as $carratage)
                                        <option value="{{ $carratage->carratage_value }}" id={{ $carratage->value_per_gram }}>
                                            {{ $carratage->carratage_value }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
        <td class="value_per_gram"> <input class="col-md" type="number" step="0.1" name="value_per_gram[]" id="value_per_gram"/></td>
        <td class="gross_weight"> <input class="col-md" type="number" step="0.1" namme="gross_weight[]" id="gross_weight"/></td>
        <td class="net_weight"> <input class="col-md" type="number" step="0.1"  name="net_weight[]" id="net_weight"/></td>
        <td class="value"> <input class="col-md value" type="number" step="0.1" name="value[]" id="value"/></td>
        <td class="text-center">
            <button class="btn btn-danger remove"
                type="button">Remove</button>
            </td>

        </tr>`);
        });
        $('#data-table').on('click', '.remove', function() {

            // Getting all the rows next to the
            // row containing the clicked button
            var child = $(this).closest('tr').nextAll();

            // Iterating across all the rows
            // obtained to change the index
            child.each(function() {
                // Getting <tr> id.
                var id = $(this).attr('id');
                // Getting the <p> inside the .row-index class.
                var idx = $(this).children('.row-index').children('p');
                // Gets the row number from <tr> id.
                var dig = parseInt(id.substring(1));
                // Modifying row index.
                idx.html(`Row ${dig - 1}`);
                // Modifying row id.
                $(this).attr('id', `R${dig - 1}`);
            });
            // Removing the current row.
            $(this).closest('tr').remove();
            // Decreasing the total number of rows by 1.
            rowIdx--;

            console.log($(this).closest('td').prev('td').children('input').val());
            var balance = ($("#total-table .total").val() - $(this).closest('td').prev('td').children('input')
                .val());
            $("#total-table .total").val(balance);
            var issuable = <?php echo App\Models\IssuingAmount::all()->last()->max_issue_amount; ?>;
            $("#total-table .issuable").val(issuable * balance);
        });




        $(document).on('change', '#data-table .carratage', function() {
            var carratage = $(this).children('select').val();
            var value_per_gram;
            $.ajax({
                dataType: 'json',
                async: false,
                url: "{{ route('invoice.getcarratage') }}",
                data: {
                    "id": carratage
                },
                type: 'get',
                success: function(result) {
                    value_per_gram = result.data;
                }
            });
            $(this).next('td').find('input').val(value_per_gram);




        });

        $(document).on('input change', '.net_weight', function() {
            var val_per_gram = $(this).parent().children(".value_per_gram").find('input').val();
            var math1 = val_per_gram * $(this).children('input').val();
            $(this).next('td').find('input').val(math1);


            var calculated_total_sum = 0;

            $("#data-table .value").each(function() {
                var get_textbox_value = $(this).children('input').val();
                if ($.isNumeric(get_textbox_value)) {
                    calculated_total_sum += parseFloat(get_textbox_value);
                    console.log(calculated_total_sum);
                }

            });
            $("#total-table .total").val(calculated_total_sum);
            var issuable = <?php echo App\Models\IssuingAmount::all()->last()->max_issue_amount; ?>;
            $("#total-table .issuable").val(issuable * calculated_total_sum);

        });

        var TableData = new Array();
        var nic;
        var customer;
        var address;
        var total;
        var issuable;
        var expected;
        var passport;
        var phone;
        var email;

        function tabthree() {

            $('#tabthree').trigger('click');
            nic = $('#person-form #nic').val();
            customer = $('#person-form #customer_name').val();
            address = $('#person-form #address').val();
            total = $('#total-table #total').val();
            issuable = $('#total-table #issuable').val();
            expected = $('#total-table #expected').val();
            passport = $('#person-form #passport').val();
            phone = $('#person-form #phone').val();
            email = $('#person-form #email').val();





            $('#show-table tbody').find('tr').eq(0).find('td').html(nic);
            $('#show-table tbody').find('tr').eq(1).find('td').html(customer);
            $('#show-table tbody').find('tr').eq(2).find('td').html(address);
            $('#show-table #total').html(total);
            $('#show-table #issuable').html(issuable);
            $('#show-table #expected').html(expected);



            $('#data-table tr').each(function(row, tr) {
                TableData[row] = {
                    "ArticleName": $(tr).find('td:eq(0)').children('select').val(),
                    "Carratage": $(tr).find('td:eq(1)').children('select').val(),
                    "val_per_gram": $(tr).find('td:eq(2)').children('input').val(),
                    "gross_weight": $(tr).find('td:eq(3)').children('input').val(),
                    "net_weight": $(tr).find('td:eq(4)').children('input').val(),
                    "value": $(tr).find('td:eq(5)').children('input').val(),
                }
            });
            TableData.shift(); // first row is the table header - so remove
            // console.log(TableData);

            props = ["ArticleName", "Carratage", "val_per_gram", "gross_weight", "net_weight", "value"];
            $.each(TableData, function(i, TableData) {
                var tr = $('<tr>');
                $.each(props, function(i, prop) {
                    $('<td>').html(TableData[prop]).appendTo(tr);
                });
                $('#show-table').find('tr').eq(4).after(tr);
            });

        }

        function saveInvoice() {
            var data = new Array();
            data = {
                nic,
                customer,
                address,
                passport,
                phone,
                email,
                total,
                issuable,
                expected,
                TableData,
            }
            // console.log(data);
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            $.ajax({
                url: "{{ route('invoice.saveInvoice') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    data: data,
                },
                success: function(response) {
                    if (response.success) {
                        // alert("success!!") //Message come from controller
                        $("#addTodoModal").modal('hide');
                        $("#addTodoModal").find('input').val("");
                        $("#addTodoModal").find('textarea').val("");
                        $("#addTodoModal").find('select').val("");

                        Toast.fire({
                            type: 'success',
                            title: "Invoice Created Successfully",
                            customClass: {
                                popup: 'adjust'
                            }
                        });
                        $("#invoice-table").dataTable().fnDestroy();
                        fetchInvoice();
                    } else {
                        alert("Error")
                    }
                },
                error: function(error) {
                    console.log(error)
                }
            });
        }

        function viewInvoice(id) {
            var id;
            $('#viewModal').modal('show', function(e) {
                var id = $(e.relatedTarget).data('id');
            });
            var viewdata;
            $.ajax({
                dataType: 'json',
                async: false,
                url: "{{ route('invoice.getInvoice') }}",
                data: {
                    "id": id
                },
                type: 'get',
                success: function(result) {
                    viewdata = result.data;
                }
            });
            // console.log(viewdata);
            $('#view-table tbody').find('tr').eq(0).find('td').html(viewdata.id);
            $('#view-table tbody').find('tr').eq(1).find('td').html(viewdata.nic);
            $('#view-table tbody').find('tr').eq(2).find('td').html(viewdata.customer_name);
            $('#view-table tbody').find('tr').eq(3).find('td').html(viewdata.address);
            $('#view-table #total').html(viewdata.total);
            $('#view-table #issuable').html(viewdata.issuable);
            $('#view-table #expected').html(viewdata.expected);

            var TableData = viewdata.article_details;
            props = ["ArticleName", "Carratage", "val_per_gram", "gross_weight", "net_weight", "value"];
            $.each(TableData, function(i, TableData) {
                var tr = $('<tr class="nirujan">');
                $.each(props, function(i, prop) {
                    $('<td>').html(TableData[prop]).appendTo(tr);
                });
                $('#view-table').find('tr').eq(4).after(tr);
            });

            $("#viewModal").on('hide.bs.modal', function() {
                $('#view-table').find('tr').find('td').html("");
                // $('#nirujan').remove();

            });

            $('.printpdf').attr("href", "{{ URL::to('/pdf') }}" + '/' + id);

        }

        function billing(id) {
            var id;
            $('#billingModal').modal('show', function(e) {
                var id = $(e.relatedTarget).data('id');
            });
            var viewdata;
            var interest;
            var payment;
            $.ajax({
                dataType: 'json',
                async: false,
                url: "{{ route('invoice.getInvoice') }}",
                data: {
                    "id": id
                },
                type: 'get',
                success: function(result) {
                    viewdata = result.data;
                    interest = result.interest;
                    payment = result.payment;
                }
            });
            // console.log(payment);

            $('#billing-form #bill_no').val(payment.bill_no);
            $('#billing-form #customer').val(viewdata.customer_name);
            $('#billing-form #nic').val(viewdata.nic);
            $('#billing-form #email').val(viewdata.email);
            $('#billing-form #add_date').val(payment.add_date);
            $('#billing-form #maturity_date').val(payment.maturity_date);
            $('#billing-form #issued_amount').val(payment.issued_amount);
            $('#billing-form #interest_rate').val(payment.interest_rate);
            $('#billing-form #total_interest').val(payment.total_interest);
            $('#billing-form #daily_interest').val(payment.daily_interest);
            $('#billing-form #paid_amount').val(payment.paid_amount);
            $('#billing-form #paid_interest').val(payment.paid_interest);
            $('#billing-form #payable_amount').val(payment.payable_amount);
            $('#billing-form #payable_interest').val(payment.payable_interest);
            $('#billing-form #total_payable').val(payment.total_payable);

            $('.full_payment').on('click', function() {
                $('#billing-form #paid_amount').val(payment.issued_amount);
                $('#billing-form #paid_interest').val(payment.total_interest);
                $('#billing-form #payable_amount').val(0);
                $('#billing-form #payable_interest').val(0);
                $('#billing-form #total_payable').val(0);

            });
            $('.half_payment').on('click', function() {
                $('#billing-form #paid_amount').val(parseInt(payment.paid_amount) + parseInt(payment.payable_amount / 2));
                $('#billing-form #paid_interest').val(parseInt(payment.paid_interest) + parseInt(payment.payable_interest / 2));
                $('#billing-form #payable_amount').val((payment.payable_amount) - payment.payable_amount / 2);
                $('#billing-form #payable_interest').val((payment.payable_interest) - payment.payable_interest / 2);
                $('#billing-form #total_payable').val((payment.payable_amount / 2) + (payment.payable_interest /
                2));

            });

            // $('#billing-form #paid_amount').on('change', function() {

            // });

            $('#payment').on('click', function() {
                var bill_no = $('#billing-form #bill_no').val();
                var add_date = $('#billing-form #add_date').val();
                var maturity_date = $('#billing-form #maturity_date').val();
                var issued_amount = $('#billing-form #issued_amount').val();
                var interest_rate = $('#billing-form #interest_rate').val();
                var total_interest = $('#billing-form #total_interest').val();
                var daily_interest = $('#billing-form #daily_interest').val();
                var paid_amount = $('#billing-form #paid_amount').val();
                var paid_interest = $('#billing-form #paid_interest').val();
                var payable_amount = $('#billing-form #payable_amount').val();
                var payable_interest = $('#billing-form #payable_interest').val();
                var total_payable = $('#billing-form #total_payable').val();
                var data = new Array();

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });

                data = {
                    bill_no,
                    add_date,
                    maturity_date,
                    issued_amount,
                    interest_rate,
                    total_interest,
                    daily_interest,
                    paid_amount,
                    paid_interest,
                    payable_amount,
                    payable_interest,
                    total_payable,
                }

                $.ajax({
                    url: "{{ route('invoice.savePayment') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        data: data,
                    },
                    success: function(response) {
                        if (response.success) {
                            $("#billingModal").modal('hide');
                            $("#billingModal").find('input').val("");
                            $("#billingModal").find('textarea').val("");
                            $("#billingModal").find('select').val("");

                            Toast.fire({
                                type: 'success',
                                title: "Payment Updated Successfully",
                                customClass: {
                                    popup: 'adjust'
                                }
                            });
                            $("#invoice-table").dataTable().fnDestroy();
                            fetchInvoice();
                        } else {
                            alert("Error")
                        }
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });
            });

        }
    </script>


@stop
