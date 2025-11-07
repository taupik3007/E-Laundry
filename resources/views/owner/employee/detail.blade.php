@extends('owner.master')

@push('link')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title')
    SITAW | Daftar Pegawai
@endsection

@section('content')
<div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop1">
    <div class="profile-dropdown position-relative" data-simplebar>
      <div class="py-3 px-7 pb-0">
        <h5 class="mb-0 fs-5 fw-semibold">User Profile</h5>
      </div>
      <div class="d-flex align-items-center py-9 mx-7 border-bottom">
        <img src="../assets/images/profile/user-1.jpg" class="rounded-circle" width="80" height="80" alt="modernize-img" />
        <div class="ms-3">
          <h5 class="mb-1 fs-3">Mathew Anderson</h5>
          <span class="mb-1 d-block">Designer</span>
          <p class="mb-0 d-flex align-items-center gap-2">
            <i class="ti ti-mail fs-4"></i> info@modernize.com
          </p>
        </div>
      </div>
      <div class="message-body">
        <a href="../main/page-user-profile.html" class="py-8 px-7 mt-8 d-flex align-items-center">
          <span class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
            <img src="../assets/images/svgs/icon-account.svg" alt="modernize-img" width="24" height="24" />
          </span>
          <div class="w-100 ps-3">
            <h6 class="mb-1 fs-3 fw-semibold lh-base">My Profile</h6>
            <span class="fs-2 d-block text-body-secondary">Account Settings</span>
          </div>
        </a>
        <a href="../main/app-email.html" class="py-8 px-7 d-flex align-items-center">
          <span class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
            <img src="../assets/images/svgs/icon-inbox.svg" alt="modernize-img" width="24" height="24" />
          </span>
          <div class="w-100 ps-3">
            <h6 class="mb-1 fs-3 fw-semibold lh-base">My Inbox</h6>
            <span class="fs-2 d-block text-body-secondary">Messages & Emails</span>
          </div>
        </a>
        <a href="../main/app-notes.html" class="py-8 px-7 d-flex align-items-center">
          <span class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
            <img src="../assets/images/svgs/icon-tasks.svg" alt="modernize-img" width="24" height="24" />
          </span>
          <div class="w-100 ps-3">
            <h6 class="mb-1 fs-3 fw-semibold lh-base">My Task</h6>
            <span class="fs-2 d-block text-body-secondary">To-do and Daily Tasks</span>
          </div>
        </a>
      </div>
      <div class="d-grid py-4 px-7 pt-8">
        <div class="upgrade-plan bg-primary-subtle position-relative overflow-hidden rounded-4 p-4 mb-9">
          <div class="row">
            <div class="col-6">
              <h5 class="fs-4 mb-3 fw-semibold">Unlimited Access</h5>
              <button class="btn btn-primary">Upgrade</button>
            </div>
            <div class="col-6">
              <div class="m-n4 unlimited-img">
                <img src="../assets/images/backgrounds/unlimited-bg.png" alt="modernize-img" class="w-100" />
              </div>
            </div>
          </div>
        </div>
        <a href="../main/authentication-login.html" class="btn btn-outline-primary">Log Out</a>
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
