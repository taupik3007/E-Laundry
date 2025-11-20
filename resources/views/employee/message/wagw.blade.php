@extends('employee.master')

@push('link')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title')
    SITAW | Daftar Pelanggan
@endsection

@section('content')
    <div class="container-fluid">
        <form action="{{ route('wagw.send')}}" method="post">
            @csrf
            <input type="text" name="pesan" placeholder="pesan">
            <input type="text" name="nowa" placeholder="nomor wa">
            <button type="submit" class="btn btn-primary">Kirim pesan</button>
        </form>
    </div>

@endsection



