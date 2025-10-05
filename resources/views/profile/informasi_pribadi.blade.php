@extends('partials.horizontal_menu')

@section('page_style')
    <link rel="stylesheet" href="{{ url('assets/css/yearpicker.css') }}" />

    <style>
        .hidden {
            display: none;
        }

        .show{
          display: block;
        }
        .skill-badge-container{
          display: flex;
          flex-wrap: wrap;
          gap: 10px;
          transition-property: all;
          transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
          transition-duration: 150ms;
        }

        .badge-new{
          background-color: #4EA971;
          text-align: center;
          color: white;
          font-size: 0.8rem;
          padding: 0.2rem;
        }
    </style>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="sec-title mt-4 mb-4">
            @if (request()->has('lamaran') && request()->lamaran != null)
                <a href="{{ 'apply-lowongan/lamar/'.request()->lamaran }}" class="btn btn-outline-primary mb-4">
                    <i class="ti ti-arrow-left me-2 text-primary"></i>
                    Kembali ke lamaran
                </a>
            @endif

            {{-- Di view/blade --}}
            {{-- Error ekstraksi di halaman utama --}}
            @if ($errors->any() && !session('showModal'))
            <div class="alert alert-danger" role="alert" id="alert-content">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
            @endif

            {{-- Di dalam modal --}}
            <div class="modal" id="uploadModal">
                {{-- Error validasi hanya di modal --}}
                @if ($errors->any() && session('showModal'))
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-6 pe-5">
                    <h4>Profil Saya</h4>
                </div>
                <div class="col-4 ps-5 pe-0" id="percentage_container">
                    @include('profile.components.percentage')
                </div>

                <div class="col-2 text-end ps-0">
                    <button class="btn btn-secondary buttons-collection btn-label-success ms-4 mt-2" data-bs-toggle="modal" data-bs-target="#modelUploadCV" type="button">
                        <span> 
                            <span class="d-none d-sm-inline-block">Import CV</span>
                            </span>
                    </button>
                </div>
            </div>
            <!-- Modal-Upload File CV -->
            <div class="modal fade" id="modelUploadCV" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Upload CV</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route("uploadCV") }}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="modal-body">
                                <div class="mb-1">
                                    <label for="formFile" class="form-label">Unggah file<span class="text-danger">*</span></label>
                                    <input class="form-control @error('cv_file') is-invalid @enderror" type="file" id="formFile" name="cv_file" required>
                                    <small class="form-text text-muted">Tipe file: PDF Maximum upload file size: 2MB</small>
                                    @error('cv_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-5 mx-auto">
                                    <a href="{{ asset('template-excel/Template_Import_Mahasiswa.xlsx') }}" class="btn btn-primary w-100" id="download-template">Download Template</a>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button class="btn btn-primary me-md-2" type="submit">Simpan</button>
                                </div>
                            </div>
                    </form>
                    </div>
                </div>
            </div>
            <!-- Modal-Validasi Upload CV -->
            <div class="modal fade" id="modelValidationCV" tabindex="-1" aria-labelledby="modelValidationCVLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header d-flex justify-content-center align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" id="dangertriangle" width="120" height="120" viewBox="1 2 22 20" transform="translate(-5, -2)">
                                    <path fill="#fdd73b" fill-rule="evenodd" d="M9.47297 5.40432C8.49896 6.64148 7.43704 8.51988 5.96495 11.1299L5.60129 11.7747C4.37507 13.9488 3.50368 15.4986 3.06034 16.6998C2.6227 17.8855 2.68338 18.5141 3.02148 18.9991C3.38202 19.5163 4.05873 19.8706 5.49659 20.0599C6.92858 20.2484 8.9026 20.25 11.6363 20.25H12.3636C15.0974 20.25 17.0714 20.2484 18.5034 20.0599C19.9412 19.8706 20.6179 19.5163 20.9785 18.9991C21.3166 18.5141 21.3773 17.8855 20.9396 16.6998C20.4963 15.4986 19.6249 13.9488 18.3987 11.7747L18.035 11.1299C16.5629 8.51987 15.501 6.64148 14.527 5.40431C13.562 4.17865 12.8126 3.75 12 3.75C11.1874 3.75 10.4379 4.17865 9.47297 5.40432ZM8.2944 4.47643C9.36631 3.11493 10.5018 2.25 12 2.25C13.4981 2.25 14.6336 3.11493 15.7056 4.47643C16.7598 5.81545 17.8769 7.79626 19.3063 10.3306L19.7418 11.1027C20.9234 13.1976 21.8566 14.8523 22.3468 16.1804C22.8478 17.5376 22.9668 18.7699 22.209 19.8569C21.4736 20.9118 20.2466 21.3434 18.6991 21.5471C17.1576 21.75 15.0845 21.75 12.4248 21.75H11.5752C8.9155 21.75 6.8424 21.75 5.30082 21.5471C3.75331 21.3434 2.52637 20.9118 1.79099 19.8569C1.03318 18.7699 1.15218 17.5376 1.65314 16.1804C2.14334 14.8523 3.07658 13.1977 4.25818 11.1027L4.69361 10.3307C6.123 7.79629 7.24019 5.81547 8.2944 4.47643Z" clip-rule="evenodd" class="color854d9c svgShape"></path>
                                    <path fill="#d3b94e" fill-rule="evenodd" d="M12 7.25C12.4142 7.25 12.75 7.58579 12.75 8V13C12.75 13.4142 12.4142 13.75 12 13.75C11.5858 13.75 11.25 13.4142 11.25 13V8C11.25 7.58579 11.5858 7.25 12 7.25Z" clip-rule="evenodd" class="colorcd4ed3 svgShape"></path>
                                    <path fill="#d3b94e" d="M13 16C13 16.5523 12.5523 17 12 17C11.4477 17 11 16.5523 11 16C11 15.4477 11.4477 15 12 15C12.5523 15 13 15.4477 13 16Z" class="colorcd4ed3 svgShape"></path>
                                </svg>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center">
                                <h4><strong>Yakin untuk mengunggah file CV ini?</strong></h4>
                                <p>Periksa dan pastikan kembali File CV anda telah benar. Karena CV tidak dapat diubah jika proses lamaran telah terkirim dan proses seleksi telah dimulai</p>
                            </div>
                            <div class="alert alert-primary d-flex align-items-start p-2 g-2" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" class="bi flex-shrink-0" role="img" aria-label="info:" widht="20" height="20" viewBox=" 0 0 20 20" class="align-middle">
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                </svg>
                                <div>
                                    File CV akan digunakan untuk proses seleksi dan akan mempengaruhi peluang keberhasilan proses seleksi.
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('validateCV') }}" method="POST">
                                @csrf
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0" id="container-info-detail">
                <!-- User Profile-->
                @include('profile.components.informasi_pribadi_detail')
            </div>

            <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                <!-- User Pills -->
                @include('profile.components.tab_profile')
                <!--/ User Pills -->
                <!-- Content -->
                <div class="tab-content p-0">
                    <!-- <pendidikan> -->
                    @include('profile.components.pendidikan')
                    <!-- </pendidikan> -->

                    <!-- Informasi Tambahan -->
                    @include('profile.components.informasi_tambahan')
                    <!-- /Informasi Tambahan -->                    

                    <!-- <Keahlian&Pengalaman> -->
                    @include('profile.components.keahlian')
                    {{-- @dd($skills) --}}
                    <!-- </Keahlian&Pengalaman> -->

                    <!-- <Dokumen Pendukung> -->
                    @include('profile.components.dokumen_pendukung')
                </div>
                <!-- </Content> -->
            </div>
        </div>
    </div>

    @include('profile.components.modal')
