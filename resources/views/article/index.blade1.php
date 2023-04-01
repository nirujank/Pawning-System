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
    {{-- @php
        $heads = ['ID', 'Article Name', ['label' => 'Article Description', 'width' => 40], ['label' => 'Actions', 'no-export' => true, 'width' => 5]];

    @endphp
 --}}
    {{-- Minimal example / fill data using the component slot --}}
    {{-- <x-adminlte-datatable id="table1" :heads="$heads" striped hoverable bordered compressed>
        @foreach ($articles as $article)
            <tr id="todo_{{ $article->id }}">
                <td>{{ $article->id }}</td>
                <td>{{ $article->name }}</td>
                <td>{{ $article->description }}</td>
                <td>
                    <nobr>
                        <a data-id="{{ $article->id }}" onclick="editTodo(event.target)" class="btn btn-info">Edit<i
                                class="fa fa-sm fa-fw fa-pen"></i></a>
                        <a class="btn btn-danger" onclick="deleteTodo({{ $article->id }})">Delete<i
                                class="fa fa-sm fa-fw fa-trash"></i></a> --}}
    {{-- <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                            <i class="fa fa-lg fa-fw fa-eye"></i>
                        </button> --}}
    {{-- </nobr>
                </td>
            </tr>
        @endforeach
    </x-adminlte-datatable> --}}
    <table id="table1" class="table table-bordered table-striped">
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
        <script>
            function fetchArticle() {
                $.ajax({
                    type: "GET",
                    url: "fetcharticles",
                    dataType: "json",
                    success: function(response) {
                        $('tbody').html("");
                        $.each(response.articles, function(key, item) {
                            $('tbody').append('<tr id="todo_' + item.id + '">\
                                                <td>' + item.id + '</td>\
                                                <td>' + item.name + '</td>\
                                                <td>' + item.description + '</td>\
                                                <td> <nobr><a data-id="' + item.id +
                                '" onclick="editTodo(event.target)" class="btn btn-info">Edit<iclass="fa fa-sm fa-fw fa-pen"></i></a><a class="btn btn-danger" onclick="deleteTodo(' +
                                item.id + ')">Delete<i class="fa fa-sm fa-fw fa-trash"></i></a></nobr></td>\
                                                </tr>');
                        });
                    }
                });
            }

            $(document).ready(function() {
                fetchArticle();


            });

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
                            $("#addTodoModal").find('textarea').val("");
                            fetchArticle();

                            //         $('table tbody').append(`
                    //       <tr id="todo_${data.data.id}">
                    //           <td>${data.data.id}</td>
                    //           <td>${data.data.name}</td>
                    //           <td>${data.data.description}</td>
                    //           <td>
                    //             <nobr>
                    //               <a data-id="${data.data.id }" onclick="editTodo(${data.data.id})" class="btn btn-info">Edit<i class="fa fa-sm fa-fw fa-pen"></i></a>
                    //               <a data-id="${data.data.id}"  onclick="deleteTodo(${data.data.id})" class="btn btn-danger">Delete<i class="fa fa-sm fa-fw fa-trash"></i></a>
                    //             </nobr>
                    //           </td>
                    //       </tr>
                    //   `);

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

                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: token
                    },
                    success: function(data) {
                        $("#todo_" + data.data.id).remove();
                    }
                });
                fetchArticle();
            }

            function editTodo(e) {
                var id = $(e).data("id");
                var name = $("#todo_" + id + " td:nth-child(2)").html();
                var description = $("#todo_" + id + " td:nth-child(3)").html();
                $("#todo_id").val(id);
                $("#editname").val(name);
                $("#editdescription").val(description);
                $('#editTodoModal').modal('show');
            }

            function updateTodo() {
                var name = $('#editname').val();
                var description = $('#editdescription').val();
                var id = $('#todo_id').val();
                let _url = `/article/${id}`;
                let _token = $('meta[name="csrf-token"]').attr('content');

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
                        fetchArticle();
                    },
                    error: function(response) {
                        $('#taskError').text(response.responseJSON.errors.todo);
                    }
                });
            }
        </script>
    @stop
