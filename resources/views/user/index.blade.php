@extends('adminlte::page')

@section('title', 'Articles')

@section('content_header')
    <h1>Articles</h1>
@stop

@section('content')

    <div id="success_message"></div>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addTodoModal">Add User</button>
    </br></br>
    <table id="data-table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Designation</th>
                <th>Status</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>


    </div>

    {{-- Compressed with style options / fill data using the plugin config --}}

    <div class="modal fade" id="addTodoModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Add User</h4>
                </div>
                <div class="modal-body">

                    <ul id="saveform_errList"></ul>

                    <div class="form-group">
                        <label for="name" class="col-sm-12">First Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="first_name" name="first_name"
                                placeholder="Enter First Name">
                            <span id="taskError" class="alert-message"></span>
                        </div>
                        <label for="name" class="col-sm-12">Last Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="last_name" name="last_name"
                                placeholder="Enter Last Name">
                            <span id="taskError" class="alert-message"></span>
                        </div>
                        <label for="name" class="col-sm-12">Email</label>
                        <div class="col-sm-12">
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Enter Email">
                            <span id="taskError" class="alert-message"></span>
                        </div>
                        <label for="name" class="col-sm-12">Role</label>
                        <div class="col-sm-12">
                            <select class="form-control" name="role" id="role">
                                <option value="Admin">Admin</option>
                                <option value="System User">System User</option>
                            </select>
                            <span id="taskError" class="alert-message"></span>
                        </div>
                        <label for="name" class="col-sm-12">Designation</label>
                        <div class="col-sm-12">
                            <select class="form-control" name="dessignation" id="dessignation">
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
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
    <div class="modal fade" id="editTodoModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Article</h4>
                </div>
                <div class="modal-body">

                    <ul id="e_saveform_errList"></ul>

                    <input type="hidden" name="todo_id" id="todo_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-12">First Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="e_first_name" name="e_first_name"
                                placeholder="Enter First Name">
                            <span id="taskError" class="alert-message"></span>
                        </div>
                        <label for="name" class="col-sm-12">Last Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="e_last_name" name="e_last_name"
                                placeholder="Enter Last Name">
                            <span id="taskError" class="alert-message"></span>
                        </div>
                        <label for="name" class="col-sm-12">Email</label>
                        <div class="col-sm-12">
                            <input type="email" class="form-control" id="e_email" name="e_email"
                                placeholder="Enter Email" disabled>
                            <span id="taskError" class="alert-message"></span>
                        </div>
                        <label for="name" class="col-sm-12">Role</label>
                        <div class="col-sm-12">
                            <select class="form-control" name="e_role" id="e_role">
                                <option value="Admin">Admin</option>
                                <option value="System User">System User</option>
                            </select>
                            <span id="taskError" class="alert-message"></span>
                        </div>
                        <label for="name" class="col-sm-12">Designation</label>
                        <div class="col-sm-12">
                            <select class="form-control" name="e_dessignation" id="e_dessignation">
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                            <span id="taskError" class="alert-message"></span>
                        </div>
                        <label for="name" class="col-sm-12">Status</label>
                        <div class="col-sm-12">
                            <select class="form-control" name="e_status" id="e_status">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                            <span id="taskError" class="alert-message"></span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="updateTodo()">Save</button>
                </div>
            </div>
        </div>



    @stop


    @section('css')
        <link rel="stylesheet" href="/css/admin_custom.css">
    @stop

    @section('js')
        <script type="text/javascript">
            function fetchUser() {
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
                    ajax: '{{ route('fetchUser') }}',
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'first_name',
                            name: 'first_name'
                        },
                        {
                            data: 'last_name',
                            name: 'last_name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'role',
                            name: 'role'
                        },
                        {
                            data: 'dessignation',
                            name: 'dessignation'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            render: function(status, type, row, meta) {
                                action = '<a data-id="' + row.id + '" onclick="editTodo(' + row.id +
                                    ')" class="btn btn-info editBtn">Edit<i class="fa fa-sm fa-fw fa-pen"></i></a><a data-id="' +
                                    row.id + '"  onclick="deleteTodo(' + row.id +
                                    ')" class="btn btn-danger">Delete<i class="fa fa-sm fa-fw fa-trash"></i></a>'
                                return action;
                            }
                        },
                    ],

                });

            }
            $(document).ready(function() {
                fetchUser();
            });

            function addTodo() {
                var first_name = $('#first_name').val();
                var last_name = $('#last_name').val();
                var email = $('#email').val();
                var role = $('#role').val();
                var dessignation = $('#dessignation').val();

                let _url = `user`;
                let _token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: _url,
                    type: "POST",
                    dataType: "json",
                    data: {
                        first_name: first_name,
                        last_name: last_name,
                        email: email,
                        role: role,
                        dessignation: dessignation,
                        _token: _token,
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
                            $("#addTodoModal").find('textarea').val("");
                            Toast.fire({
                                type: 'success',
                                title: data.message,
                            });

                            $("#data-table").dataTable().fnDestroy();
                            fetchUser();

                            // $('#name').val();
                            // $('#description').val();

                            $('#addTodoModal').modal('hide');

                        }
                    },
                    error: function(response) {
                        $('#taskError').text(response.responseJSON.errors);
                    }
                });
            }

            function deleteTodo(id) {
                let url = `/user/${id}`;
                let token = $('meta[name="csrf-token"]').attr('content');
                var button = $(this);
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                Swal.fire({
                    title: "Are you sure?",
                    text: "You will not be able to recover this imaginary file!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Yes, delete it!',
                    closeOnConfirm: true
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result) {

                        $.ajax({
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: url,
                            data: {
                                _token: token
                            },
                            success: function(response, textStatus, xhr) {
                                Toast.fire({
                                    type: 'success',
                                    title: 'User Deleted Successfully!',
                                    customClass: {
                                        popup: 'adjust'
                                    }
                                })
                                $("#data-table").dataTable().fnDestroy();
                                fetchUser();
                            }
                        });
                    }
                });

            }

            function editTodo(id) {
                let url = `/user/${id}/edit`;
                let token = $('meta[name="csrf-token"]').attr('content');
                // $('#editTodoModal').modal('show');
                $.ajax({
                    url: url,
                    type: "GET",
                    data: {
                        _token: token
                    },
                    success: function(response) {
                        $("#todo_id").val(response.data.id);
                        $("#e_first_name").val(response.data.first_name);
                        $("#e_last_name").val(response.data.last_name);
                        $("#e_email").val(response.data.email);
                        $("#e_role").val(response.data.role);
                        $("#e_dessignation").val(response.data.dessignation);
                        $("#e_status").val(response.data.status);

                        $('#editTodoModal').modal('show');
                    }
                });
            }

            function updateTodo() {
                var id = $('#todo_id').val();
                var first_name = $('#e_first_name').val();
                var last_name = $('#e_last_name').val();
                var email = $('#e_email').val();
                var role = $('#e_role').val();
                var dessignation = $('#e_dessignation').val();
                var status = $('#e_status').val();
                let _url = `/user/${id}`;
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
                        first_name: first_name,
                        last_name: last_name,
                        email: email,
                        role: role,
                        dessignation: dessignation,
                        status: status,
                        _token: _token
                    },
                    success: function(data) {
                        $("#e_saveform_errList").html("");
                        $('#e_saveform_errList').addClass("alert alert-danger");
                        $('#todo_id').val('');
                        $('#e_first_name').val('');
                        $('#e_last_name').val('');
                        $('#e_email').val('');
                        $('#e_role').val('');
                        $('#e_dessignation').val('');
                        $('#e_status').val('');
                        $('#editTodoModal').modal('hide');
                        Toast.fire({
                                    type: 'success',
                                    title: data.message,
                                    customClass: {
                                        popup: 'adjust'
                                    }
                                })
                        $("#data-table").dataTable().fnDestroy();
                        fetchUser();
                    },
                    error: function(response) {
                        $('#taskError').text(response.responseJSON.errors.todo);
                    }
                });
            }
        </script>
    @stop