@endsection

@section('page_script')
<script>
  let formRepeaterCustom;
  $(document).ready(function () {
    formRepeaterCustom = initFormRepeaterCustom();
    const ids = ["citizenships", "countries", "provinces", "id_kota"];
    ids.forEach(function(item) {
        if (item != "id_kota") {
            $('#' + item).on('change', function() {
                var value = $(this).val();
                var type = item;
                var targetId = $(this).data('target-dropdown');

                if(value != '' && value != null) {
                $.ajax({
                    url: `{{ route('wilayah.child') }}`,
                    data: {
                        type: type,
                        id: value,
                        '_token': '{{ csrf_token() }}'
                    },
                    method: 'POST',
                    success: function(data) {
                        var options = data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.name
                            };
                        });
                        options.unshift({
                            id: '',
                            text: 'Pilih'
                        });
                        $(targetId).empty();
                        initSelect2(targetId, options);

                        if (type === 'citizenships' && value === 'WNI') {
                            $('#countries').val(1).trigger('change');
                            $('#countries').prop('disabled', true);
                        } else if (type === 'citizenships' && value === 'WNA') {
                            $('#countries').val('').trigger('change').prop('disabled', false);
                            $('#kota_id, #provinces').val('').trigger('change').prop('disabled', true).empty();
                        } else if (type === 'countries' && value != '') {
                            $('#provinces').val('').trigger('change').prop('disabled', false);
                            $('#kota_id').val('').trigger('change').prop('disabled', true).empty();
                        } else if (type === 'provinces' && value != '') {
                            $('#kota_id').val('').trigger('change').prop('disabled', false);
                        }
                    }
                });
                }
            });
        }
    });
  });

  $('#changePicture').on('change', function (event) {
      let file = event.target.files[0];
      if (file) {
          $('#imgPreview2').attr('src', URL.createObjectURL(file));
      } else {
          $('#imgPreview2').attr('src', "{{ asset('app-assets/img/avatars/user.png') }}");
      }
  });

  $('#toggleButton').click(function() {  
      $('#container-keahlian .badge-new').toggleClass('show');
      $('#container-keahlian').toggleClass('h-full')
      if ($('#container-keahlian .badge-new').hasClass('show')) {    
        $(this).html('<span>Show Less</span><i class="ti ti-chevron-up"></i>');    
      } else {    
          $(this).html('<span>Show More</span><i class="ti ti-chevron-down"></i>');    
      }   
  }); 
  
  function removeImage() {
      $('#formEditInformasi').find('input[name="remove_image"]').remove();
      $('#formEditInformasi').prepend(`<input type="hidden" name="remove_image" value="1">`);
      $('#imgPreview2').attr('src', "{{ asset('app-assets/img/avatars/user.png') }}");
  }

  $('#modalEditInformasi').on('hide.bs.modal', function () {
      $('#formEditInformasi').find('input[name="remove_image"]').remove();
      let defaultSrc = $('#imgPreview2').attr('default-src');
      $('#imgPreview2').attr('src', defaultSrc);
  });

  $('.accordion-collapse').on('hidden.bs.collapse', function () {      
      const collapseId = $(this).attr('id');
      $(`button[data-bs-target="#${collapseId}"]`).text("Selengkapnya");
  });

  $('.accordion-collapse').on('shown.bs.collapse', function () {      
      const collapseId = $(this).attr('id');
      $(`button[data-bs-target="#${collapseId}"]`).text("Sembunyikan");
  });

  function showMore(element) {
    var content = element.previousElementSibling;
    var isShowMore = element.innerText === "Show More";
    var deskripsi = $(element).attr("data-deskripsi");

    var lessContent = deskripsi.substring(0, 100) + "...";            

    if (isShowMore) {
        content.innerHTML = deskripsi;
        element.innerText = "Show Less";
    } else {
        content.innerHTML = lessContent;
        element.innerText = "Show More";
    }            
}


  function afterUpdateDetailInfo(response) {
    response = response.data
    let resourceGambar = response.image ?? "{{ asset('app-assets/img/avatars/user.png') }}";
    $('#imgPreview2').attr('src', resourceGambar);
    $('#imgPreview2').attr('default-src', resourceGambar);
    $('#container-info-detail').html(response.view)
    $('#modalEditInformasi').modal('hide');
    updatePercentage()
  }

  function afterActionInfoTambahan(response) {
    response = response.data
    $('#container-informasi-tambahan').html(response.view)
    $('#modalEditInformasiTambahan').modal('hide');
    updatePercentage()
  }

  function afterActionEducation(response) {
    $('#modalTambahPendidikan').modal('hide');
    afterDeletePendidikan(response);
    updatePercentage()
  }

  function afterDeletePendidikan(response) {
    $('#container-pendidikan').html(response.data.view);
    updatePercentage()
  }

  function afterActionSkill(response) {
    $('#modalTambahKeahlian').modal('hide');
    $('#container-keahlian').html(response.data.view);

    $('#toggleButton').click(function() {  
      $('#container-keahlian .badge-new').toggleClass('show');
      $('#container-keahlian').toggleClass('h-full');
      if ($('#container-keahlian .badge-new').hasClass('show')) {    
        $(this).html('<span>Show Less</span><i class="ti ti-chevron-up"></i>');    
      } else {    
          $(this).html('<span>Show More</span><i class="ti ti-chevron-down"></i>');    
      } 
    }); 

    updatePercentage()
  }

  function afterActionExperience(response, element = $(this)) {
      $('#modalTambahPengalaman').modal('hide');
      afterDeleteExperience(response);
      updatePercentage();      
  }

  function afterDeleteExperience(response) {     
      $('#container-pengalaman').html(response.data.view);
      updatePercentage();
      openNearestAccordion('#container-pengalaman'); // Kirim selector kontainer
  }

  function afterActionProjectExperience(response) {
      $('#modalTambahProyek').modal('hide');
      afterDeleteProjectExperience(response);
      updatePercentage();      
  }

  function afterDeleteProjectExperience(response) {     
      $('#container-project').html(response.data.view);
      updatePercentage();
      openNearestAccordion('#container-project'); // Kirim selector kontainer
  }

  function afterActionCompetition(response) {
      $('#modalTambahKompetisi').modal('hide');
      afterDeleteCompetition(response);
      updatePercentage();      
  }

  function afterDeleteCompetition(response) {     
      $('#container-competition').html(response.data.view);
      updatePercentage();
      openNearestAccordion('#container-competition'); // Kirim selector kontainer
  }

  function afterActionDokumen(response) {
      $('#modalTambahDokumen').modal('hide');
      afterDeleteDokumen(response);
      updatePercentage();      
  }

  function afterDeleteDokumen(response) {
      $('#container-dokumen-pendukung').html(response.data.view);
      updatePercentage();
      openNearestAccordion('#container-dokumen-pendukung'); // Kirim selector kontainer
  }

  function openNearestAccordion(containerSelector) {
      const closestAccordion = $(containerSelector).find('.btn-collapse');    
              
      if (closestAccordion) {
        console.log(closestAccordion)
          closestAccordion.click()      
          $('.accordion-collapse').on('hidden.bs.collapse', function () {      
      const collapseId = $(this).attr('id');
      $(`button[data-bs-target="#${collapseId}"]`).text("Selengkapnya");
  });

  $('.accordion-collapse').on('shown.bs.collapse', function () {      
      const collapseId = $(this).attr('id');
      $(`button[data-bs-target="#${collapseId}"]`).text("Sembunyikan");
  });  
      }
  }

