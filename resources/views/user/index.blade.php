@extends('layouts.main')

@section('content')
    <h1 class="mt-4">Profile Anda</h1>
    <div class="card mb-4">
        <div class="card-body" id="app">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ url('user/password') }}" method="POST">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <label for="">Username untuk login</label>
                            <div class="alert alert-info">{{ $user->username }}</div>
                        </div>
                        <div class="form-group">
                            <label for="">Blok Rumah</label>
                            <div class="alert alert-info">{{ $user->blok }}</div>
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Email warga" value="{{ old('email') ?: $user->email }}">
                            @error('email')
                                <div class="text-danger">
                                    {{ $errors->first('email') }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" class="form-control" name="password">
                            <small>Kosongi jika tidak ingin merubah password lama</small>
                            @error('password')
                                <div class="text-danger">
                                    {{ $errors->first('password') }}
                                </div>
                            @enderror
                        </div>
                        <hr>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="Simpan">
                            <a href="{{ url('/') }}" class="btn btn-danger">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection