@if(count($data))

<div class="card-header bg-success text-white"><i class="fa fa-table mr-1"></i>
    Tunggakan tagihan bulan sebelumnya
</div>
<div class="card-body">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Iuran</th>
                    <th>Bulan</th>
                    <th>Nomimal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <td>{{ $item->billing_name }}</td>
                    <td>
                        {{ $item->monthName}}/{{$item->year}}
                    </td>
                    <td>
                        <span class="badge badge-danger">
                            {{ number_format($item->amount, 2) }}
                        </span>
                    </td>
                </tr>
                @endforeach
                <tfoot>
                    <tr>
                        <th class="belum-lunas" colspan="2">Total tagihan</th>
                        <th><span class="belum-lunas">{{ $total }}</span></th>
                    </tr>
                </tfoot>
            </tbody>
        </table>
    </div>
</div>
@endif