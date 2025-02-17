/* jshint ignore: start */
$(document).ready(function () {
    let isDragging = false;
    let startX, scrollLeft;
    let isTaskDragging = false;

    // Перетаскивание задач с эффектом "призрака"
    $(".kanban-items").sortable({
        connectWith: ".kanban-items",
        placeholder: "kanban-item-placeholder", // Класс для "призрака"
        cursor: "move",
        start: function (event, ui) {
            isTaskDragging = true;
            ui.placeholder.height(ui.item.height()); // Устанавливаем высоту "призрака"
        },
        stop: function (event, ui) {
            isTaskDragging = false;
            let taskId = ui.item.data("id");
            let boardId = ui.item.closest(".kanban-column").data("board-id");
            console.log("Task moved:", taskId, "to board:", boardId);
        }
    }).disableSelection();

    // Перетаскивание всей доски
    $(".kanban-container").on("mousedown", function (e) {
        if (isTaskDragging) return;

        isDragging = true;
        startX = e.pageX - $(this).offset().left;
        scrollLeft = $(this).scrollLeft();
        $(this).css("cursor", "grabbing");
    });

    $(document).on("mousemove", function (e) {
        if (!isDragging || isTaskDragging) return;
        let x = e.pageX - $(".kanban-container").offset().left;
        let walk = (x - startX) * -1;
        $(".kanban-container").scrollLeft(scrollLeft + walk);
    });

    $(document).on("mouseup", function () {
        isDragging = false;
        $(".kanban-container").css("cursor", "grab");
    });
});