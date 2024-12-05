/* jshint ignore: start */
$(document).ready(function () {
    /**
     * Инициализация select2 с общими настройками
     * @param {string} selector - CSS-селектор для инициализации select2
     */
    function initializeSelect2(selector) {
        $(selector).select2({
            allowClear: false,
            templateResult: formatOption,
            templateSelection: formatSelectedOption,
            ajax: {
                url: '/users/get-users',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        query: params.term,
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.map(user => ({
                            id: user.id,
                            text: user.user,
                            avatarHtml: user.avatar,
                        }))
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        });
    }

    initializeSelect2('#assigned-to');
    initializeSelect2('#author-id');

    function formatOption(option) {
        if (!option.id) {
            return option.text;
        }

        const avatarHtml = option.avatarHtml || '';

        return $(
            `<div style="display: flex; align-items: center;">
                <div style="margin-right: 10px;">${avatarHtml}</div>
                <div>
                    <div>${option.text}</div>
                </div>
            </div>`
        );
    }

    function formatSelectedOption(option) {
        if (!option.id) {
            return option.text;
        }

        return option.text;
    }
});
