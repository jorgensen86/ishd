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

    $(document).on('submit', '#deleteForm', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: $(this).attr('action'),
            data: $('#deleteForm').serialize(),
            beforeSend: () => {
                alert()
            },
            complete: () => {
                alert();
            }
        });
    })
})