<nav class="navbar-expand-md navbar-dark bg-dark fixed-top navbar">
    <div class="container-fluid">
        <div class="navbar-nav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link hide-sidebar-toggle-button" href="#"><i class="material-icons">first_page</i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><?= Yii::$app->user->identity->username ?></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
