/* jshint ignore: start */
$(document).ready(function () {
    if ($('#myKanban').length === 0) return;
    const body = $('body');

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
                    dragBoards: false,
                    dragItems: true,
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

                $('.kanban-board').each(function (index) {
                    if (index === 0) {
                        const buttonHTML = `<a class="btn btn-primary btn-sm float-end create-task-link" href="/tasks/create">Create</a>`;
                        $(this).find('.kanban-board-header').append(buttonHTML);
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

