$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    let $float_nr   = $(".float-nr");
    let $integer_nr = $(".integer-nr");
    let $select2    = $(".select2");
    let $ajax_form  = $("form.ajax-form");
    let $date       = $("input.date:not(.flatpickr-input)");
    let $datetime   = $("input.datetime:not(.flatpickr-input)");

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "progressBar": true,
        "preventDuplicates": false,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "500",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    tippy('.tippy-btn', {
        arrow: true,
        animation: 'fade',
        placement: 'top',
        inertia: true,
    });

    if ($select2.length) {
        $select2.select2();
    }

    $float_nr.on("keypress keyup blur", function (event) {
        $(this).val($(this).val().replace(/[^0-9.]/g,''));
        if ((event.which !== 46 || $(this).val().indexOf('.') !== -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    $integer_nr.on("keypress keyup blur", function (event) {
        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    $date.flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "d/m/Y",
    });

    $datetime.flatpickr({
        enableTime: true,
        time_24hr: true,
        dateFormat: "Y-m-d H:i:s",
        altInput: true,
        altFormat: "d/m/Y H:i",
    });

    $ajax_form.attr('novalidate', 'novalidate');

    $('body').on('submit', 'form.ajax-form', function (event) {
        event.preventDefault();

        formAjax($(this));
    });

    $('body').on('click', '.action-button', function (event) {
        event.preventDefault();

        let $this = $(this),
            $actionModal = $('#action-modal'),
            $actionFormModal = $('#action-form-modal'),
            $actionFormButton = $('#action-form-button'),
            $actionFormInputs = $('#action-form-inputs'),
            $actionModalTitle = $('#action-title'),
            $actionModalMessage = $('#action-message'),
            method = $this.data('method'),
            action = $this.data('action'),
            title = $this.data('title'),
            message = $this.data('message'),
            isDanger = $this.data('is-danger') === 'true' || $this.data('is-danger') === true;

        if (method === 'PUT' || method === 'PATCH' || method === 'DELETE') {
            $actionFormModal.attr('method', 'POST');
            $actionFormInputs.html(`<input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}"><input type="hidden" name="_method" value="${method}">`);
        } else if (method === 'POST') {
            $actionFormModal.attr('method', 'POST');
            $actionFormInputs.html(`<input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">`);
        } else {
            $actionFormModal.attr('method', 'GET');
            $actionFormInputs.html('');
        }

        if (isDanger) {
            $actionFormButton.removeClass('btn-success');
            $actionFormButton.addClass('btn-danger');
        } else {
            $actionFormButton.addClass('btn-success');
            $actionFormButton.removeClass('btn-danger');
        }

        $actionModalTitle.html(title);
        $actionModalMessage.html(message);
        $actionFormModal.attr('action', action);
        $actionModal.modal('show');
    });
});

function formAjax($form, $submit_btn = null, async = true) {
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: new FormData($form[0]),
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        async: async,
        beforeSend: function() {
            showLoadSubmitButton($form, $submit_btn);
            clearFormErrors($form);
        },
        success: function(response){
            let data = response.data;

            if (! data.success) {
                toastr.error('Error!');
                location.reload();
            }

            if(data.success !== undefined && data.success){
                if(data.redirect_to !== undefined && data.redirect_to !== null && data.redirect_to.length > 0) {
                    if (window.location.href === data.redirect_to) {
                        location.reload();
                    } else {
                        window.location.href = data.redirect_to;
                    }
                }
            }
        },
        error: function(data){
            handleSubmitFormErrors($form, data);
        },
        complete: function () {
            hideLoadSubmitButton($form, $submit_btn);
        }
    });
}

function handleSubmitFormErrors($form, response) {
    let data = response.responseJSON;

    if (response.status === 422) {
        toastr.error('', data.message);

        $.each(data.errors, function(input, errorMessage){
            let inputName = input;

            if (input.indexOf(".") !== -1) {
                let inputParts = input.split(".");

                if (inputParts.length === 2 && typeof inputParts[1] === 'number') {
                    input = `[name="${inputParts[0]}[]"]:eq(${inputParts[1]})`;
                } else if (inputParts.length === 2 && typeof inputParts[1] !== 'number') {
                    input = `[name="${inputParts[0]}[${inputParts[1]}]"]`;
                } else if (inputParts.length === 3) {
                    input = `[name="${inputParts[0]}[${inputParts[1]}][${inputParts[2]}]"]`;
                } else if (inputParts.length === 4) {
                    input = `[name="${inputParts[0]}[${inputParts[1]}][${inputParts[2]}][${inputParts[3]}]"]`;
                }
            } else {
                input = `[name^=${input}]`;
            }

            let $input = $form.find(input),
                $inputMediaWrapper = $(`.${inputName}-wrapper`),
                $parent = $input.parents().closest('.tab-pane'),
                $mediaParent = $inputMediaWrapper.parents().closest('.tab-pane');
            $input.addClass('is-invalid');
            $input.siblings('span.invalid-feedback').html(errorMessage[0]);
            $input.parent().next('span.invalid-feedback').html(errorMessage[0]);

            $inputMediaWrapper.find('.livewire-list-error.media-library-hidden').addClass('media-library-listerrors');
            $inputMediaWrapper.find('.livewire-list-error.media-library-listerrors').removeClass('media-library-hidden');
            $inputMediaWrapper.find('.media-library-listerror-title').html(errorMessage[0]);

            if ($parent) {
                let $tabLink = $(`a[href="#${$parent.attr('id')}"]`);
                $tabLink.find('span.text-danger.asterisk').remove();
                $tabLink.append('<span class="text-danger asterisk ms-1">*</span>');
            }

            if ($mediaParent) {
                let $mediaTabLink = $(`a[href="#${$mediaParent.attr('id')}"]`);
                $mediaTabLink.find('span.text-danger.asterisk').remove();
                $mediaTabLink.append('<span class="text-danger asterisk ms-1">*</span>');
            }
        });
    } else {
        toastr.error(data.message, response.status);

        if(data.redirect_to !== undefined && data.redirect_to !== null && data.redirect_to.length > 0) {
            if (window.location.href === data.redirect_to) {
                location.reload();
            } else {
                window.location.href = data.redirect_to;
            }
        } else {
            location.reload();
        }
    }
}

