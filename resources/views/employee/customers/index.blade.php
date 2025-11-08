@extends('employee.master')

@push('link')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title')
    SITAW | Daftar Pelanggan
@endsection

@section('content')
    <div class="datatables">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Pelanggan</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item" aria-current="page">Daftar Pelanggan</li>
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="/administration/major/create">Tambah
                                        Pelanggan</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="/administration/major/{id}/edit">Edit
                                        Pelanggan</a>
                                </li>
                            </ol>

                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <img src="{{ asset('assets/images/breadcrumb/trolli.png') }}" alt="modernize-img"
                                class="img-fluid mb-n4" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="mb-5 position-relative">

                    <h4 class="card-title mb-0">Daftar Jurusan</h4>
                    <a href="/employee/ordering/create" class="btn btn-primary position-absolute top-0 end-0">Tambah
                        Kategori</a>

                </div>
                <p class="card-subtitle mb-3">

                </p>
                <div class="table-responsive">
                    <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                        <thead>
                            <!-- start row -->
                            <tr>
                                <th width="10%">No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Tanggal Registrasi</th>
                                <th>Status</th>
                                <th>Aksi</th>

                            </tr>
                            <!-- end row -->
                        </thead>
                        <tbody>
                            @foreach ($customers as $no => $customer)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>{{ $customer->usr_name }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input switch-status" type="checkbox"
                                                data-id="{{ $customer->usr_id }}"
                                                {{ $customer->usr_status ? 'checked' : '' }}>
                                            <label class="form-check-label">
                                                {{ $customer->usr_status ? 'Aktif' : 'Nonaktif' }}
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="/employee/customers/{{ $customer->usr_id }}/edit"
                                            class="btn btn-primary">Edit</a>
                                        <a href="/employee/customers/{{ $customer->usr_id }}/destroy"
                                            class="btn btn-danger" data-confirm-delete="true">Delete</a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <!-- start row -->


                            <tr>
                                <th width="10%">No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Tanggal Registrasi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            <!-- end row -->
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.switch-status').forEach(el => {
            el.addEventListener('change', function() {
                const userId = this.dataset.id;
                const status = this.checked ? 1 : 0;

                fetch(`/employee/customers/${userId}/toggle-status`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            usr_status: status
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.nextElementSibling.textContent = status ? 'Aktif' : 'Nonaktif';
                        } else {
                            alert('Gagal memperbarui status!');
                            this.checked = !this.checked; // balikin posisi switch
                        }
                    })
                    .catch(() => {
                        alert('Terjadi kesalahan jaringan.');
                        this.checked = !this.checked;
                    });
            });
        });
    </script>
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
