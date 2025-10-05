$('.breadcumbs-header-custom').each(function () {
    $(this).find('ol').find('li:last-child').addClass('active');
});

$(document).on("keydown", ":input:not(textarea)", function (event) {
    if (event.key == "Enter") {
        event.preventDefault();
    }
});

$(document).on('keyup change paste', '.default-form input, .default-form select, .default-form textarea', function () {
    if ($(this).attr('type') == 'radio' || $(this).attr('type') == 'checkbox') {
        let nameElement = $(this).attr('name');
        $(`[name="${nameElement}"]`).each(function () {
            $(this).removeClass('is-invalid');
        });
    } else {
        $(this).removeClass("is-invalid");
    }
    $(this).parents(".form-group").find(".invalid-feedback").html(null).removeClass("d-block");
    $(this).parents(".form-group").find(".is-invalid").removeClass("is-invalid");
});

$(document).ready(function () {
    initAllComponents();
});

function initAllComponents() {
    initSelect2();
    initPopOver();
    initTooltips();
    initFormRepeater();
    initDataFilter();
}

function initSelect2(element = null, data = null) {
    let options =
        {
            tags: $(element).attr('data-tags') === 'true' ?? false,
            allowClear: true,
            placeholder: $(element).attr('data-placeholder') ?? null,
            dropdownAutoWidth: true,
            width: '100%',
            dropdownParent: $(element).parent(),
        }
    ;

    if(data != null) {
        options['data'] = data;
    }

    if (element != null) {
        if ($(element).hasClass("select2-hidden-accessible")) {
            $(element).select2("destroy");
        }
        $(element).select2(options);
        return;
    }

    $('select.select2').each(function () {
        if ($(this).hasClass("select2-hidden-accessible")) {
            $(this).removeClass('select2-hidden-accessible').next('.select2-container').remove();
            $(this).removeAttr('data-select2-id tabindex aria-hidden');
            $(this).parent().removeAttr('data-select2-id');
        }

        if (!$(this).parent().hasClass('position-relative')) $(this).wrap('<div class="position-relative"></div>');

        $(this).select2({
            tags: $(this).attr('data-tags') === 'true' ?? false,
            allowClear: $(this).attr('data-allow-clear') === 'true' ?? false,
            placeholder: $(this).attr('data-placeholder') ?? null,
            dropdownAutoWidth: true,
            width: '100%',
            dropdownParent: $(this).parent(),
        });
    });
}

function initPopOver() {
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    const popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
}

function initTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

function initFormRepeater() {
    var row = 2;
    var col = 1;
    let formRepeater = $('.form-repeater');

    if (formRepeater.length == 0) return;

    formRepeater.repeater({
        show: function () {
            let dataCallback = $(this).attr('data-callback');
            if (typeof window[dataCallback] === "function") window[dataCallback](this);

            var fromControl = $(this).find('.form-control, .form-select, .form-check-input');
            var formLabel = $(this).find('.form-label, .form-check-label');

            fromControl.each(function (i) {
                if (!$(this).hasClass('flatpickr-date')) {
                    var id = 'form-repeater-' + row + '-' + col;
                    $(fromControl[i]).attr('id', id);
                    $(formLabel[i]).attr('for', id);
                    col++;
                }
            });

            row++;

            // fix select2
            initSelect2();
            // --------------------------------------------

            $(this).slideDown();
        },
        hide: function (e) {
            let confirm_ = confirm('Are you sure you want to delete this element?');
            if (!confirm_) return;
            let dataCallback = $(this).attr('data-callback');
            if (typeof window[dataCallback] === "function") window[dataCallback](this);

            $(this).slideUp(e);
        },
        isFirstItemUndeletable: true
    });
}

function btnBlock(element, bool = true) {
    if (bool) {
        element.block({
            message: '<div class="spinner-border text-light" role="status"></div>',
            css: {
                backgroundColor: 'transparent',
                color: '#fff',
                border: '0'
            },
            overlayCSS: {
                opacity: 0.5
            }
        });
    } else {
        element.unblock();
    }
}

function sectionBlock(element, bool = true) {
    if (bool) {
        element.block({
            message: '<div class="spinner-border text-light" role="status"></div>',
            css: {
                backgroundColor: 'transparent',
                color: '#fff',
                border: '0'
            },
            overlayCSS: {
                opacity: 0.5,
                backgroundColor: '#fff'
            }
        });
    } else {
        element.unblock();
    }
}

function pageBlock(bool = true) {
    if (bool) {
        $.blockUI({
            message: '<div class="d-flex justify-content-center"><p class="mb-0">Sedang memproses...</p> <div class="sk-wave m-0"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div> </div>',
            css: {
                backgroundColor: 'transparent',
                color: '#fff',
                border: '0'
            },
            overlayCSS: {
                opacity: 0.5
            }
        });
    } else {
        $.unblockUI();
    }
}

function sweetAlertConfirm(config, callback) {
    let title, text, icon, confirmButtonText;

    title = config.title ?? 'Are you sure?';
    text = config.text ?? "You won't be able to revert this!";
    icon = config.icon ?? 'warning';
    confirmButtonText = config.confirmButtonText ?? 'Yes, I do!';
    cancelButtonText = config.cancelButtonText ?? 'No, cancel!';
    showCancelButton = config.showCancelButton ?? false;
    reverseButton = config.reverseButton ?? false;
    allowOutsideClick = config.allowOutsideClick ?? true;
    allowEscapeKey = config.allowEscapeKey ?? true;
    customClassConfirm = config.customClassConfirm ?? 'btn btn-primary me-3';
    customClassCancel = config.customClassCancel ?? 'btn btn-label-secondary';

    return Swal.fire({
        html: '<h3>' + title + '</h3><p>' + text + '</p>',
        icon: icon,
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText,
        allowOutsideClick: allowOutsideClick,
        allowEscapeKey: allowEscapeKey,
        customClass: {
            confirmButton: customClassConfirm,
            cancelButton: customClassCancel
        },
        showCancelButton: showCancelButton,
        buttonsStyling: false,
        reverseButtons: reverseButton
    }).then(function (result) {
        if (result.isConfirmed) callback();
    });
}

