@extends($layout)

@push('link')
<style>
.avatar-img {
  width: 120px;
  height: 120px;
  object-fit: cover;
  object-position: center;
  border-radius: 50%;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
@endpush

@section('title')
    SiTAW | Tambah Kategori
@endsection

@section('content')
<div class="container-fluid">
  <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
      <div class="row align-items-center">
        <div class="col-9">
          <h4 class="fw-semibold mb-8">Account Setting</h4>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
              </li>
              <li class="breadcrumb-item" aria-current="page">Account Setting</li>
            </ol>
          </nav>
        </div>
        <div class="col-3">
          <div class="text-center mb-n5">
            <img src="../assets/images/breadcrumb/ChatBc.png" alt="modernize-img" class="img-fluid mb-n4" />
          </div>
        </div>
      </div>
    </div>
  </div>
  @if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
  <div class="card">
    <ul class="nav nav-pills user-profile-tab" id="pills-tab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link position-relative rounded-0 active d-flex align-items-center justify-content-center bg-transparent fs-3 py-3" id="pills-account-tab" data-bs-toggle="pill" data-bs-target="#pills-account" type="button" role="tab" aria-controls="pills-account" aria-selected="true">
          <i class="ti ti-user-circle me-2 fs-6"></i>
          <span class="d-none d-md-block">Edit Profile</span>
        </button>
      </li>
    </ul>
    <form action="{{ route($routeName) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PATCH')
    <div class="card-body">
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-account" role="tabpanel" aria-labelledby="pills-account-tab" tabindex="0">
          <div class="row">
            <div class="row d-flex justify-content-center">
            <div class="col-lg-6 d-flex align-items-stretch">
              <div class="card w-100 border position-relative overflow-hidden">
                <div class="card-body p-4">
                  <h4 class="card-title">Change Profile</h4>
                  <p class="card-subtitle mb-4">Change your profile picture from here</p>
                  <div class="text-center">
                    <img id="uploadedAvatar"
                    src="{{ $user->usr_profile_photo 
                      ? asset('storage/' . $user->usr_profile_photo) 
                      : asset('assets/images/profile/user-1.jpg') }}"
                    alt="profile-photo"
                    class="img-fluid rounded-circle avatar-img"
                    width="120" height="120">                  

                   <div class="d-flex align-items-center justify-content-center my-4 gap-3">
                      <label for="profile_photo" class="btn btn-primary me-3" tabindex="0">
                        <span class="d-none d-sm-block">Upload</span>
                        <i class="icon-base ti tabler-upload d-block d-sm-none"></i>
                        <input type="file" id="profile_photo" name="profile_photo" class="account-file-input" hidden accept="image/png, image/jpeg" />
                      </label>
                      <input type="hidden" id="croppedImage" name="croppedImage">
                    
                      <button type="button" id="resetPhoto" class="btn bg-danger-subtle text-danger">Reset</button>
                    </div>
                    
                    <p class="mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                  </div>
                </div>
              </div>
            </div>
            </div>
            {{-- <div class="col-lg-6 d-flex align-items-stretch">
              <div class="card w-100 border position-relative overflow-hidden">
                <div class="card-body p-4">
                  <h4 class="card-title">Change Password</h4>
                  <p class="card-subtitle mb-4">To change your password please confirm here</p>
                  {{-- <form> 
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Current Password</label>
                      <input type="password" class="form-control" id="exampleInputPassword1" value="12345678910">
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputPassword2" class="form-label">New Password</label>
                      <input type="password" class="form-control" id="exampleInputPassword2" value="12345678910">
                    </div>
                    <div>
                      <label for="exampleInputPassword3" class="form-label">Confirm Password</label>
                      <input type="password" class="form-control" id="exampleInputPassword3" value="12345678910">
                    </div>
                  {{-- </form> 
                </div>
              </div>
            </div> --}}
            <div class="col-12">
              <div class="card w-100 border position-relative overflow-hidden mb-0">
                <div class="card-body p-4">
                  <h4 class="card-title">Detail Pribadi</h4>
                  <p class="card-subtitle mb-4">Untuk mengubah detail pribadi Anda, edit dan simpan dari sini</p>
                  {{-- <form> --}}
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label for="exampleInputtext" class="form-label">Nama</label>
                          <input type="text" class="form-control" id="usr_name" name="usr_name" value="{{ old('usr_name', $user->usr_name) }}">
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Tempat Lahir</label>
                          <input type="text" class="form-control" type="usr_birthplace" id="usr_birthplace" name="usr_birthplace" value="{{ old('usr_birthplace', $user->usr_birthplace) }}">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputtext1" class="form-label">Email</label>
                          <input type="email" class="form-control" type="email" id="email" name="email" value="{{ old('email', $user->email) }}">
                        </div>
                       
                      </div>
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label for="usr_nik" class="form-label">Nomor NIK</label>
                          <input type="text" 
                                 class="form-control" 
                                 id="usr_nik" 
                                 name="usr_nik" 
                                 value="{{ old('usr_nik', $user->usr_nik) }}"
                                 maxlength="16"
                                 oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                        
                        <div class="mb-3">
                          <label class="form-label">Tanggal Lahir</label>
                          <input type="date" class="form-control" type="usr_birthdate" id="usr_birthdate" name="usr_birthdate" value="{{ old('usr_birthdate', $user->usr_birthdate) }}">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputtext3" class="form-label">Phone</label>
                          <div class="input-group input-group-merge">
                            <span class="input-group-text">ID (+62)</span>
                          <input type="text" id="usr_telephone" name="usr_telephone" class="form-control"  placeholder="81234567890"  value="{{ old('usr_telephone', $user->usr_telephone) }}"  pattern="^[0-9]{8,12}$"
                          maxlength="12"/>
                        </div>
                        </div>
                      </div>
                      
                      <div class="col-12">
                        <div>
                          <label for="exampleInputtext4" class="form-label">Address</label>
                          <input type="text" class="form-control" type="usr_address" id="usr_address" name="usr_address" value="{{ old('usr_address', $user->usr_address) }}">
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="d-flex align-items-center justify-content-end mt-4 gap-6">
                          <button class="btn btn-primary">Save</button>
                          <button class="btn bg-danger-subtle text-danger">Cancel</button>
                        </div>
                      </div>
                    </div>
                    <!-- Modal Crop -->
                    <div class="modal fade" id="cropModal" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog"  style="max-width:350px;">
                        <div class="modal-content p-3">
                          <div class="modal-header">
                            <h5 class="modal-title">Atur Foto Profil</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body d-flex justify-content-center">
                            <img id="cropImage" style="max-width:100%; display:block;">
                          </div>
                          <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button id="btnCrop" type="button" class="btn btn-primary">Crop & Apply</button>
                          </div>
                        </div>
                      </div>
                    </div>

                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

{{-- <script>
  const inputFile = document.getElementById('profile_photo');
  const imgPreview = document.getElementById('uploadedAvatar');
  const resetBtn = document.getElementById('resetPhoto');

  const defaultImage = imgPreview.src; // simpan gambar awal

  inputFile.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      imgPreview.src = URL.createObjectURL(file);
    }
  });

  resetBtn.addEventListener('click', function() {
    imgPreview.src = defaultImage; // balikin ke gambar awal
    inputFile.value = ""; // hapus input file
  });
</script> --}}
<script>
  let cropper;
const inputFile = document.getElementById('profile_photo');
const imgPreview = document.getElementById('uploadedAvatar');
const resetBtn = document.getElementById('resetPhoto');
const defaultImage = imgPreview.src;

inputFile.addEventListener("change", function(e){
  const file = e.target.files[0];
  if (!file) return;

  const reader = new FileReader();
  reader.onload = function (event) {
    document.getElementById("cropImage").src = event.target.result;

    // muncul modal
    const cropModal = new bootstrap.Modal(document.getElementById("cropModal"));
    cropModal.show();

    // Inisialisasi cropper
    setTimeout(() => {
      cropper = new Cropper(document.getElementById("cropImage"), {
        aspectRatio: 1,
        viewMode: 1,
        movable: true,
        scalable: false,
        zoomable: true,
        background: false,
      });
    }, 200);
  };
  reader.readAsDataURL(file);
});

// Tombol Crop
document.getElementById("btnCrop").onclick = function () {
  const canvas = cropper.getCroppedCanvas({ width: 400, height: 400 });

  imgPreview.src = canvas.toDataURL("image/png");

  canvas.toBlob((blob) => {
    const file = new File([blob], "profile.png", { type: "image/png" });
    const dataTransfer = new DataTransfer();
    dataTransfer.items.add(file);
    inputFile.files = dataTransfer.files;

    document.getElementById("croppedImage").value = canvas.toDataURL("image/png");
  });

  bootstrap.Modal.getInstance(document.getElementById("cropModal")).hide();
};

// Reset ke foto awal
resetBtn.addEventListener("click", function () {
  imgPreview.src = defaultImage;
  inputFile.value = "";
});

  // const inputFile = document.getElementById('profile_photo');
  // const imgPreview = document.getElementById('uploadedAvatar');
  // const resetBtn = document.getElementById('resetPhoto');
  // const defaultImage = imgPreview.src;

  // let cropper;
  // let tempImage = document.createElement("img");
  // tempImage.style.maxWidth = "100%";
  // tempImage.style.display = "none"; 
  // document.body.appendChild(tempImage);

  // // Saat pilih file
  // inputFile.addEventListener("change", function(e){
  //   const file = e.target.files[0];
  //   if(!file) return;

  //   const reader = new FileReader();
  //   reader.onload = function(event){
  //     tempImage.src = event.target.result;
  //     showCropperModal(event.target.result);
  //   }
  //   reader.readAsDataURL(file);
  // });

  // // Modal cropper
  // function showCropperModal(image){
  //   let modal = document.createElement("div");
  //   modal.innerHTML = `
  //     <div style="
  //       position:fixed; top:0; left:0; width:100%; height:100%;
  //       background:rgba(0,0,0,0.7); display:flex; justify-content:center; align-items:center; z-index:9999;">
  //       <div style="background:#fff; padding:20px; border-radius:10px;">
  //         <img id="cropImage" src="${image}" style="max-width:400px;">
  //         <div class="text-center mt-3">
  //           <button id="btnCrop" class="btn btn-primary me-3">Crop</button>
  //           <button id="btnCancel" class="btn btn-secondary">Cancel</button>
  //         </div>
  //       </div>
  //     </div>`;
  //   document.body.appendChild(modal);

  //   const cropImage = document.getElementById("cropImage");
  //   cropper = new Cropper(cropImage, {
  //     aspectRatio: 1,
  //     viewMode: 1,
  //     movable: true,
  //     zoomable: true,
  //     background: false
  //   });

  //   document.getElementById("btnCrop").onclick = () => {
  //     const canvas = cropper.getCroppedCanvas({ width: 300, height: 300 });
  //     imgPreview.src = canvas.toDataURL("image/png");
  //     modal.remove();
  //   };

  //   document.getElementById("btnCancel").onclick = () => modal.remove();
  // }

  // // RESET FOTO
  // resetBtn.addEventListener("click", function(){
  //   imgPreview.src = defaultImage;
  //   inputFile.value = "";
  // });
</script>


    
@endpush