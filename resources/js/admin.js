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
        $(selector).modal('show')
    })
})