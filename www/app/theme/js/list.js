/* jshint ignore: start */
$(document).ready(function () {
    $('#author-id').select2();


    $('#assigned-to').select2({
        placeholder: 'Выберите пользователей',
        allowClear: true,
        templateResult: formatOption, // Кастомное отображение опций
        templateSelection: formatSelectedOption // Кастомное отображение выбранной опции
    });

    // Формат опции в списке
    function formatOption(option) {
        if (!option.id) {
            return option.text; // Для плейсхолдера
        }

        const avatarHtml = $(option.element).data('avatar-html') || '';
        const email = $(option.element).data('email') || '';

        return $(
            `<div style="display: flex; align-items: center;">
                <div style="margin-right: 10px;">${avatarHtml}</div>
                <div>
                    <div>${option.text}</div>
                    <small style="color: #888;">${email}</small>
                </div>
            </div>`
        );
    }

    // Формат выбранной опции
    function formatSelectedOption(option) {
        if (!option.id) {
            return option.text; // Для плейсхолдера
        }

        const avatarHtml = $(option.element).data('avatar-html') || '';
        return $(
            `<div style="display: flex; align-items: center;">
                <div style="margin-right: 10px;">${avatarHtml}</div>
                <div>${option.text}</div>
            </div>`
        );
    }
});
