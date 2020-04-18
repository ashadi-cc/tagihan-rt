@extends('layouts.main')

@section('content')
<h1 class="mt-4">Master Tagihan</h1>
    @include('admin.master._header_billing', ['billing_list' => 'active', 'billing_upload' => ''])
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Edit Daftar Tagihan</h5>
                    <form action="{{ url('admin/master/tagihan/edit/' . $billing->id) }}" method="POST">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" name="nama" placeholder="Nama tagihan" value="{{ old('nama') ?: $billing->name }}">
                            @error('nama')
                                <div class="text-danger">
                                    {{ $errors->first('nama') }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Nominal</label>
                            <input type="number" class="form-control" name="nominal" placeholder="Nominal tagihan" value="{{ old('nominal') ?: $billing->amount }}">
                            @error('nominal')
                                <div class="text-danger">
                                    {{ $errors->first('nominal') }}
                                </div>
                            @enderror
                        </div>
                        <hr>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="Simpan">
                            <a href="{{ url('admin/master/tagihan') }}" class="btn btn-danger">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection