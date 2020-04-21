@extends('layouts.main')

@section('content')
<h1 class="mt-4">Master Pembayaran</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
        <li class="breadcrumb-item active">Pembayaran</li>
    </ol>
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Edit Daftar Pembayaran</h5>
                    <form action="{{ url('admin/master/payment/edit/' . $payment->id) }}" method="POST">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" name="nama" placeholder="Nama Pembayaran" value="{{ old('nama') ?: $payment->name }}">
                            @error('nama')
                                <div class="text-danger">
                                    {{ $errors->first('nama') }}
                                </div>
                            @enderror
                        </div>
                        <hr>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="Simpan">
                            <a href="{{ url('admin/master/payment') }}" class="btn btn-danger">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection