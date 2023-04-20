@extends('adminlte::page')

@section('title', 'Reports')

@section('content_header')
    <h1>Reports</h1>
@stop

@section('content')
<table id="data-table" class="table table-bordered table-striped">
    <thead>
        <tr>
            {{-- <th rowspan="2">ID</th> --}}
            <th rowspan="2">Invoice No</th>
            <th rowspan="2">Name</th>
            <th rowspan="2">Status</th>
            <th colspan="2">First Reminder</th>
            <th colspan="2">Second Reminder</th>
            <th colspan="2">Third Reminder</th>
            <th rowspan="2">Action</th>
        </tr>
        <tr>
            <th>Date</th>
            <th>Response and Followup</th>
            <th >Date</th>
            <th >Response and Followup</th>
            <th >Date</th>
            <th >Response and Followup</th>

        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

<div class="modal fade" id="editTodoModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Report</h4>
            </div>
            <div class="modal-body">

                <ul id="e_saveform_errList"></ul>

                <input type="hidden" name="todo_id" id="todo_id">
                <div class="form-group">
                    <label for="name" class="col-sm-12">First Reminder</label>
                    <div class="col-sm-12">
                        <textarea type="text" class="form-control" id="first_reminder_desc" name="first_reminder_desc"
                            placeholder="Enter First Reminder's Responses Here"></textarea>
                        <span id="taskError" class="alert-message"></span>
                    </div>
                    <label for="name" class="col-sm-12">Second Reminder</label>
                    <div class="col-sm-12">
                        <textarea type="text" class="form-control" id="second_reminder_desc" name="second_reminder_desc"
                            placeholder="Enter Second Reminder's Responses Here"></textarea>
                        <span id="taskError" class="alert-message"></span>
                    </div>
                    <label for="name" class="col-sm-12">Third Reminder</label>
                    <div class="col-sm-12">
                        <textarea type="text" class="form-control" id="third_reminder_desc" name="third_reminder_desc"
                            placeholder="Enter Third Reminder's Responses Here"></textarea>
                        <span id="taskError" class="alert-message"></span>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="updateTodo()">Update</button>
            </div>
        </div>
    </div>
@stop


@section('css')
@stop

@section('js')
<script type="text/javascript">
    function fetchReport() {
        $.ajaxSetup({
            header: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('#data-table').DataTable({
            dom: "Bfrtip",
            order: [
                [0, 'desc']
            ],
            autoWidth: false,
            processing: true,
            serverSide: true,
            ajax: '{{ route('fetchReport') }}',
            columns: [
                // {
                //     data: 'id',
                //     name: 'id'
                // },
                {
                    data: 'invoice_no',
                    name: 'invoice_no'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(status, type, row, meta) {
                            if (status == 'Active') {
                                status = '<td><span  class="badge badge-primary">' + status + '</span></td>'
                            } else if (status == 'Closed') {
                                status = '<td><span  class="badge badge-success">' + status + '</span></td>'
                            } else {
                                status = '<td><span class="badge badge-secondary">' + status +
                                    '</span></td>'
                            }
                            return status;
                        }
                },
                {
                    data: 'first_reminder',
                    name: 'first_reminder'
                },
                {
                    data: 'first_reminder_desc',
                    name: 'first_reminder_desc'
                },
                {
                    data: 'second_reminder',
                    name: 'second_reminder'
                },
                {
                    data: 'second_reminder_desc',
                    name: 'second_reminder_desc'
                },
                {
                    data: 'third_reminder',
                    name: 'third_reminder'
                },
                {
                    data: 'third_reminder_desc',
                    name: 'third_reminder_desc'
                },
                {
                            data: 'action',
                            name: 'action',
                            render: function(status, type, row, meta) {
                                if(row.status == "Closed")
                                {
                                    action = '<span class="badge badge-success"> Closed</span>';
                                }else
                                {
                                action = '<a data-id="' + row.id + '" onclick="editTodo(' + row.id +
                                    ')" class="btn btn-info editBtn">Update<i class="fa fa-sm fa-fw fa-pen"></i></a>';
                                }
                                return action;
                            }
                        },

            ],

        });

    }
    $(document).ready(function() {
        fetchReport();
    });

    function editTodo(id) {
                let url = `/report/${id}/edit`;
                let token = $('meta[name="csrf-token"]').attr('content');
                $('#editTodoModal').modal('show');
                $.ajax({
                    url: url,
                    type: "GET",
                    data: {
                        _token: token
                    },
                    success: function(response) {
                        $("#todo_id").val(response.data.id);
                        $("#first_reminder_desc").val(response.data.first_reminder_desc);
                        $("#second_reminder_desc").val(response.data.second_reminder_desc);
                        $("#third_reminder_desc").val(response.data.third_reminder_desc);
                        $('#editTodoModal').modal('show');
                    }
                });
            }

            function updateTodo() {
                var id = $('#todo_id').val();
                var first_reminder_desc = $('#first_reminder_desc').val();
                var second_reminder_desc = $('#second_reminder_desc').val();
                var third_reminder_desc = $('#third_reminder_desc').val();


                let _url = `/report/${id}`;
                let _token = $('meta[name="csrf-token"]').attr('content');
                const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });

                $.ajax({

                    url: _url,
                    type: "PUT",
                    data: {
                        id: id,
                        first_reminder_desc: first_reminder_desc,
                        second_reminder_desc: second_reminder_desc,
                        third_reminder_desc: third_reminder_desc,
                        _token: _token
                    },
                    success: function(data) {
                        // $("#e_saveform_errList").html("");
                        // $('#e_saveform_errList').addClass("alert alert-danger");
                        // $('#todo_id').val('');
                        // $('#e_first_name').val('');
                        // $('#e_last_name').val('');
                        // $('#e_email').val('');
                        // $('#e_role').val('');
                        // $('#e_dessignation').val('');
                        // $('#e_status').val('');
                        $('#editTodoModal').modal('hide');
                        Toast.fire({
                                    type: 'success',
                                    title: data.message,
                                    customClass: {
                                        popup: 'adjust'
                                    }
                                })
                        $("#data-table").dataTable().fnDestroy();
                        fetchReport();
                    },
                    error: function(response) {
                        $('#taskError').text(response.responseJSON.errors);
                    }
                });
            }
    </script>
@stop


