@extends('layouts.main')

@section('content')
    <h1 class="mt-4">Tagihan Anda</h1>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="card mb-4">
        <div class="card-header bg-primary text-white"><i class="fas fa-table mr-1"></i>DataTable Example</div>
        <div class="card-body">
        </div>
    </div>
@endsection
