@extends('clients.layout')

@section('client-content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Add New Client</h2>
    </div>

    <form action="{{ route('clients.store') }}" method="POST">
        @csrf
        @include('clients._form', ['client' => new App\Models\Client(), 'buttonText' => 'Create Client'])
    </form>
@endsection
