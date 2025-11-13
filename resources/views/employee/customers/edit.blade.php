@extends('employee.master')

@section('title', 'Edit Pelanggan')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('customers.index') }}" class="text-muted text-decoration-none">Daftar Pelanggan</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Pelanggan</li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('customers.update', $customer->usr_id) }}" method="POST">
    @csrf
    @method('PUT')


                    <div class="mb-3">
                        <label for="usr_name" class="form-label">Nama</label>
                        <input type="text" name="usr_name" value="{{ $customer->usr_name }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="usr_email" class="form-label">Email</label>
                        <input type="email" name="usr_email" value="{{ $customer->usr_email }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="usr_nik" class="form-label">NIK</label>
                        <input type="text" name="usr_nik" value="{{ $customer->usr_nik }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="usr_birthplace" class="form-label">Tempat Lahir</label>
                        <input type="text" name="usr_birthplace" value="{{ $customer->usr_birthplace }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="usr_birthdate" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="usr_birthdate" value="{{ $customer->usr_birthdate }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="usr_gender" class="form-label">Jenis Kelamin</label>
                        <select name="usr_gender" class="form-select" required>
                            <option hidden value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-Laki" {{ $customer->usr_gender == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                            <option value="Perempuan" {{ $customer->usr_gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="usr_religion" class="form-label">Agama</label>
                        <input type="text" name="usr_religion" value="{{ $customer->usr_religion }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="usr_telephone" class="form-label">No. Telepon</label>
                        <input type="text" name="usr_telephone" value="{{ $customer->usr_telephone }}" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
