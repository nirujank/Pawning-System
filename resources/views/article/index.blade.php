@extends('adminlte::page')

@section('title', 'Articles')

@section('content_header')
    <h1>Articles</h1>
@stop

@section('content')
    {{-- <div class="container"> --}}
    {{-- <a class="btn btn-info" href="javascript:void(0)" id="createNewPost"> Add New Article</a> --}}
    <div id="success_message"></div>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addTodoModal">Add New Article</button>
    </br></br>

    {{-- Setup data for datatables --}}
    @php
        $heads = ['ID', 'Article Name', ['label' => 'Article Description', 'width' => 40], ['label' => 'Actions', 'no-export' => true, 'width' => 5]];

    @endphp

    {{-- Minimal example / fill data using the component slot --}}
    <x-adminlte-datatable id="table1" :heads="$heads" striped hoverable bordered compressed>
        @foreach ($articles as $article)
            <tr>
                <td>{{ $article->id }}</td>
                <td>{{ $article->name }}</td>
                <td>{{ $article->description }}</td>
                <td>
                    <nobr>
                        <button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                        </button>
                        <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                            <i class="fa fa-lg fa-fw fa-trash"></i>
                        </button>
                        <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                            <i class="fa fa-lg fa-fw fa-eye"></i>
                        </button>
                    </nobr>
                </td>
            </tr>
        @endforeach
    </x-adminlte-datatable>

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
                    <h4 class="modal-title">Edit Todo</h4>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="todo_id" id="todo_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2">Task</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="edittask" name="todo"
                                placeholder="Enter task">
                            <span id="taskError" class="alert-message"></span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="updateTodo()">Save</button>
                </div>
            </div>
        </div>
        <script>
            function addTodo() {
                var name = $('#name').val();
                var description = $('#description').val();

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
                        debugger;
                        if(data.status == 400)
                        {
                            $('#saveform_errList').html("");
                            $('#saveform_errList').addClass("alert alert-danger");
                            $.each(data.errors, function(key, err_values)
                            {
                                $('#saveform_errList').append('<li>'+err_values+'</li>');
                            });
                        }
                        else
                        {
                            // $("#saveform_errList").html("");
                            $("#success_message").addClass('alert alert-success')
                            $("#success_message").text(data.message)

                        $('table tbody').append(`
                          <tr id="todo_${data.data.id}">
                              <td>${data.data.id}</td>
                              <td>${data.data.name}</td>
                              <td>${data.data.description}</td>
                              <td>
                                <nobr>
                                  <a data-id="${data.data.id }" onclick="editTodo(${data.data.id})" class="btn btn-xs btn-default text-primary mx-1 shadow"><i class="fa fa-lg fa-fw fa-pen"></i></a>
                                  <a data-id="${data.data.id}"  onclick="deleteTodo(${data.data.id})" class="btn btn-xs btn-default text-danger mx-1 shadow"><i class="fa fa-lg fa-fw fa-trash"></i></a>
                                </nobr>
                              </td>
                          </tr>
                      `);

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
                let url = `/todos/${id}`;
                let token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: token
                    },
                    success: function(response) {
                        $("#todo_" + id).remove();
                    }
                });
            }

            function editTodo(e) {
                var id = $(e).data("id");
                var todo = $("#todo_" + id + " td:nth-child(2)").html();
                $("#todo_id").val(id);
                $("#edittask").val(todo);
                $('#editTodoModal').modal('show');
            }

            function updateTodo() {
                var task = $('#edittask').val();
                var id = $('#todo_id').val();
                let _url = `/todos/${id}`;
                let _token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: _url,
                    type: "PUT",
                    data: {
                        todo: task,
                        _token: _token
                    },
                    success: function(data) {
                        todo = data
                        $("#todo_" + id + " td:nth-child(2)").html(todo.todo);
                        $('#todo_id').val('');
                        $('#edittask').val('');
                        $('#editTodoModal').modal('hide');
                    },
                    error: function(response) {
                        $('#taskError').text(response.responseJSON.errors.todo);
                    }
                });
            }
        </script>


    @stop


    @section('css')
        <link rel="stylesheet" href="/css/admin_custom.css">
        {{-- <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet"> --}}
    @stop

    @section('js')
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> --}}
        <script>
            console.log('Hi!');
        </script>
    @stop
