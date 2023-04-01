@extends('adminlte::page')

@section('title', 'Add Article')

@section('content_header')
    <h1>Issue Amount</h1>
@stop

@section('content')
    <div id="success_message"></div>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addTodoModal">Update Issue Amount</button>
    </br></br>
    <table id="data-table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Max Issue Amount %</th>
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
                    <h4 class="modal-title" id="modelHeading">Update Issue Amount</h4>
                </div>
                <div class="modal-body">

                    <ul id="saveform_errList"></ul>

                    <div class="form-group">
                        <label for="name" class="col-sm-12">Max Issue Amount %</label>
                        <div class="col-sm-12">
                            <input type="number" step="0.1" class="form-control" id="issue_amount" name="issue_amount"
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
        function fetchIssue() {
            $.ajaxSetup({
                header: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('#data-table').DataTable({
                order: [
                    [0, 'desc']
                ],
                autoWidth: false,
                processing: true,
                serverSide: true,
                ajax: '{{ route('fetchIssue') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'max_issue_amount',
                        name: 'max_issue_amount'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                ],
            });

        }
        $(document).ready(function() {
            fetchIssue();
        });

        function addTodo() {
            var max_issue_amount = $('#issue_amount').val();

            let _url = `issue`;
            let _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: _url,
                type: "POST",
                dataType: "json",
                data: {
                    max_issue_amount: max_issue_amount,
                    _token: _token
                },
                success: function(data) {
                    const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    if (data.status == 400) {
                        $('#saveform_errList').html("");
                        $('#saveform_errList').addClass("alert alert-danger");
                        $.each(data.errors, function(key, err_values) {
                            $('#saveform_errList').append('<li>' + err_values + '</li>');
                        });
                    } else {
                        $("#saveform_errList").html("");
                        $("#addTodoModal").modal('hide');
                        $("#addTodoModal").find('input').val("");
                        Toast.fire({
                                type: 'success',
                                title: data.message,
                            });
                        // $("#addTodoModal").find('textarea').val("");

                        $("#data-table").dataTable().fnDestroy();
                        fetchIssue();

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
