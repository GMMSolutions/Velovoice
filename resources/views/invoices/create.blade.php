@extends('invoices.layout')

@section('invoice-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Create New Invoice</h1>
</div>

<form action="{{ route('invoices.store') }}" method="POST">
    @csrf
    @include('invoices._form')
</form>
@endsection
