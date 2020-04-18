@extends('layouts.main')

@section('content')
    <h1 class="mt-4">Master Tagihan</h1>
    @include('admin.master._header_billing', ['billing_list' => 'active', 'billing_upload' => ''])
    <div class="card mb-4">
        <div class="card-body">
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <div id="app">
                <master-table 
                header-table="{{ $headerTable }}"
                header-data="{{ $headerData }}"
                search-placeholder="Cari nama tagihan"
                base-url="{{ $baseUrl }}"/>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/manifest.js') }}"></script>
    <script src="{{ asset('js/vendor.js') }}"></script>
    <script src="{{ asset('js/master_billing.js') }}"></script>
@endsection