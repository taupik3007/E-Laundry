@foreach($orderHistory as $no => $order)
<tr>
    <td>{{ $no+1 }}</td>
    <td>{{ $order->ord_invoice ?? '-' }}</td>
    <td>{{ $order->ord_customer_name }}</td>
    {{-- <td>{{ $order->service->lds_name ?? '-' }}</td>
    <td>{{ $order->ord_quantity ?? '-' }} {{ $order->package->ldp_unit ?? '-' }}</td> --}}
    <td>
        Rp
        {{ number_format($order->ord_total ?? $order->details->sum('odt_total'), 0, ',', '.') }}

    </td>
    <td>{{ $order->ord_updated_at->format('d/m/Y H:i') }}</td>
    <td>
        <a href="{{ route('payment.receipt', $order->payment->pym_id) }}" 
           class="btn btn-sm btn-primary" target="_blank">
            <i class="ti ti-printer"></i> Cetak Struk
        </a>
    </td>
</tr>
@endforeach
