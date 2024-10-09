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

    body.on('change', '.news-banner-status', function (e) {
        e.preventDefault()
        const id = $(this).data("id")
        let status = this.checked ? 1 : 0
        $.getJSON(`/news/banner-status?id=${id}&status=${status}`);
        return false;
    });

    $(document).bind('keydown', function (e) {
        if (e.ctrlKey && e.which === 83) {
            $('.model-form').submit();
            e.preventDefault();
            return false;
        }
    });

    body.on('click', '.modalButton', function () {
        $.get($(this).attr('href'), function (data) {
            $("#modal").modal('show').find('#modalContent').html(data)
            $(".datepicker").flatpickr({
                dateFormat: "m-d-Y"
            });
        });
        return false;
    })

    let addQuestion = '.ajax-add-question'
    $(body).on('click', addQuestion, function (e) {
        e.preventDefault()

        $.ajax({
            url: $(addQuestion).attr('href'),
            type: 'GET',
            success: (data) => $('.make-question').append(data),
            error: (data) => console.log(data)
        })
    })

    let addAnswer = '.ajax-add-answer'
    $(body).on('click', addAnswer, function (e) {
        e.preventDefault()
        let $input = $(this)

        let question_id = $input.closest('.question-form').find('.ajax-question-save').data('id')
        if (question_id === undefined) {
            showError('Прежде чем добавлять ответ вы должны добавить вопрос')
        } else {
            $.ajax({
                url: $(addAnswer).attr('href'),
                type: 'POST',
                data: {
                    'question_id': question_id ?? $input.data('id')
                },
                success: function (data) {
                    $input.closest('.push-question').find('.make-answer').append(data)
                },
                error: (data) => console.log(data)
            })
        }
    })

    let saveQuestion = '.ajax-question-save'
    $(body).on('blur', saveQuestion, function (e) {
        e.preventDefault()
        let $input = $(this)
        $.ajax({
            url: $input.data('url'),
            type: 'POST',
            data:
                {
                    'id': $input.data('id'),
                    'quiz_id': $input.data('quiz_id'),
                    'question': $input.val(),
                },
            success: function (data) {
                console.log(data)
                if (data.success === false) {
                    showError('Заполните вопрос')
                } else {
                    $input.attr('data-id', data.id)
                }
            },
            error: (data) => console.log(data)
        })
    })

    let savaAnswer = '.ajax-save-answer'
    $(body).on('blur', savaAnswer, function (e) {
        e.preventDefault()
        let $input = $(this)
        $.ajax({
            url: $input.data('url'),
            type: 'POST',
            data:
                {
                    'id': $input.data('id'),
                    'question_id': $input.data('question_id'),
                    'answer': $input.val(),
                },
            success: function (data) {
                $input.attr('data-id', data.id)
                if (data.success === false) showError('Заполните ответ')
            },
            error: (data) => console.log(data)
        })
    })

    function showError(message) {
        $('#error-massage').text(message)
        $('.error-massage').stop(true, true).fadeIn('fast').delay(1000).fadeOut(1000);
    }
});

