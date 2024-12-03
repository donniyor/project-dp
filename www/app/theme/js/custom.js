$(document).ready(function () {
    const body = $('body');
    body.on('click', '.confirm-delete', function () {
        const button = $(this).addClass('disabled');
        const title = button.attr('title');

        if (confirm(title ? title + '?' : 'Confirm the deletion')) {
            if (button.data('reload')) {
                return true;
            }
            $.getJSON(button.attr('href'), function (response) {
                button.removeClass('disabled');
                if (response.result === 'success') {
                    button.closest('tr').fadeOut(function () {
                        this.remove();
                    });
                } else {
                    alert(response.error);
                }
            });
        }
        return false;
    });

    body.on('click', '.modalButton', function () {
        $.get($(this).attr('href'), function (data) {
            $("#modal").modal('show').find('#modalContent').html(data)
            $(".datepicker").flatpickr({
                dateFormat: "m-d-Y"
            });
        });
        return false;
    });

    body.on('click', '#assign-me', function (e) {
        e.preventDefault();

        let url = $(this).attr('href');
        let id = $(this).data('task_id');

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'html',
            success: function (response) {
                $('#response-container-' + id).html(response);
            },
            error: function () {
                alert('Ошибка назначения задачи. Попробуйте еще раз.');
            }
        });
    });
});

