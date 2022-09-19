@extends('admin.master')
@section('title', 'Client | ' . env('APP_NAME'))

@php
    $name = 'name_'.app()->currentLocale();
@endphp
@section('content')

    <h1>All Clients</h1>
    @if (session('msg'))
        <div class="alert alert-{{ session('type') }}">
            {{ session('msg') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach ($clients as $client)
                    <td>{{ $client->id }}</td>
                    <td>{{ $client->$name }} </td>
                    <td><img width="80" src="{{ asset('image/clients/'.$client->image) }}" alt=""></td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('admin.clients.edit', $client->id) }}"><i class="fas fa-edit"></i></a>
                        <form class="d-inline" action="{{ route('admin.clients.destroy', $client->id) }}" method="POST">
                            @csrf
                            @method('delete')
                        <button class="btn btn-danger" onclick="return confirm('Are you sure')"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@stop

