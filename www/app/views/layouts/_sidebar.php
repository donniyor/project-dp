<?php

declare(strict_types=1);

use app\widgets\Sidebar;

?>

<div class="app-sidebar">
    <div class="logo logo-sm">
        <a href="/">Опросник</a>
    </div>
    <div class="app-menu">
        <ul class="accordion-menu">
            <li class="sidebar-title">
                Основное
            </li>

            <?= Sidebar::make()
                ->add('Пользователи', 'people_alt', 'admins')
                ->add('Проекты', 'done_all', 'projects')
                ->all()
            ?>

            <li class="sidebar-title">
                Системное
            </li>

            <?= Sidebar::make()
                ->add('Выход', 'logout', 'auth/out')
                ->all()
            ?>

        </ul>
    </div>
</div>