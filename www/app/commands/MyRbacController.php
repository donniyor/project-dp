<?php

namespace app\commands;

use app\models\Users;
use app\components\RolesInterface;
use Yii;
use yii\console\Controller;

class MyRbacController extends Controller
{
    public function actionIndex()
    {

        $auth = Yii::$app->authManager;
        $auth->removeAll();
        Users::deleteAll();

        /* new user */
        $superAdmin = new Users();
        $superAdmin->username = 'superAdmin';
        $superAdmin->email = 'superAdmin@mail.ru';
        $superAdmin->setPassword('superAdmin');
        $superAdmin->generateAuthKey();
        $superAdmin->save();

        /* permissions */
        $canSuperAdmin = $auth->createPermission('canSuperAdmin');
        $auth->add($canSuperAdmin);
        $canAdmin = $auth->createPermission('canAdmin');
        $auth->add($canAdmin);

        /* Users */
        $superAdminRole = $auth->createRole(RolesInterface::SUPER_ADMIN_ROLE);
        $auth->add($superAdminRole);
        $adminRole = $auth->createRole('admin');
        $auth->add($adminRole);

        $auth->addChild($superAdminRole, $canSuperAdmin);
        $auth->addChild($superAdminRole, $canAdmin);
        $auth->addChild($adminRole, $canAdmin);

        $auth->assign($superAdminRole, $superAdmin->id);

        print("\nAll correct!\n");
    }
}