function showLoadSubmitButton($form, $submit_btn = null) {
    if ($submit_btn !== null) {
        $submit_btn.attr('disabled', true);
        $submit_btn.find('i.fa').removeClass('d-none');
    } else {
        $form.find('button.submit-btn').attr('disabled', true);
        $form.find('button.submit-btn i.fa').removeClass('d-none');
    }
}

function hideLoadSubmitButton($form, $submit_btn = null) {
    if ($submit_btn !== null) {
        $submit_btn.attr('disabled', false);
        $submit_btn.find('i.fa').addClass('d-none');
    } else {
        $form.find('button.submit-btn').attr('disabled', false);
        $form.find('button.submit-btn i.fa').addClass('d-none');
    }
}

function clearFormErrors($form) {
    $form.find('input').next('span.invalid-feedback').html('');
    $form.find('input').parent().next('span.invalid-feedback').html('');
    $form.find('.is-invalid').removeClass('is-invalid');
    $form.find('span.text-danger.asterisk').remove();

    $('.livewire-list-error.media-library-listerrors').addClass('media-library-hidden');
    $('.livewire-list-error.media-library-hidden').addClass('media-library-listerrors');
    $('.media-library-listerror-title').html('');
}

/**
 * Add indexes to array inputs
 * @param selector
 * @returns {boolean}
 * @example addIndexesToArrayInputs('.array-inputs')
 */
function addIndexesToArrayInputs(selector) {
    $(selector).each(function (i) {
        $(this).find('input, select, textarea').each(function () {
            if ($(this) !== undefined && $(this).attr('name') !== undefined) {
                $(this).attr('name', $(this).attr('name').replace('[]', `[${i}]`));
                $(this).attr('name', $(this).attr('name').replace(/[[][0-9]{1,2}[\]]/g, `[${i}]`));

                if ($(this).attr('id')) {
                    $(this).attr('id', $(this).attr('id').replace('[]', `[${i}]`));
                    $(this).attr('id', $(this).attr('id').replace(/[[][0-9]{1,2}[\]]/g, `[${i}]`));
                }

                if ($(this).siblings('label').length > 0) {
                    $(this).siblings('label').attr('for', $(this).siblings('label').attr('for').replace('[]', `[${i}]`));
                    $(this).siblings('label').attr('for', $(this).siblings('label').attr('for').replace(/[[][0-9]{1,2}[\]]/g, `[${i}]`));
                }
            }
        });
    });
}

/**
 * Fill a select2 element with the data from the url
 * @param id
 * @param selector
 * @param url
 * @param key
 * @param value
 * @example fillSelect2Element(1, $('#user_id'), '{{ route('admin.users.search') }}')
 */
function fillSelect2Element(id, url, selector, key = 'id', value = 'label') {
    $.ajax({
        type: 'GET',
        url: url,
        data: {
            id: stringToArray(id, true),
        },
    }).then(function (data) {
        if (data.length) {
            //For each one we create the option and append it to the select
            $.each(data, function (id, element) {
                if (! selector.children('option[value=' + element[key] + ']:selected').length) {
                    let option = new Option(element[value], element[key], true, true);
                    selector.append(option);
                }
            });
            selector.trigger('change');
            selector.trigger({
                type: 'select2:select',
                params: {
                    data: data
                }
            });
        }
    });
}

/**
 * Transform a string of integer values into an array (for multiselect filters)
 * @param string
 * @param onlyNumeric
 * @return array|integer|null
 * @example stringToIntArray("1,2,3,4,5", true) => [1,2,3,4,5]
 *
 * */
function stringToArray(string, onlyNumeric = false){
    if (string === undefined || string === null || string === '') {
        return null;
    }

    let arrayValues =  string.split(',').map(function (item) {
        if (onlyNumeric) {
            // check if it's not a number skip it
            if (isNaN(item)) {
                return;
            }
            return parseInt(item, 10);
        } else {
            return item;
        }
    });

    return arrayValues;

    // If an array contains more than one value, return it as an array, else as a single value
    //if (arrayValues.length > 1) {
    //    return arrayValues;
    //} else {
    //    return arrayValues[0];
    //}
}
