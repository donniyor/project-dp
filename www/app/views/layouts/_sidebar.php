<?php

declare(strict_types=1);

use app\widgets\Sidebar;

?>

<ul class="accordion-menu">
    <li class="sidebar-title">Task manager</li>
    <?= Sidebar::make()
        ->add('Личный кабинет', 'account_circle', 'self-cabinet')
        ->add('Пользователи', 'people_alt', 'users')
        ->add('Проекты', 'assignment', 'projects')
        ->add('Беклог', 'task', 'tasks')
        ->add('Канбан', 'view_kanban', 'kanban')
        ->add('Моя работа', 'assignment_ind', '')
        ->all()
    ?>
    <li class="sidebar-title"></li>
    <?= Sidebar::make()
        ->add('Выход', 'logout', 'auth/out')
        ->all()
    ?>
</ul>
