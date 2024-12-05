/* jshint ignore: start */
$(document).ready(function () {

    $('#assigned-to').select2({
        allowClear: true,
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
                        email: user.email,
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

    $('#author-id').select2({
        allowClear: true,
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
                        email: user.email,
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

    function formatOption(option) {
        if (!option.id) {
            return option.text;
        }

        const avatarHtml = option.avatarHtml || '';
        const email = option.email || '';

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

    function formatSelectedOption(option) {
        if (!option.id) {
            return option.text;
        }

        const avatarHtml = option.avatarHtml || '';
        return $(
            `<div style="display: flex; align-items: center;">
            <div style="margin-right: 10px;">${avatarHtml}</div>
            <div>${option.text}</div>
        </div>`
        );
    }
});
