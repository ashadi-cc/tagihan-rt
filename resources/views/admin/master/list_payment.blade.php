@extends('layouts.main')

@section('content')
    <h1 class="mt-4">Master Pembayaran</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
        <li class="breadcrumb-item active">Pembayaran</li>
    </ol>
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
                search-placeholder="Cari nama.."
                base-url="{{ $baseUrl }}"/>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <hr>
                    <h4>Tambah Pembayaran</h4>
                    <form action="{{ url('admin/master/payment') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" name="nama" placeholder="Nama Pembayaran" value="{{ old('nama') }}">
                            @error('nama')
                                <div class="text-danger">
                                    {{ $errors->first('nama') }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div>
                                <label for="">QR CODE</label>
                            </div>
                            <input id="" name="qr_code" type="file" class="file" data-show-preview="false">
                            @error('qr_code')
                                <div class="text-danger">
                                    {{ $errors->first('qr_code') }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="Simpan">
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/manifest.js') }}"></script>
    <script src="{{ asset('js/vendor.js') }}"></script>
    <script src="{{ asset('js/master_billing.js') }}"></script>
@endsection