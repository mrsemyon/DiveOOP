<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';

if (Input::exists('get')) {
    $user = QueryBuilder::getInstance()->read('users', ['id' => Input::get('id')]);
} else {
    Session::flash('danger', 'Не выбран пользователь.');
    Redirect::to('/public/users');
    exit;
}

if ((Session::get('role') != 'admin') && (Session::get('email') != $user['email'])) {
    Session::flash('danger', 'У Вас недостаточно прав.');
    Redirect::to('/public/users');
    exit;
}

$title = 'Редактировать авторизационные данные';
require $_SERVER['DOCUMENT_ROOT'] . '/public/templates/header.php';
?>
<div class="subheader">
    <h1 class="subheader-title">
        <i class='subheader-icon fal fa-lock'></i><?= $title ?>
    </h1>
</div>
<?php if (Session::exists('danger')) : ?>
    <div class="alert alert-danger text-dark" role="alert">
        <?= Session::flash('danger') ?>
    </div>
<?php endif ?>
<form action="/controllers/credentials.php?id=<?= $user['id'] ?>" method="POST">
    <div class="row">
        <div class="col-xl-6">
            <div id="panel-1" class="panel">
                <div class="panel-container">
                    <div class="panel-hdr">
                        <h2>Обновление эл. адреса и пароля</h2>
                    </div>
                    <div class="panel-content">
                        <div class="form-group">
                            <label class="form-label" for="simpleinput">Email</label>
                            <input name="email" type="text" id="simpleinput" class="form-control" value="<?= $user['email'] ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="simpleinput">Пароль</label>
                            <input name="password" type="password" id="simpleinput" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="simpleinput">Подтверждение пароля</label>
                            <input type="password" id="simpleinput" class="form-control">
                        </div>
                        <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                            <button class="btn btn-warning">Изменить</button>
                        </div>
                        <input type="hidden" name="token" value="<?= Token::generate() ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</main>
<script src="js/vendors.bundle.js"></script>
<script src="js/app.bundle.js"></script>
<script>
    $(document).ready(function() {

        $('input[type=radio][name=contactview]').change(function() {
            if (this.value == 'grid') {
                $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-g');
                $('#js-contacts .col-xl-12').removeClassPrefix('col-xl-').addClass('col-xl-4');
                $('#js-contacts .js-expand-btn').addClass('d-none');
                $('#js-contacts .card-body + .card-body').addClass('show');

            } else if (this.value == 'table') {
                $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-1');
                $('#js-contacts .col-xl-4').removeClassPrefix('col-xl-').addClass('col-xl-12');
                $('#js-contacts .js-expand-btn').removeClass('d-none');
                $('#js-contacts .card-body + .card-body').removeClass('show');
            }

        });

        //initialize filter
        initApp.listFilter($('#js-contacts'), $('#js-filter-contacts'));
    });
</script>
</body>

</html>