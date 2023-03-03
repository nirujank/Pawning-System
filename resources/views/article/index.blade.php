@extends('adminlte::page')

@section('title', 'Articles')

@section('content_header')
    <h1>Articles</h1>
@stop

@section('content')
    <div id="success_message"></div>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addTodoModal">Add New Article</button>
    </br></br>
    <table id="data-table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Article Name</th>
                <th>Article Description</th>
                <th>Actions</th>

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
                    <h4 class="modal-title" id="modelHeading">Add New Article</h4>
                </div>
                <div class="modal-body">

                    <ul id="saveform_errList"></ul>

                    <div class="form-group">
                        <label for="name" class="col-sm-12">Article Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter Article">
                            <span id="taskError" class="alert-message"></span>
                        </div>
                        <div class="col-sm-12">
                            <label for="description">Article description</label>

                            <textarea id="description" class="form-control" name="description">

                        </textarea>
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

                    <input type="hidden" name="todo_id" id="todo_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2">Article name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="editname" name="editname"
                                placeholder="Enter task">
                            <span id="taskError" class="alert-message"></span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label for="description">Article description</label>

                        <textarea id="editdescription" class="form-control" name="editdescription">

                    </textarea>
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
            function fetchArticle() {
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
                    ajax: '{{ route('fetcharticles') }}',
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'description',
                            name: 'description'
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
                fetchArticle();
            });

            function addTodo() {
                var name = $('#name').val();
                var description = $('#description').val();
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                let _url = `article`;
                let _token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: _url,
                    type: "POST",
                    dataType: "json",
                    data: {
                        name: name,
                        description: description,
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
                            $("#addTodoModal").modal('hide');
                            $("#addTodoModal").find('input').val("");
                            $("#addTodoModal").find('textarea').val("");
                            Toast.fire({
                                type: 'success',
                                title: data.message,
                                customClass: {
                                    popup: 'adjust'
                                }
                            })

                            $("#data-table").dataTable().fnDestroy();
                            fetchArticle();

                            $('#name').val();
                            $('#description').val();

                            $('#addTodoModal').modal('hide');

                        }
                    },
                    error: function(response) {
                        $('#taskError').text(response.responseJSON.errors.todo);
                    }
                });
            }

            function deleteTodo(id) {
                let url = `/article/${id}`;
                let token = $('meta[name="csrf-token"]').attr('content');
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
                                    title: "Article Deleted Successfully!",
                                    customClass: {
                                        popup: 'adjust'
                                    }
                                })
                                $("#data-table").dataTable().fnDestroy();
                                fetchArticle();
                            }
                        });
                    }
                });
            }

            function editTodo(id) {
                let url = `/article/${id}/edit`;
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
                        $("#editname").val(response.data.name);
                        $("#editdescription").val(response.data.description);
                        $('#editTodoModal').modal('show');
                    }
                });
            }

            function updateTodo() {
                var name = $('#editname').val();
                var description = $('#editdescription').val();
                var id = $('#todo_id').val();
                let _url = `/article/${id}`;
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
                        name: name,
                        description: description,
                        _token: _token
                    },
                    success: function(data) {
                        article = data
                        $("#todo_" + id + " td:nth-child(2)").html(article.data.name);
                        $("#todo_" + id + " td:nth-child(3)").html(article.data.description);
                        $('#todo_id').val('');
                        $('#editname').val('');
                        $('#editdescription').val('');
                        $('#editTodoModal').modal('hide');
                        Toast.fire({
                                type: 'success',
                                title: data.message,
                                customClass: {
                                    popup: 'adjust'
                                }
                            })
                        $("#data-table").dataTable().fnDestroy();
                        fetchArticle();
                    },
                    error: function(response) {
                        $('#taskError').text(response.responseJSON.errors.todo);
                    }
                });
            }
        </script>
    @stop