function updatePercentage() {
   $.ajax({
      url: `{{ route('profile.percentage') }}`,
      method: 'GET',
      success: function (response) {
        $('#percentage_container').html(response.data.view);
        $(function () {
          $('[data-bs-toggle="tooltip"]').tooltip()
        })
      }
    });
}

  $('.modal').on('hide.bs.modal', function () {
    let modalTitle = $(this).find('.modal-title');
    if (modalTitle.attr('data-label-default') !== undefined) modalTitle.html(modalTitle.attr('data-label-default'));
    $(this).find('form').find('input[name="data_id"]').remove();
    $(this).find('form').find('a[id="sertif_open"]').unwrap();
    $(this).find('form').find('a[id="sertif_open"]').remove();
    $('#countries').prop('disabled', true).empty();
    $('#provinces').prop('disabled', true).empty();
    $('#kota_id').prop('disabled', true).empty();
    formRepeaterCustom.find('[data-repeater-item]').slice(1).empty();    
  });

  document.getElementById('unduhProfileBtn').addEventListener('click', function() {
    window.open('/profile/unduh-cv', '_blank');
  });

</script>

@include('profile/edit_delete_js')
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
      @if(session('showModal'))
          var myModal = new bootstrap.Modal(document.getElementById('modelUploadCV'));
          myModal.show();
      @endif
  });
</script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
      @if(session('showValidationModal'))
          var myModal = new bootstrap.Modal(document.getElementById('modelValidationCV'));
          myModal.show();
      @endif
  });
</script>