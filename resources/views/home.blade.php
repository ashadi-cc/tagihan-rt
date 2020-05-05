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
        <div class="card-header bg-success text-white"><i class="fa fa-table mr-1"></i>
            Bulan {{ $monthName }} Tahun {{ $filter['year'] }}
        </div>
        <div class="card-body">
            <a href="{{ url('/') }}" class="btn btn-danger btn-block">
                Refresh
            </a>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Iuran</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($perMonth as $item)
                            @if($item->amount)
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
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="belum-lunas">
                                Total Tagihan {{ $monthName}} {{ $filter['year'] }}
                            </th>
                            <th class="">
                                <span class="belum-lunas">{{ $belumLunas }}</span>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        @include('otherbill')

        <div class="card-header bg-info text-white"><i class="fa fa-credit-card mr-1"></i>
           Pembayaran bisa melalui
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-borderless">
                        @foreach($payments as $p)
                            <td class="">
                                <div>
                                <strong>{{ $p->name }}</strong>
                                </div>
                                @if ($p->qr_code)
                                <div>
                                    <img src="{{ url('qr-payment/'. $p->qr_code) }}" alt="" class="img-fluid">
                                </div>
                                @endif
                            </td>
                        </tr>

                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

