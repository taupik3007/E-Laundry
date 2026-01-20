@extends('owner.master')

@push('link')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title')
    E-Laundry | Daftar Pelanggan
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

                    <h4 class="card-title mb-0">Daftar Pelanggan</h4>
                    <a href="/owner/customer/create" class="btn btn-primary position-absolute top-0 end-0">Tambah Pelanggan</a>

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
                                        <a href="/owner/customer/{{ $customer->usr_id }}/edit"
                                            class="btn btn-sm btn-primary"
                                            data-bs-toggle="tooltip"
                                            title="Edit Data">
                                           <span class="iconify" data-icon="line-md:pencil" data-width="25"></span>
                                         </a>

                                         <a href="/owner/customer/{{ $customer->usr_id }}/detail-cust"
                                            class="btn btn-sm btn-primary"
                                            data-bs-toggle="tooltip"
                                            title="Edit Data">
                                           <span class="iconify" data-icon="line-md:text-box-twotone-to-text-box-multiple-twotone-transition" data-width="25"></span>
                                         </a>

                                    <button class="btn btn-warning btn-sm btn-edit-password d-inline-flex align-items-center gap-1"
                                        data-id="{{ $customer->usr_id }}"
                                        data-name="{{ $customer->usr_name }}"
                                        data-bs-toggle="tooltip"
                                        title="Edit Password">
                                    
                                        <span class="iconify"
                                            data-icon="mdi:password-reset"
                                            data-width="30"></span>
                                    </button>

                                    <a href="{{ route('owner.cust.destroy', $customer->usr_id) }}"
                                        class="btn btn-danger btn-sm"
                                        data-confirm-delete="true">
                                        <span class="iconify"
                                        data-icon="line-md:trash"
                                        data-width="30"></span>
                                     </a>
                                    
                                    {{-- <form action="{{ route('owner.cust.destroy', $customer->usr_id) }}" method="post"
                                        class="d-inline"
                                        
                                        >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" data-confirm-delete="true" data-bs-toggle="tooltip"
                                        title="Hapus Pegawai">
                                    
                                        <span class="iconify"
                                            data-icon="line-md:trash"
                                            data-width="30"></span></button>
                                    </form> --}}

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

{{-- MODAL --}}
<div class="modal fade" id="modalPassword" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form id="formPassword"  method="POST">
          @csrf
          @method('PUT')
  
          <div class="modal-header">
            <h5 class="modal-title">Edit Password</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
  
          <div class="modal-body">
            
            <div class="mb-3">
              <label class="form-label fw-bold">Nama User</label>
              <input 
                  type="text" 
                  id="inputUserName" 
                  class="form-control" 
                  readonly
              >
            </div>
  
            <div class="mb-3">
                <label class="form-label">Password Baru</label>
              
                <div class="input-group">
                  <input 
                    type="password"
                    name="password"
                    id="password"
                    class="form-control"
                    required
                    minlength="8"
                    placeholder="Minimal 8 karakter"
                  >
              
                  <span class="input-group-text" style="cursor: pointer;" onclick="togglePassword()">
                    <i class="ti ti-eye" id="toggleIcon"></i>
                  </span>
                </div>
              
                <small class="text-muted">
                  Password minimal 8 karakter
                </small>
              </div>
              
  
          </div>
  
          <div class="modal-footer">
            <button class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          </div>
  
        </form>
      </div>
    </div>
  </div>

  <script>
    document.querySelectorAll('.btn-edit-password').forEach(btn => {
 btn.addEventListener('click', function () {

     let id   = this.dataset.id;
     let name = this.dataset.name;

     // isi input nama
     document.getElementById('inputUserName').value = name;

     // set form action
     document.getElementById('formPassword').setAttribute('action', '/owner/customer/' + id + '/change-password');

     // tampilkan modal
     let modal = new bootstrap.Modal(document.getElementById('modalPassword'));
     modal.show();
 });
});

 </script>


    <script>
        document.querySelectorAll('.switch-status').forEach(el => {
            el.addEventListener('change', function() {
                const userId = this.dataset.id;
                const status = this.checked ? 1 : 0;

                fetch(`/owner/customers/${userId}/toggle-status`, {
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

<script>
    function togglePassword() {
      const password = document.getElementById('password');
      const icon = document.getElementById('toggleIcon');
  
      if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('ti-eye');
        icon.classList.add('ti-eye-off');
      } else {
        password.type = 'password';
        icon.classList.remove('ti-eye-off');
        icon.classList.add('ti-eye');
      }
    }
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
    <script src="https://code.iconify.design/3/3.1.1/iconify.min.js"></script>
@endpush
