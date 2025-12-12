{{-- halaman detail order --}}
 @extends('customer.master')

@push('link')
<link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title')
E-Laundry Garut | Detail Pemesanan
@endsection

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
      <div class="row align-items-center">
        <div class="col-9">
          <h4 class="fw-semibold mb-8">Order Laundry</h4>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Daftar Orderan</li>
              <li class="breadcrumb-item">
                <a class="text-muted text-decoration-none" href="/customer/laundry-order/create">Tambah Order</a>
              </li>
              <li class="breadcrumb-item">
                <a class="text-muted text-decoration-none" >Edit Order</a>
              </li>
              <li class="breadcrumb-item">
                <a class="text-muted text-decoration-none" >Detail Pemesanan</a>
              </li>
            </ol>
           
          </nav>
        </div>
        <div class="col-3">
          <div class="text-center mb-n5">
            
            <img src="{{ asset('assets/images/breadcrumb/ChatBc.png') }}" alt="laundry-img"
              class="img-fluid mb-n4" />
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Card Detail -->
  <div class="card overflow-visible">
    <div class="position-relative">
      <img src="{{ asset('assets/images/blog/blog-img5.jpg') }}" 
           class="card-img-top rounded-0 object-fit-cover" 
           alt="laundry-img" height="220">

           <img src="{{ auth()->check() && auth()->user()->usr_profile_photo
            ? asset('storage/' . auth()->user()->usr_profile_photo)
            : asset('assets/images/breadcrumb/ChatBc.png') }}" class="img-fluid rounded-circle position-absolute" style="bottom: -20px; left: 20px; width: 60px; height: 60px; border: 3px solid #fff;" data-bs-toggle="tooltip" data-bs-placement="top" alt="laundry-img"/>
    </div>

    <div class="card-body p-4 mt-4">
      <h4 class="fw-semibold mb-3">Informasi Pemesanan</h4>
      <div class="row">
        <div class="col-md-6">
          <p class="mb-1"><strong>Nama Pemesan:</strong> {{ $order->ord_customer_name}}</p>
          <p class="mb-1"><strong>No. Telepon:</strong> (+62) {{ $order->ord_phone_number }}</p>
          <p class="mb-1"><strong>Tanggal Pemesanan:</strong> {{ \Carbon\Carbon::parse($order->ord_created_at)->translatedFormat('l, d F Y H:i') }}</p>
          <p class="mb-1"><strong>Status:</strong> {{ $order->ord_status }}</p>

          </p>
        </div>
        {{-- <div class="col-md-6">
          <p class="mb-1"><strong>Jenis Layanan :</strong> {{ $order->service->lds_name ?? '-' }}</p>
          <p class="mb-1"><strong>Paket :</strong> {{ $order->package->ldp_name ?? '-' }}</p>
          <p class="mb-1"><strong>Jumlah Unit:</strong> {{ $order->ord_quantity }} {{ $order->package->ldp_unit ?? '-' }}</p>
          <p class="mb-1"><strong>Total Biaya:</strong> Rp {{ number_format($order->ord_total, 0, ',', '.') }}</p>
          
        </div> --}}
      </div>
    </div>
  
  <div class="card-body border-top p-4">
    <h5 class="fw-semibold mb-3">Detail Layanan</h5>
    <div class="col-12">
      <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
          <thead>
              <tr>
                <th width="10%">No</th>
                  <th style="width: 40%">Layanan</th>
                  <th style="width: 30%">Paket</th>
                  <th style="width: 15%">Harga per item</th>
                  <th style="width: 15%">Jumlah item</th>
                  <th style="width: 15%">Harga Laundry</th>
              </tr>
          </thead>
  
          <tbody>
              @foreach ($order->details as $no =>  $detail)
                  <tr>
                    <td>{{ $no + 1 }}</td>
                      <td>{{ $detail->service->lds_name }}</td>
                      <td>{{ $detail->package->ldp_name }}</td>
                      <td>Rp {{ number_format($detail->package->ldp_price, 0, ',', '.') }}/{{$detail->package->ldp_unit}}</td>
                      <td>{{ $detail->odt_quantity }} {{$detail->package->ldp_unit}}</td>
                      <td>Rp {{ number_format($detail->odt_total, 0, ',', '.') }}</td>
                  </tr>
              @endforeach
          </tbody>
  
          <tfoot>
              <tr class="fw-bold">
                <td></td>
                <td></td>
                <td></td>
                  <td colspan="2" class="text-end">Total yang harus di bayar</td>
                  <td>Rp {{ number_format($order->details->sum('odt_total'), 0, ',', '.') }}</td>
              </tr>
          </tfoot>
      </table>
  </div>
  </div>

    <div class="card-body border-top p-4">
      <h5 class="fw-semibold mb-3">Alamat Penjemputan</h5>
      <p class="text-dark mb-0">
        {{ $order->ord_address }}
      </p>
    </div>

    <div class="card-body border-top p-4">
      <h5 class="fw-semibold mb-3">Catatan Pemesanan</h5>
      <p class="text-dark mb-0">
        {{ $order->ord_note ?? 'Tidak ada catatan tambahan.' }}
      </p>
    </div>
  </div>
</div>
@endsection

@push('script')
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="{{ asset('assets/js/datatable/datatable-advanced.init.js') }}"></script>
@endpush
