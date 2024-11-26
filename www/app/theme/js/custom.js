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

    $('#assigned-to').select2();
    $('#author-id').select2();

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

    function loadKanbanData() {
        $.ajax({
            url: '/api-tasks/data',
            method: 'GET',
            dataType: 'json',
            success: function (data) {

                if (!data || data.length === 0) {
                    data = [
                        {id: '_todo', title: 'To Do', class: 'info', item: []},
                        {id: '_doing', title: 'Doing', class: 'warning', item: []},
                        {id: '_done', title: 'Done', class: 'success', item: []}
                    ];
                }
                const boardsArray = Object.values(data);

                const kanban = new jKanban({
                    element: '#myKanban',
                    gutter: '15px',
                    widthBoard: '300px',
                    boards: boardsArray,
                    dragBoards: true,
                    dragItems: true,
                    itemAddOptions: {
                        enabled: true,
                        content: '+ Add New Item',
                    },
                    dropEl: function (item, target, source) {
                        const taskId = item.dataset.eid;
                        let newStatus = $(target).closest("div.kanban-board").attr("data-id");

                        $.ajax({
                            url: '/api-tasks/update-status',
                            method: 'POST',
                            data: {
                                taskId: taskId,
                                status: newStatus
                            },
                            success: function (response) {
                                console.log('Статус задачи обновлен');
                            },
                            error: function (xhr, status, error) {
                                console.error('Ошибка обновления статуса:', error);
                            }
                        });
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error('Ошибка загрузки данных:', error);

                const emptyData = [
                    {id: '_todo', title: 'To Do', class: 'info', item: []},
                    {id: '_doing', title: 'Doing', class: 'warning', item: []},
                    {id: '_done', title: 'Done', class: 'success', item: []}
                ];

                new jKanban({
                    element: '#myKanban',
                    gutter: '15px',
                    widthBoard: '300px',
                    boards: emptyData,
                });
            }
        });
    }

    loadKanbanData();
});

