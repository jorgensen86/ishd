function displayToast(bg, title, msg) {
    $(document).Toasts('create', {
        class: bg,
        title: title,
        body: msg,
        autohide: true,
        delay: 3000,
    })
} 

$(function() {
    // Open Modal
    $(document).on('click', '.btnOpenModal', function () {
        $($(this).data('target') + ' .modal-content').empty();
        $.ajax({
            type: 'get',
            dataType: 'html',
            url: $(this).data('url'),
            success: (html) => {
                $($(this).data('target') + ' .modal-content').append(html)
                $($(this).data('target')).modal('show')
            },
            error: (xhr) => {
                alert(xhr.status + ' - ' + xhr.statusText)
            }
        })
    }).on('click', '.btnDeleteModal', function () {
        $($(this).data('target') + ' #deleteForm').prop('action', $(this).data('url'));
        $($(this).data('target')).modal('show')
    })

    // Add/Edit Modal Form 
    $(document).on('click', '#btnSave', function () {
        const $form = $($(this).data('form'));
        $form.find('input').removeClass('is-invalid')
        
        $.ajax({
            type: $form.attr('method'),
            data: $form.serialize(),
            url: $form.attr('action'),
            beforeSend: () => {
                $('#user-modal button').prop('disabled', true)
            },
            complete: () => {
                $('#user-modal button').prop('disabled', false)
            },
            success: (json) => {
                if (json.errors) {
                    let errors = '';
                    Object.keys(json.errors).forEach(function (key) {
                        $('input[name="' + key + '"]').addClass('is-invalid')
                        errors += json.errors[key] + "<br>";
                    });

                    displayToast('bg-danger', json.title, errors);

                } else {
                    $form.closest('.modal').modal('hide');
                    displayToast('bg-success', json.title, json.success);
                    $('.dataTable').DataTable().ajax.reload(null, false);
                    if(json['id']) {
                        $('#' + json['id']).text(json['count'])
                    }
                }
            },
            error: (xhr) => {
                alert(xhr.status + ' - ' + xhr.responseJSON.message)
            }
        })
    })

    // Delete Modal Form
    $(document).on('submit', '#deleteForm', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: $(this).attr('action'),
            data: $('#deleteForm').serialize(),
            beforeSend: () => {
                $('.modal button').prop('disable', true)
            },
            complete: () => {
                
            },
            success: (json) => {
                if(json.errors) {
                    displayToast('bg-danger', json.title, json.errors);
                } 

                if(json.success) {
                    $('#deleteModal').modal('hide');
                    displayToast('bg-success', json.title, json.success);
                    $('.dataTable').DataTable().ajax.reload(null, false);
                }
            },
            error: (xhr) => {
                alert(xhr.status + ' - ' + xhr.responseJSON.message)
                if(xhr.status == '401') {
                    location.reload(); 
                }
            }
        });
    })
})