<?php

namespace console\controllers;

use app\models\Users;
use app\rules\canDeleteRule;
use Yii;
use yii\console\Controller;

class MyRbacController extends Controller
{

    public function actionInit()
    {
        /* default */
        $auth = Yii::$app->authManager;
        $auth->removeAll();
        Users::deleteAll();

        /* Create users */
        // Тестовые данные
        $superAdmin = new Users();
        $superAdmin->username = 'superAdmin';
        $superAdmin->email = 'superAdmin@mail.ru';
        $superAdmin->setPassword('superAdmin');
        $superAdmin->generateAuthKey();
        $superAdmin->save();

        $admin = new Users();
        $admin->username = 'admin123';
        $admin->email = 'admin123@mail.ru';
        $admin->setPassword('admin123');
        $admin->generateAuthKey();
        $admin->save();

        $moderator = new Users();
        $moderator->username = 'moderator';
        $moderator->email = 'moderator@mail.ru';
        $moderator->setPassword('moderator');
        $moderator->generateAuthKey();
        $moderator->save();

        /* Permissions Can enter admin panel */

        $canAdmin = $auth->createPermission('canAdmin');
        $auth->add($canAdmin);

        /* Can Delete Permission */
        $rule = new canDeleteRule;
        $auth->add($rule);

        $canDelete = $auth->createPermission('canDelete');
        $canDelete->ruleName = $rule->name;
        $auth->add($canDelete);

        /* Roles*/
        $superAdminRole = $auth->createRole('superAdmin');
        $auth->add($superAdminRole);

        $adminRole = $auth->createRole('admin');
        $auth->add($adminRole);

        $moderatorRole = $auth->createRole('moderator');
        $auth->add($moderatorRole);


        /* Set permissions to roles */

        $auth->addChild($superAdminRole, $canAdmin);
        $auth->addChild($adminRole, $canAdmin);
        $auth->addChild($moderatorRole, $canAdmin);

        $auth->addChild($superAdminRole, $canDelete);
        $auth->addChild($adminRole, $canDelete);

        /* test set roles to test users */
        $auth->assign($superAdminRole, $superAdmin->id);
        $auth->assign($adminRole, $admin->id);
        $auth->assign($moderatorRole, $moderator->id);





        print("\nAll correct!");
    }
}

/*
        //1
        $deleteAdmin = $auth->createPermission('canDeleteAdmin');
        $deleteAdmin->description = 'can delete admins';
        $auth->add($deleteAdmin);

        // создаем правило разрешить удалять админов
        $rule = new canDeleteAdmin; // add rule
        $deleteAdmin->ruleName = $rule->name;
        $auth->add($rule);

        //2
        $deleteModerator = $auth->createPermission('canDeleteModerator');
        $deleteModerator->description = 'can delete moderator';
        $auth->add($deleteModerator);

        // создаем правило разрешить удалять модератеров
        $rule2 = new canDeleteModerator; // add rule
        $deleteModerator->ruleName = $rule2->name;
        $auth->add($rule2);
*/


/* Roles */

/*

        $superAdminRole = $auth->createRole('superAdmin');
        $superAdminRole->description = "Super Users";
        $auth->add($superAdminRole);


        $adminRole = $auth->createRole('admin');
        $adminRole->description = "Users";
        $auth->add($adminRole);


        $moderatorRole = $auth->createRole('moderator');
        $moderatorRole->description = "Moderator";
        $auth->add($moderatorRole);

        $auth->addChild($superAdminRole, $deleteAdmin);
        $auth->addChild($adminRole, $deleteModerator);
        $auth->addChild($superAdminRole, $adminRole); // супер админ может то же что и админ
*/


/*
        //1
        $deleteAdmin = $auth->createPermission('canDeleteAdmin');
        $deleteAdmin->description = 'can delete admins';
        $auth->add($deleteAdmin);

        // создаем правило разрешить удалять админов
        $rule = new canDeleteAdmin; // add rule
        $deleteAdmin->ruleName = $rule->name;
        $auth->add($rule);


        //2
        $deleteModerator = $auth->createPermission('canDeleteModerator');
        $deleteModerator->description = 'can delete moderator';
        $auth->add($deleteModerator);

        // создаем правило разрешить удалять модератеров
        $rule2 = new canDeleteModerator; // add rule
        $deleteModerator->ruleName = $rule2->name;
        $auth->add($rule2);


        $auth->addChild($superAdminRole, $deleteAdmin);
        $auth->addChild($adminRole, $deleteModerator);
        $auth->addChild($superAdminRole, $adminRole); // супер админ может то же что и админ
*/