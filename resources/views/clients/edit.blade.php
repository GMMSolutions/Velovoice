@extends('clients.layout')

@section('client-content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Client</h2>
    </div>

    <form action="{{ route('clients.update', $client) }}" method="POST">
        @csrf
        @method('PUT')
        @include('clients._form', ['client' => $client, 'buttonText' => 'Update Client'])
    </form>
@endsection
