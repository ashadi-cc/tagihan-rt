@extends('layouts.main')

@section('content')
    <h1 class="mt-4">Upload Warga</h1>
    @include('admin.master._header_warga', ['warga_list' => '', 'warga_upload' => 'active'])
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ url('/admin/master/warga/upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div>File harus berupa Microsoft Excel (.xlsx)</div>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input id="" name="xls_file" type="file" class="file" data-show-preview="false" required>
                        </div>
                        @if ($errors->all())
                            <div class="alert alert-danger" role="alert">
                                @foreach ($errors->all() as $error)
                                    {{ $error }} <br/>
                                @endforeach
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group mt-4 mb-0">
                    <input type="submit" class="btn btn-primary" value="Mulai Upload">
                </div>

                @if(session()->has('success'))
                <hr>
                <div class="form-group">
                    <div class="alert alert-success">
                        {{ session()->get('success') }} <a href="{{ url('/admin/master/warga') }}">Lihat daftar warga</a>
                    </div>
                    <div class="alert alert-info">
                        {{ session('imported')}} record(s) succeed imported
                    </div>
                    <div class="alert alert-danger">
                        {{ session('fail')}} record(s) failed imported
                    </div>
                </div>
                @endif

            </form>
            <hr>
            <h4 class="small"> <a href="{{ asset('/xls-template/template_daftar_warga.xlsx') }}">Download contoh template</a></h4>
        </div>
    </div>
@endsection
