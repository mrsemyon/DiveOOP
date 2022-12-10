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

$title = 'Изменить фото';
require $_SERVER['DOCUMENT_ROOT'] . '/public/templates/header.php';
?>
<div class="subheader">
    <h1 class="subheader-title">
        <i class='subheader-icon fal fa-image'></i><?= $title ?>
    </h1>

</div>
<form action="/controllers/photo.php?id=<?= $user['id'] ?>" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-xl-6">
            <div id="panel-1" class="panel">
                <div class="panel-container">
                    <div class="panel-hdr">
                        <h2>Текущий аватар</h2>
                    </div>
                    <div class="panel-content">
                        <div class="form-group">
                            <img src="/upload/<?= $user['photo'] ?>" alt="" class="img-responsive rounded-circle" width="200">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="example-fileinput">Выберите аватар</label>
                            <input name="photo" type="file" id="example-fileinput" class="form-control-file">
                        </div>
                        <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                            <button class="btn btn-warning">Загрузить</button>
                        </div>
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