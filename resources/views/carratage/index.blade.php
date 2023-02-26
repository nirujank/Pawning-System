@extends('adminlte::page')

@section('title', 'Add Article')

@section('content_header')
    <h1>Carratage Value</h1>
@stop

@section('content')
    <div id="success_message"></div>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addTodoModal">Add New Carratage</button>
    </br></br>
    <table id="data-table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Carratage Value(K)</th>
                <th>Value Per 1gram(1g)</th>
                <th>Actions</th>

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
                    <h4 class="modal-title" id="modelHeading">New Carratage Value</h4>
                </div>
                <div class="modal-body">

                    <ul id="saveform_errList"></ul>

                    <div class="form-group">
                        <label for="name" class="col-sm-12">Carratage Value(K)</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="carrat_value" name="carrat_value"
                                placeholder="Enter Carratage Value">
                            <span id="taskError" class="alert-message"></span>
                        </div>
                        <div class="col-sm-12">
                            <label for="description">Value Per 1gram(1g)</label>

                            <div class="col-sm-12">
                                <input type="number" step="0.1" class="form-control" id="val_per_g" name="val_per_g"
                                    placeholder="Enter Value Per 1gram">
                                <span id="taskError" class="alert-message"></span>
                            </div>

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
                    <h4 class="modal-title">Edit Carratage</h4>
                </div>
                <div class="modal-body">
                    <ul id="edit_saveform_errList"></ul>

                    <input type="hidden" name="edit_todo_id" id="edit_todo_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2">Carratage Value(K)</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="edit_carrat_value" name="edit_carrat_value"
                                placeholder="Enter Carratage Value">
                            <span id="edit_taskError" class="alert-message"></span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label for="description">Value Per 1gram(1g)</label>

                        <div class="col-sm-12">
                            <input type="number" step="0.1" class="form-control" id="edit_val_per_g"
                                name="edit_val_per_g" placeholder="Enter Value Per 1gram">
                            <span id="edit_taskError" class="alert-message"></span>
                        </div>

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
        <script>
            function fetchCarrat() {
                $.ajaxSetup({
                    header: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var table = $('#data-table').DataTable({
                    order: [
                        [0, 'desc']
                    ],
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('fetchcarrat') }}',
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'carratage_value',
                            name: 'carratage_value'
                        },
                        {
                            data: 'value_per_gram',
                            name: 'value_per_gram'
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
                fetchCarrat();
            });

            function addTodo() {
                var carratage_value = $('#carrat_value').val();
                var value_per_gram = $('#val_per_g').val();

                let _url = `carrat`;
                let _token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: _url,
                    type: "POST",
                    dataType: "json",
                    data: {
                        carratage_value: carratage_value,
                        value_per_gram: value_per_gram,
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
                            fetchCarrat();

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

            function deleteTodo(id) {
                let url = `carrat/${id}`;
                let token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        id: id,
                        _token: token
                    },
                    success: function(data) {
                        $("#todo_" + data.data.id).remove();
                    }
                });
                $("#data-table").dataTable().fnDestroy();
                fetchCarrat();
            }

            function editTodo(id) {
                let url = `/carrat/${id}/edit`;
                let token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: url,
                    type: "GET",
                    data: {
                        _token: token
                    },
                    success: function(response) {
                        console.log(response);
                        $("#edit_todo_id").val(response.data.id);
                        $("#edit_carrat_value").val(response.data.carratage_value);
                        $("#edit_val_per_g").val(response.data.value_per_gram);
                        $('#editTodoModal').modal('show');
                    }
                });
            }

            function updateTodo() {
                var carratage_value = $('#edit_carrat_value').val();
                var value_per_gram = $('#edit_val_per_g').val();
                var id = $('#edit_todo_id').val();
                let _url = `/carrat/${id}`;
                let _token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: _url,
                    type: "PUT",
                    data: {
                        carratage_value: carratage_value,
                        value_per_gram: value_per_gram,
                        _token: _token
                    },
                    success: function(data) {
                        if (data.status == 400) {
                            $('#edit_saveform_errList').html("");
                            $('#edit_saveform_errList').addClass("alert alert-danger");
                            $.each(data.errors, function(key, err_values) {
                                $('#edit_saveform_errList').append('<li>' + err_values + '</li>');
                            });
                        } else {
                            $("#edit_saveform_errList").html("");
                            $("#success_message").addClass('alert alert-success')
                            $("#success_message").text(data.message)
                            $("#addTodoModal").modal('hide');
                            $("#addTodoModal").find('input').val("");
                            $('#edit_todo_id').val('');
                            $('#edit_carrat_value').val('');
                            $('#edit_val_per_g').val('');
                            $('#editTodoModal').modal('hide');
                            $("#data-table").dataTable().fnDestroy();
                            fetchCarrat();
                        }
                    },
                    error: function(data) {
                        $('#edit_taskError').text(response.responseJSON.errors.todo);
                    }


                });
            }
        </script>
    @stop
