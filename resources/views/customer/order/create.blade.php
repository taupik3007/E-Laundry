@extends('owner.master')

@push('link')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title')
    SITAW | Pemesanan
@endsection

@section('content')v
    <div class="datatables">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8">Pemesanan</h4>
                  
                </div>
                <div class="col-3">
                  <div class="text-center mb-n5">
                    <img src="{{ asset('assets/images/breadcrumb/ChatBc.png')}}" alt="modernize-img" class="img-fluid mb-n4" />
                  </div>
                </div>
              </div>
            </div>
          </div>
       
    <div class="card">
        <div class="card-body">
            <!-- <form action="{{ route('employee.store') }}" method="POST"> -->
                @csrf

                <div class="form-group">
                  <label for="nama">Nama</label>
                  <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="form-group">
                  <label for="alamat">Alamat</label>
                  <input type="alamat" name="alamat" class="form-control" required>
                </div>

                <div class="form-group">
                  <label for="no_telepon">No. Telepon</label>
                  <input type="text" name="no_telepon" class="form-control">
                </div>

                <div class="form-group">
                  <label for="jenis_layanan">Jenis Layanan</label>
                  <select name="jenis_layanan" class="form-control">
                        <option value="" disabled selected>-- Pilih layanan --</option>
                    <option value="pakaian">Pakaian</option>
                    <option value="tas">Tas</option>
                    <option value="sepatu">Sepatu</option>
                    <option value="helm">Helm</option>
                    <option value="kasur">Kasur</option>
                    <option value="sofa">Sofa</option>
                  </select>
                </div>

            </form>
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
