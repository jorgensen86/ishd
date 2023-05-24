function displayToast(bg, msg) {
    $(document).Toasts('create', {
        class: bg,
        title: 'Προσοχή',
        body: msg,
        autohide: true,
        delay: 3000,
    })
} 

$(function() {
    // Open Modal
    $(document).on('click', '.btn-open-modal', function () {
        const selector = '#' + $(this).data('modal');
        
        $(selector).find('.modal-body').empty()
        $.ajax({
            type: 'get',
            dataType: 'html',
            url: $(this).data('url'),
            success: (html) => {
                $(selector).find('.modal-body').append(html)
                $(selector).modal('show')
            }
        })
    }).on('click', '.btn-delete-modal', function () {
        const selector = '#' + $(this).data('modal');
        $(selector + ' #deleteForm').prop('action', $(this).data('url'));
        $(selector).modal('show')
    })

    // Add/Edit Modal Form 

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
                    displayToast('bg-danger', json.errors);
                } 

                if(json.success) {
                    $('#delete-modal').modal('hide');
                    displayToast('bg-success', json.success);
                    $('table').DataTable().ajax.reload(null, false);
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