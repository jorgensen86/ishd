function displayToast(bg, title, msg) {
    $(document).Toasts('create', {
        class: bg,
        title: title,
        body: msg,
        autohide: true,
        delay: 2000,
    })
} 

$(function() {
    $('#ticketForm').on('submit', function(e){
        e.preventDefault();
        $('.text-danger').remove()
        $.ajax({
            url: $(this).attr('action'),
            type: 'post',
            dataType: 'json',
            data: $(this).serialize(),
            beforeSend: function() {
                $('#ticketForm .overlay').show();
                $('#ticketForm .btn').prop('disabled', true)
            },
            complete: function() {
                $('#ticketForm .overlay').hide();
                $('#ticketForm .btn').prop('disabled', false)
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
})