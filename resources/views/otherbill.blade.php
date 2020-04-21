@if(count($data))
<h5>Tagihan Lainnya</h5>
<table class="table">
    <thead>
        <tr>
            <th>Nama Iuran</th>
            <th>Nomimal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
        <tr>
            <td>{{ $item->billing_name }} ({{ $item->month}}/{{$item->year}})</td>
            <td>
                <span class="badge badge-danger">
                    {{ number_format($item->amount, 2) }}
                </span>
            </td>
        </tr>
        @endforeach
        <tfoot>
            <tr>
                <th class="belum-lunas">Total</th>
                <th><span class="belum-lunas">{{ $total }}</span></th>
            </tr>
        </tfoot>
    </tbody>
</table>
@endif