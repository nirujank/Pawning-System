@extends('adminlte::page')

@section('title', 'Add Article')

@section('content_header')
    <h1>Interest Rating</h1>
@stop

@section('content')
    <div id="success_message"></div>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addTodoModal">Update Interest Rate</button>
    </br></br>
    <table id="data-table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Current Interest Rate %</th>
                <th>Last Modified Date</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    </div>

    <div class="modal fade" id="addTodoModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Update Interest Date</h4>
                </div>
                <div class="modal-body">

                    <ul id="saveform_errList"></ul>

                    <div class="form-group">
                        <label for="name" class="col-sm-12">Interest Rate</label>
                        <div class="col-sm-12">
                            <input type="number" step="0.1" class="form-control" id="int_rate" name="int_rate"
                                placeholder="0.0">
                            <span id="taskError" class="alert-message"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="addTodo()">Save</button>
                </div>
            </div>
        </div>
    </div>
@stop


@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        function fetchInterest() {
            $.ajaxSetup({
                header: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('#data-table').DataTable({
                order: [[0, 'desc']],
                processing: true,
                serverSide: true,
                ajax: '{{ route('fetchInterset') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'current_interest_rate',
                        name: 'current_interest_rate'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                ],
            });

        }
        $(document).ready(function() {
            fetchInterest();
        });

        function addTodo() {
            var current_interest_rate = $('#int_rate').val();

            let _url = `interest`;
            let _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: _url,
                type: "POST",
                dataType: "json",
                data: {
                    current_interest_rate: current_interest_rate,
                    _token: _token
                },
                success: function(data) {
                    if (data.status == 400) {
                        $('#saveform_errList').html("");
                        $('#saveform_errList').addClass("alert alert-danger");
                        $.each(data.errors, function(key, err_values) {
                            $('#saveform_errList').append('<li>' + err_values + '</li>');
                        });
                    } else {
                        $("#saveform_errList").html("");
                        $("#success_message").addClass('alert alert-success')
                        $("#success_message").text(data.message)
                        $("#addTodoModal").modal('hide');
                        $("#addTodoModal").find('input').val("");
                        // $("#addTodoModal").find('textarea').val("");

                        $("#data-table").dataTable().fnDestroy();
                        fetchInterest();

                        // $('#name').val();
                        // $('#description').val();

                        $('#addTodoModal').modal('hide');

                    }
                },
                error: function(response) {
                    $('#taskError').text(response.responseJSON.errors.todo);
                }
            });
        }
    </script>
@stop
