/* jshint ignore: start */
$(document).ready(function () {
    const kanbanTasks = '#kanban-tasks';
    if ($(kanbanTasks).length === 0) return;

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
                    ];
                }
                const boardsArray = Object.values(data);

                const kanban = new jKanban({
                    element: kanbanTasks,
                    gutter: '15px',
                    widthBoard: '300px',
                    boards: boardsArray.map(board => ({
                        ...board,
                        item: board.item.map(task => ({
                            id: task.id,
                            title: `
                                <a href="${task.url}" class="kanban-title">${task.title}</a>
                                <div class="kanban-assigned"><strong>исполнитель: </strong> ${task.assignedTo}</div>
                            `,
                        })),
                    })),
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
                        const buttonHTML = `<a class="btn btn-success btn-sm float-end create-task-link" href="/tasks/create">Создать</a>`;
                        $(this).find('.kanban-board-header').append(buttonHTML);
                    }
                });

                $(kanbanTasks).on('click', '.kanban-title', function (event) {
                    console.log('da');
                    event.stopPropagation();
                    window.location.href = $(this).attr('href');
                });
            },
            error: function (xhr, status, error) {
                console.error('Ошибка загрузки данных:', error);

                const emptyData = [
                    {id: '_todo', title: 'To Do', class: 'info', item: []},
                    {id: '_doing', title: 'Doing', class: 'warning', item: []},
                ];

                new jKanban({
                    element: kanbanTasks,
                    gutter: '15px',
                    widthBoard: '300px',
                    boards: emptyData,
                });
            }
        });
    }

    loadKanbanData();
});

