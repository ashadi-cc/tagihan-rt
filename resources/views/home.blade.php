@extends('layouts.main')

@section('content')
    <h4 class="mt-4">Tagihan Anda</h4>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="card mb-4">
        <div class="card-header bg-success text-white"><i class="fas fa-table mr-1"></i>
            Bulan {{ $monthName }} Tahun {{ $filter['year'] }}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form class="form-inline" method="GET" action="/">
                        <div class="form-group mb-2">
                            <select name="year" id="" class="form-control">
                                @foreach($filter['years'] as $y)
                                <option value="{{ $y }}" {{ $filter["year"] != $y ?:"selected" }}>{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <select name="month" id="" class="form-control">
                                @foreach($filter['months'] as $m)
                                <option value="{{ $m['value'] }}" {{ $filter["month"] != $m['value'] ?:"selected" }}>{{ $m['text'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">Cari</button>
                        <a href="{{ url('/?year='. date('Y') . '&month='. date('n')) }}" class="btn btn-danger mb-2" style="margin-left:5px">Reset</a>
                    </form>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama Iuran</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($perMonth as $item)
                                    <tr>
                                        <td>{{ $item->billing_name }}</td>
                                        <td>
                                            @if ($item->status == 'Lunas')
                                            <span class="badge badge-success">
                                            {{ number_format($item->amount, 2) }}
                                            </span>
                                            @else 
                                            <span class="badge badge-danger">
                                            {{ number_format($item->amount, 2) }}
                                            </span>
                                            @endif 
                                        </td>

                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2" class="ringkasan">
                                        Ringkasan Tagihan {{ $monthName}} {{ $filter['year'] }}
                                    </th>
                                </tr>
                                <tr>
                                    <th class="lunas">Lunas</th>
                                    <th>
                                        <span class="lunas">{{ $lunas }}</span>
                                    </th>    
                                </tr>
                                <tr>
                                    <th class="belum-lunas">Belum Lunas</th>
                                    <th>
                                        <span class="belum-lunas">{{ $belumLunas }}</span>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5>Tagihan Lainnya</h5>
                    <div id="other-bill" class="table-responsive">
                    </div>
                </div>
            </div>

        </div>
        <div class="card-header bg-info text-white"><i class="fas fa-wallet mr-1"></i>
           Pembayaran bisa melalui
        </div>
        <div class="card-body">
            <ul>
                @foreach($payments as $p)
                    <li>{{ $p->name }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    var url = "{!! url('/other/?year='. $filter['year'] . '&month='. $filter['month']) !!}";
    $('#other-bill').load(url);
</script>
@endsection
