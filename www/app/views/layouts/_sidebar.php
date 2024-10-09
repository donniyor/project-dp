<?php

use app\components\RolesInterface;
use app\widgets\sidebar;

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

            <?= sidebar::make()
                ->add('Пользователи', 'people_alt', 'admins', [RolesInterface::SUPER_ADMIN_ROLE])
                ->add('Пройти опрос', 'done_all', 'test', [RolesInterface::SUPER_ADMIN_ROLE, RolesInterface::ADMIN_ROLE])
                ->add('Создать свой опрос', 'quiz', 'quizizz', [RolesInterface::SUPER_ADMIN_ROLE, RolesInterface::ADMIN_ROLE])
                ->add('Результаты опросов', 'check_circle', 'test-solution', [RolesInterface::SUPER_ADMIN_ROLE, RolesInterface::ADMIN_ROLE])
                ->all()
            ?>

            <li class="sidebar-title">
                Системное
            </li>

            <?= sidebar::make()
                ->add('Журнал событий', 'import_contacts', 'log-actions', ['superAdmin'])
                ->add('Выход', 'logout', 'auth/out')
                ->all()
            ?>

        </ul>
    </div>
</div>