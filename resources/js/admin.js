// Open Modal
$('.btn-open-modal').on('click', function () {
    $('#user-modal .modal-body').empty()
    $.ajax({
        type: 'get',
        url: $(this).data('url'),
        success: (html) => {
            $('#user-modal .modal-body').append(html)
            $('#user-modal').modal('show')
        }
    })
}) 