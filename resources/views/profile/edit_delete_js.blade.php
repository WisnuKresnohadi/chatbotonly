<script>
    function editData(e) {
    let dataTarget = e.attr('data-target-modal');
    let dataId = e.attr('data-id');
    let modal = $('#' + dataTarget);

    let modalTitle = modal.find('.modal-title');
    if (modalTitle.attr('data-label-edit') !== undefined) {
      let text = modalTitle.attr('data-label-edit');
      modalTitle.html(text);
    }

    modal.modal('show');
    
    let overlay = $(`
        <div class="modal-overlay">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `);
    
    if(dataTarget == 'modalEditInformasiPribadi'){
      modal.find('.modal-content').append(overlay);
    }

    let data = { section: dataTarget };
    if (dataId != null) {
      Object.assign(data, { data_id: dataId });
      modal.find('form').prepend(`<input type="hidden" name="data_id" value="${dataId}">`);
    }

    $.ajax({
      url: `{{ route('profile.get_data') }}`,
      type: 'GET',
      data: data,
      success: function (response) {
        response = response.data;

        if (response['countries'] === null) {
          overlay.remove();
        }

        $.each(response, function (key, value) {
          
          if (value == null) return;
          
          let element = modal.find(`[name="${key}"]`);
          if (modal.find(`div[data-repeater-list="${key}"]`).length > 0) {
            value = JSON.parse(value);

            // formRepeaterCustom.isFirstItemUndeletable(true); //why it doesnt work?
            if(value.length > 0){
              formRepeaterCustom.setList(value);
            }

          } else if (element.is(':radio')) {

            modal.find(`[name="${key}"][value="${value}"]`).prop('checked', true);

          } else if ($(`select[name^="${key}"]`).prop('multiple')) {

              let option = $(`select[name^="${key}"] option`);
              value = JSON.parse(value);

              let newOption = value.filter(function ( item ) {
                  return !option.is(`[value="${item}"]`);
              });

              newOption.map(function ( item ) {
                  $(`select[name^="${key}"]`).append(`<option value="${item}" selected>${item}</option>`);
              });
              
              $(`select[name^="${key}"] option`).each(function () {
                if (value.includes($(this).val())) {
                    $(this).prop('selected', true);
                }
              });

              initSelect2();

          } else if (element.is(':file')) {

            let parent = element.parents('.form-group');
            let label = parent.find('label');
            label.wrap(`<div class="d-flex justify-content-start"></div>`);
            label.parent().append(`<a href="{{ url('storage') }}/${value}" target="_blank" id="sertif_open" class="ms-2"><small><i>Existing File</i></small></a>`);

          } else if (key == 'profile_picture') {
            $('#imgPreview2').attr('src', value);
            $('#imgPreview2').attr('default-src', value);
          } else {

            element.val(value).trigger('change');

            if (element.hasClass('flatpickr-date')) {
              element.flatpickr({
                  altInput: true,
                  altFormat: 'j F Y',
                  dateFormat: 'Y-m-d',
                  defaultDate: value
              });
            }

            if (element.hasClass('month-picker')) {
              element.flatpickr({
                plugins: [
                    new monthSelectPlugin({
                        defaultDate: value,
                        shorthand: true,
                        dateFormat: "F Y",
                        altFormat: "F Y",
                    })
                ]
              });
            }
          }
          if(key == 'countries'){
            if(value == 1){
              $('#citizenships').val('WNI').trigger('change');
            } else {
              $('#citizenships').val('WNA').trigger('change');
            }

            let checkDataProcess = setInterval(checkData, 400);

            function checkData() {
              if (!$('#kota_id').val()) {
                if (!$('#provinces').val()) {
                  if (!$('#countries').val()) {
                      $('#countries').val(response.countries).trigger('change');
                  }else{
                    $('#provinces').val(response.provinces).trigger('change');
                  }
                }else{
                  $('#kota_id').val(response.kota_id).trigger('change');
                }
              }else{
                clearInterval(checkDataProcess);
                overlay.remove();
              }
            };
          }
        });
      },
        error: function () {
            overlay.remove();
        }
    });
  }

  function deleteData(e) {
    let url = e.data('url');
    let dataFunction = e.attr('data-function');

    sweetAlertConfirm({
        title: 'Apakah anda yakin?',
        text: 'Ingin menghapus data ini.',
        icon: 'warning',
        confirmButtonText: 'Ya, saya yakin!',
        cancelButtonText: 'Batal'
    }, function () {
        $.ajax({
            url: url,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (!response.error) {
                    showSweetAlert({
                        title: 'Berhasil!',
                        text: response.message,
                        icon: 'success'
                    });

                    if (typeof window[dataFunction] === "function") window[dataFunction](response);
                } else {
                    showSweetAlert({
                        title: 'Gagal!',
                        text: response.message,
                        icon: 'error'
                    });
                }
            },
            error: function (xhr, status, error) {
                let res = xhr.responseJSON;
                showSweetAlert({
                    title: 'Gagal!',
                    text: res.message,
                    icon: 'error'
                });
            }
        });
    });
  }

  function initFormRepeaterCustom() {
    var row = 2;
    var col = 1;

    formRepeaterCustom = $('.form-repeater-custom');

    formRepeaterCustom.repeater({
      show: function () {
          var fromControl = $(this).find('.form-control, .form-select, .form-check-input');
          var formLabel = $(this).find('.form-label, .form-check-label');

          fromControl.each(function (i) {
              var id = 'form-repeater-' + row + '-' + col;
              $(fromControl[i]).attr('id', id);
              $(formLabel[i]).attr('for', id);
              col++;
          });

          row++;

          // fix select2
          initSelect2();
          // --------------------------------------------

          $('#hidden-sosmedmhs').find('.invalid-feedback').html(null).removeClass('d-block');
          $(this).slideDown();
      },
      isFirstItemUndeletable: true,
      hide: function (e) {
          let confirm_ = confirm('Are you sure you want to delete this element?');
          if (!confirm_) return;

          $(this).slideUp(e);
      }
    });

    return formRepeaterCustom;
  }
</script>