function showSweetAlert(config) {
    let title, text, icon, didClose;

    title = config.title ?? '';
    text = config.text ?? 'The action was executed successfully.';
    icon = config.icon ?? 'success';
    showConfirmButton = config.showConfirmButton ?? true
    confirmButtonText = config.confirmButtonText ?? 'OK';
    showCancelButton = config.showCancelButton ?? false
    cancelButtonText = config.cancelButtonText ?? 'Batal';
    didClose = config.didClose ?? function () {};

    customClass = {
        confirmButton: 'btn btn-primary',
    }

    if(showCancelButton) {
        customClass['cancelButton'] = 'btn btn-outline-danger';
    }

    return Swal.fire({
        html: '<h3>' + title + '</h3><p>' + text + '</p>',
        icon: icon,
        showConfirmButton: showConfirmButton,
        confirmButtonText: confirmButtonText,
        showCancelButton: showCancelButton,
        cancelButtonText: cancelButtonText,
        customClass: customClass,
        didClose: didClose
    });
}

$(document).on("submit", ".default-form", function (event) {
    event.preventDefault();
    var button = $(this).find(":submit");
    btnBlock(button);
    store_data(this, button);
});

function store_data(content, button) {
    $("input").blur();

    $(content).find('.is-invalid').removeClass('is-invalid');
    $(content).find('.invalid-feedback').html(null).removeClass('d-block');

    let form_data = new FormData(content);
    let action = $(content).attr("action");
    let callback = $(content).attr("function-callback") ?? null;

    $.ajax({
        url: action,
        type: "POST",
        data: form_data,
        processData: false, // tell jQuery not to process the data
        contentType: false, // tell jQuery not to set contentType
        cache: false,
        success: function (response) {
            btnBlock(button, false);
            if (!response.error) {
                if (
                    (response.data == null) ||
                    (response.data != null && !response.data.ignore_alert)
                ) {
                    showSweetAlert({
                        title: response?.data?.title ?? 'Berhasil!',
                        text: response.message,
                        icon: response?.data?.icon ?? 'success',
                        showConfirmButton: response?.data?.showConfirmButton
                    });
                }

                if (typeof window[callback] === "function") window[callback](response);
            } else {
                showSweetAlert({
                    title: 'Gagal!',
                    text: response.message,
                    icon: 'error'
                });
            }
        },
        error: (xhr, status, error) => {
            btnBlock(button, false);
            let res = xhr.responseJSON;
            if (res.errors) {
                $.each(res.errors, function (key, value) {
                    // key = key.replace(/\.(\d+)\.(\w+)/g, "[$1][$2]");
                    // key = key.replace(/\./g, '[') + ']';

                    key = key.replace(/(\.\d+)(\.\w+)?/g, (match, p1, p2) => {
                        if (p2) {
                            return `[${p1.substring(1)}][${p2.substring(1)}]`;
                        } else if (p1) {
                            return `[${p1.substring(1)}]`;
                        }
                    });

                    if ($(`[name="${key}"]`, content).length > 0) {
                        $(`[name="${key}"]`, content).addClass('is-invalid');
                        $(`[name="${key}"]`, content).parents('.form-group').find('.invalid-feedback').html(value[0]).addClass('d-block');
                    } else {
                        $(`[name^="${key}"]`, content).addClass('is-invalid');
                        $(`[name^="${key}"]`, content).parents('.form-group').find('.invalid-feedback').html(value[0]).addClass('d-block');
                    }
                });
            } else {
                showSweetAlert({
                    title: 'Gagal!',
                    text: res.message,
                    icon: 'error'
                });
            }
        },
    }).always(function () {
        btnBlock(button, false);
    });
}

$('.modal').on('hide.bs.modal', function () {
    let form = $(this).find('form');

    form.trigger('reset');
    form.find('.select2').val(null).trigger('change');
    form.find('.select2_custom').val(null).trigger('change');
    form.find('.is-invalid').removeClass('is-invalid');
    form.find('.invalid-feedback').html(null).removeClass('d-block');

    // reset flatpickr
    form.find('.flatpickr-date').val(null).trigger('change');
    form.find('.flatpickr-date').flatpickr({
        altInput: true,
        altFormat: 'j F Y',
        dateFormat: 'Y-m-d'
    });
});

$(document).on('click', '.update-status', function () {
    let url = $(this).data('url');
    let dataFunction = $(this).attr('data-function');

    sweetAlertConfirm({
        title: 'Apakah anda yakin?',
        text: 'Anda akan mengubah status data ini.',
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
                        title: response?.data?.title ?? 'Berhasil!',
                        text: response.message,
                        icon: response?.data?.icon ?? 'success',
                        showConfirmButton: response?.data?.showConfirmButton
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
});

function initDataFilter(){
    let inputs = document.querySelectorAll('input[data-filter]');
    for (let input of inputs) {
    let state = {
        value: input.value,
        start: input.selectionStart,
        end: input.selectionEnd,
        pattern: RegExp('^' + input.dataset.filter + '$')
    };

    input.addEventListener('input', event => {
        if (state.pattern.test(input.value)) {
        state.value = input.value;
        } else {
        input.value = state.value;
        input.setSelectionRange(state.start, state.end);
        }
    });

    input.addEventListener('keydown', event => {
        state.start = input.selectionStart;
        state.end = input.selectionEnd;
    });
    }
}
