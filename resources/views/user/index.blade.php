@extends('adminlte::page')

@section('Users', 'Dashboard')

@section('content_header')
    <h1>Users</h1>
@stop

@section('content')
    <p>All Users</p>

    {{-- Setup data for datatables --}}
    @php
        $heads = ['ID', 'Name', ['label' => 'Email', 'width' => 40], ['label' => 'Actions', 'no-export' => true, 'width' => 5]];

        $btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </button>';
        $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                  <i class="fa fa-lg fa-fw fa-trash"></i>
              </button>';
        $btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                   <i class="fa fa-lg fa-fw fa-eye"></i>
               </button>';

        $config = [
            // 'data' => [$users, '<nobr>' . $btnEdit . $btnDelete . $btnDetails . '</nobr>'],
            // 'data' => [[22, 'John Bender', '+02 (123) 123456789', '<nobr>' . $btnEdit . $btnDelete . $btnDetails . '</nobr>'], [19, 'Sophia Clemens', '+99 (987) 987654321', '<nobr>' . $btnEdit . $btnDelete . $btnDetails . '</nobr>'], [3, 'Peter Sousa', '+69 (555) 12367345243', '<nobr>' . $btnEdit . $btnDelete . $btnDetails . '</nobr>']],
            'order' => [[1, 'asc']],
            // 'columns' => [id, name, email, ['orderable' => false]],
            // 'columns' => [['data' => 'id'], ['data' => 'name'], ['data' => 'email'],['orderable' => false]],
        ];
    @endphp

    {{-- Minimal example / fill data using the component slot --}}
    <x-adminlte-datatable id="table5" :heads="$heads" :config="$config" theme="light" striped hoverable>

        {{-- @foreach ($config['data'] as $row)
            <tr>
                @foreach ($row as $cell)
                    <td>{!! $cell !!}</td>
                @endforeach
            </tr>
        @endforeach --}}
        @foreach ($users as $user)
        <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
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

    <p>Modal</p>
    {{-- Custom --}}
    <x-adminlte-modal id="modalCustom" title="Account Policy" size="lg" theme="teal" icon="fas fa-bell" v-centered
        static-backdrop scrollable>
        <div style="height:800px;">Read the account policies...</div>
        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto" theme="success" label="Accept" />
            <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    {{-- Example button to open modal --}}
    <x-adminlte-button label="Open Modal" data-toggle="modal" data-target="#modalCustom" class="bg-teal" />

@stop


@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
