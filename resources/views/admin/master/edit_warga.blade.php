@extends('layouts.main')

@section('content')
    <h1 class="mt-4">Master Warga</h1>
    @include('admin.master._header_warga', ['warga_list' => 'active', 'warga_upload' => ''])
    <div class="card mb-4">
        <div class="card-body" id="app">
            <div class="row">
                <div class="col-md-6">
                    <h5>Edit Warga</h5>
                    <form action="{{ url('admin/master/warga/edit/' . $user->id) }}" method="POST">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" name="nama" placeholder="Nama warga" value="{{ old('nama') ?: $user->name }}">
                            @error('nama')
                                <div class="text-danger">
                                    {{ $errors->first('nama') }}
                                </div>
                            @enderror
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
                        @if (auth()->user()->id != $user->id)
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" value="1" name="is_admin" @if($user->hasRole('admin')) checked @endif>Admin?
                            </label>
                        </div>
                        @endif
                        <hr>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="Simpan">
                            <a href="{{ url('admin/master/warga') }}" class="btn btn-danger">Batal</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

