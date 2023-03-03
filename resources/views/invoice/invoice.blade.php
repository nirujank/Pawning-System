@extends('adminlte::page')

@section('title', 'Invoice')

@section('content_header')
    <h1>Invoice</h1>
@stop

@section('content')
    <div class="tabsbody">
        <div class="tabs">

            <input type="radio" name="tabs" id="tabone" checked="checked">
            <label for="tabone">Person</label>
            <div class="tab">
                <h4>Fill Person Details</h4>
                <div class="person">
                    <ul id="saveform_errList"></ul>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label for="name" class="col-sm-12">NIC*</label>
                            <input type="text" class="form-control" id="nic" name="nic"
                                placeholder="Enter NIC Number" required>
                            <span id="taskError" class="alert-message"></span>
                        </div>
                        <div class="col-sm-12">
                            <label for="name" class="col-sm-12">Passport Number</label>
                            <input type="text" class="form-control" id="passport" name="passport"
                                placeholder="Enter Passport Number">
                            <span id="taskError" class="alert-message"></span>
                        </div>
                        <div class="col-sm-12">
                            <label for="name" class="col-sm-12">Customer Name*</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name"
                                placeholder="Enter Customer Name" required>
                            <span id="taskError" class="alert-message"></span>
                        </div>
                        <div class="col-sm-12">
                            <label for="name" class="col-sm-12">Address*</label>
                            <textarea class="form-control" id="address" name="address" placeholder="Enter Address" required>
                                </textarea>
                            <span id="taskError" class="alert-message"></span>
                        </div>
                        <div class="col-sm-12">
                            <label for="name" class="col-sm-12">Contact Number</label>
                            <input type="email" class="form-control" id="phone" name="phone"
                                placeholder="Enter Contact Number">
                            <span id="taskError" class="alert-message"></span>
                        </div>
                        <div class="col-sm-12">
                            <label for="name" class="col-sm-12">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Enter Email">
                            <span id="taskError" class="alert-message"></span>
                        </div>



                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="addTodo()">Save</button>
                </div>
            </div>

            <input type="radio" name="tabs" id="tabtwo">
            <label for="tabtwo">Article</label>
            <div class="tab">
                <h4>Fill Article Details</h4>
                <div class="person">
                    <ul id="saveform_errList"></ul>
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
                        <tbody>
                            {{-- <tr>
                                <td class="article_name">
                                    <select id="article_name" name="article_name" class="col-md">
                                        <option value="">Select One</option>
                                        @foreach (App\Models\Article::all() as $article)
                                            <option value="{{ $article->id }}">
                                                {{ $article->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="carratage">
                                    <select id="carratage" name="carratage" class="col-md">
                                        <option value="">Select One</option>
                                        @foreach (App\Models\Carratage::all() as $carratage)
                                            <option  value="{{ $carratage->value_per_gram }}" id={{ $carratage->id}}>
                                                {{ $carratage->carratage_value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="value_per_gram"><input style="margin: 5px" class="col-md" type="number"
                                        step="0.1" name="value_per_gram" id="value_per_gram"></td>
                                <td class="gross_weight"><input style="margin: 5px" class="col-md" type="number"
                                        step="0.1" namme="gross_weight" id="gross_weight"></td>
                                <td class="net_weight"><input style="margin: 5px" class="col-md" type="number"
                                        step="0.1" name="net_weight" id="net_weight"></td>
                                <td class="value"><input style="margin: 5px" class="col-md" type="number"
                                        step="0.1" name="value" id="value"></td>
                                <td class="delete"><button class="btn btn-danger col-md" id="delete">Remove</button>
                                </td>
                            </tr> --}}
                        </tbody>
                    </table>


                    <table id="total-table" class="col-md-12">
                        <tr>
                            <th colspan="5"></th>
                            <td>
                                <nobr><button class="btn btn-sm btn-success" id="add" style="float: right"><i
                                            class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp; Add</button>&nbsp;
                                    <button class="btn btn-sm btn-success" id="get" style="float: right"><i
                                            class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp; get</button></br></br>
                                </nobr>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="5">Total Price</th>
                            <td><input style="margin: 5px" class="col-md total"></td>
                        </tr>
                        <tr>
                            <th colspan="5">Issuable Amount</th>
                            <td><input style="margin: 5px" class="col-md"></td>
                        </tr>
                        <tr>
                            <th colspan="5">Expected Amount</th>
                            <td><input style="margin: 5px" class="col-md"></td>
                        </tr>

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="addTodo()">Next</button>
                </div>
            </div>

            <input type="radio" name="tabs" id="tabthree">
            <label for="tabthree">Confirmation</label>
            <div class="tab">
                <h4>Third tab content</h4>
                <p>hfioezhogehzioghz</p>
            </div>
        </div>
    </div>

@stop


@section('css')
    <style>
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
    <script>
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
                                        <option value="{{ $carratage->value_per_gram }}" id={{ $carratage->id }}>
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
        });

        $(document).on('click', '#get', function() {
            var ArticleName = [];
            var Carratage = []

            $('#data-table .article_name > select').each(function() {
                ArticleName.push($(this).val());
            });
            $('#data-table .carratage > select').each(function() {
                Carratage.push($(this).val());
            });
            console.log(ArticleName);
            console.log(Carratage);
        });


        $(document).on('change', '#data-table .carratage', function() {
            var carratage = $(this).children('select').val();
            var x = $(this).next('td').find('input').val(carratage);
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


        });

        // total
        // $(document).on('input change', '.value', function() {

        //     var sum = 0;
        //     $(".value").find('input').each(function() {
        //         sum += parseFloat($(this).children('input').val());
        //         console.log(sum);
        //     });
        //     // $('#sum').text(sum);
        // });
    </script>
@stop
