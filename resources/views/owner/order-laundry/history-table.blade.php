@foreach($orderHistory as $no => $order)
<tr>
    <td>{{ $no+1 }}</td>
    <td>{{ $order->ord_customer_name }}</td>
    <td>{{ $order->service->lds_name ?? '-' }}</td>
    <td>{{ $order->ord_quantity ?? '-' }} {{ $order->package->ldp_unit ?? '-' }}</td>
    <td>Rp {{ number_format($order->ord_total, 0, ',', '.') }}</td>
    <td>{{ $order->ord_updated_at->format('d/m/Y H:i') }}</td>
</tr>
@endforeach
