/* jshint ignore: start */
$(document).ready(function () {
    /**
     * Инициализация select2 с общими настройками
     * @param {string} selector - CSS-селектор для инициализации select2
     * @param {string} cacheKey - Ключ для кэширования данных для этого поля
     */
    function initializeSelect2(selector, cacheKey) {
        let cachedData = []; // Локальный кэш данных для каждого поля

        $(selector).select2({
            allowClear: false,
            templateResult: formatOptionAvatar,
            templateSelection: formatSelectedOptionAvatar,
            ajax: {
                url: '/users/get-users',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    // Если пользователь вводит текст, отправляем запрос
                    if (params.term) {
                        return {
                            query: params.term,
                        };
                    }
                    // Если текст не введён, возвращаем пустой объект, чтобы не отправлять запрос
                    return {};
                },
                processResults: function (data) {
                    // Кэшируем данные
                    cachedData = data.map(user => ({
                        id: user.id,
                        text: user.user,
                        avatarHtml: user.avatar,
                    }));

                    return {
                        results: cachedData
                    };
                },
                transport: function (params, success, failure) {
                    // Если кэш не пустой и пользователь не вводил текст, возвращаем кэшированные данные
                    if (!params.data.query && cachedData.length > 0) {
                        success({results: cachedData});
                        return;
                    }
                    // Иначе выполняем стандартный запрос
                    const request = $.ajax(params);
                    request.then(success).fail(failure);
                    return request;
                },
                cache: true
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        });
    }

    function formatOptionAvatar(option) {
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

    function formatSelectedOptionAvatar(option) {
        if (!option.id) {
            return option.text;
        }

        return option.text;
    }

    function initializeSelect3(selector, link, cacheKey) {
        let cachedData = []; // Локальный кэш данных для каждого поля

        $(selector).select2({
            allowClear: false,
            templateResult: formatOptionProject,
            templateSelection: formatSelectedOptionProject,
            ajax: {
                url: link, // URL для загрузки проектов
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    if (params.term) {
                        return {query: params.term};
                    }
                    return {};
                },
                processResults: function (data) {
                    cachedData = data.map(project => ({
                        id: project.id,
                        text: project.title
                    }));

                    return {results: cachedData};
                },
                transport: function (params, success, failure) {
                    if (!params.data.query && cachedData.length > 0) {
                        success({results: cachedData});
                        return;
                    }
                    const request = $.ajax(params);
                    request.then(success).fail(failure);
                    return request;
                },
                cache: true
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        });
    }

    function formatOptionProject(option) {
        if (!option.id) {
            return option.text;
        }
        return `<div>${option.text}</div>`;
    }

    function formatSelectedOptionProject(option) {
        return option.text;
    }

    initializeSelect3('#project-id', '/projects/get-projects', 'project-id');
    initializeSelect3('#status-id', '/statuses/get-status', 'status-id');
    initializeSelect2('#assigned-to', 'assigned-to');
    initializeSelect2('#author-id', 'author-id');
});
