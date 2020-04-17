@extends('layouts.main')

@section('content')
    <h1 class="mt-4">Master Tagihan</h1>
    @include('admin.master._header_billing', ['billing_list' => 'active', 'billing_upload' => ''])
    <div class="card mb-4">
        <div class="card-body">
        </div>
    </div>
@endsection
