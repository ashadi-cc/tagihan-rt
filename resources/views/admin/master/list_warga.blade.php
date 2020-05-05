@extends('layouts.main')

@section('content')
    <h1 class="mt-4">Master Warga</h1>
    @include('admin.master._header_warga', ['warga_list' => 'active', 'warga_upload' => ''])
    <div class="card mb-4">
        <div class="card-body" id="app">
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <master-table 
            header-table="{{ $headerTable }}"
            header-data="{{ $headerData }}"
            search-placeholder="Cari blok atau nama"
            enable-download="true"
            base-url="{{ $baseUrl }}"/>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="{{ asset('js/manifest.js') }}"></script>
    <script src="{{ asset('js/vendor.js') }}"></script>
    <script src="{{ asset('js/master_user.js') }}"></script>
@endsection