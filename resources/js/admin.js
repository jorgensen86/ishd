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
                $('#btnSave, #btnCancel').prop('disabled', true)
            },
            complete: () => {
                $('#btnSave, #btnCancel').prop('disabled', false)
            },
            success: (json) => {
                if (json.errors) {
                    let errors = '';
                    Object.keys(json.errors).forEach(function (key) {
                        $('[name="' + key + '"]').addClass('is-invalid')
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
                $('#btnConfirm, #btnCancel').prop('disabled', true)
            },
            complete: () => {
                $('#btnConfirm, #btnCancel').prop('disabled', false)
            },
            success: (json) => {
                if(json.errors) {
                    for (let index = 0; index < json.errors.length; index++) {
                        displayToast('bg-danger', json.title, json.errors[index]);
                    }
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

    $('#ticketForm').on('submit', function(e){
        e.preventDefault();
        $('.text-danger').remove()
        $.ajax({
            url: $(this).attr('action'),
            type: 'post',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(json) {
                if (json.errors) {
                    Object.keys(json.errors).forEach(function (key) {
                        $('[name="' + key + '"]').addClass('is-invalid')
                        displayToast('bg-danger', json.title, json.errors[key]);
                    });
                }
                if(json.success) {
                    location.href  = json.redirect;
                }
            }
        })
    })

    $('#replyForm').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'post',
            dataType: 'json',
            data: $(this).serialize(),
            beforeSend: function() {
                $('.overlay').show();
                $('#replyForm .btn').prop('disabled', true)
            },
            complete: function() {
                $('.overlay').hide();
                $('#replyForm .btn').prop('disabled', false)
            },
            success: function(json) {
                if (json.errors) {
                    Object.keys(json.errors).forEach(function (key) {
                        $('[name="' + key + '"]').addClass('is-invalid')
                        displayToast('bg-danger', json.title, json.errors[key]);
                    });
                }

                if(json.success) {
                    location.href  = json.redirect;
                }
            },
            error: (xhr) => {
                alert(xhr.status + ' - ' + xhr.responseJSON.message)
            }
        })
    })

    $('#editTicket').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'post',
            dataType: 'json',
            data: $(this).serialize(),
            beforeSend: function() {

            },
            success: function(json) {
                if (json.success) {
                    displayToast('bg-success', json.title, json.success);
                }
            },
            error: (xhr) => {
                alert(xhr.status + ' - ' + xhr.responseJSON.message)
            }
        })
    })
})