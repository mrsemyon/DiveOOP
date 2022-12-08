<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';

if (Session::get('role') != 'admin') {
    Session::flash('danger', 'У Вас недостаточно прав.');
    Redirect::to("/public/users");
    exit;
}

$title = 'Добавить пользователя';
require $_SERVER['DOCUMENT_ROOT'] . '/public/templates/header.php';
?>
<div class="subheader">
    <h1 class="subheader-title">
        <i class='subheader-icon fal fa-plus-circle'></i> <?= $title ?>
    </h1>
</div>
<?php if (Session::exists('danger')) : ?>
    <div class="alert alert-danger text-dark" role="alert">
        <?= Session::flash('danger') ?>
    </div>
<?php endif ?>
<form action="/controllers/create.php" method="POST" enctype="multipart/form-data">
    <div class="row">
        <input name="role" type="hidden" value="user">
        <div class="col-xl-6">
            <div id="panel-1" class="panel">
                <div class="panel-container">
                    <div class="panel-hdr">
                        <h2>Общая информация</h2>
                    </div>
                    <div class="panel-content">
                        <div class="form-group">
                            <label class="form-label" for="simpleinput">Имя</label>
                            <input name="name" type="text" id="simpleinput" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="simpleinput">Место работы</label>
                            <input name="position" type="text" id="simpleinput" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="simpleinput">Номер телефона</label>
                            <input name="phone" type="text" id="simpleinput" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="simpleinput">Адрес</label>
                            <input name="address" type="text" id="simpleinput" class="form-control">
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-xl-6">
            <div id="panel-1" class="panel">
                <div class="panel-container">
                    <div class="panel-hdr">
                        <h2>Безопасность и Медиа</h2>
                    </div>
                    <div class="panel-content">
                        <div class="form-group">
                            <label class="form-label" for="simpleinput">Email</label>
                            <input required name="email" type="text" id="simpleinput" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="simpleinput">Пароль</label>
                            <input required name="password" type="password" id="simpleinput" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="example-select">Выберите статус</label>
                            <select name="status" class="form-control" id="example-select">
                                <option value="success">Онлайн</option>
                                <option value="warning">Отошел</option>
                                <option value="danger">Не беспокоить</option>
                                <option selected value="unknown">Не установлен</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="example-fileinput">Загрузить аватар</label>
                            <input name="photo" type="file" id="example-fileinput" class="form-control-file">
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-container">
                    <div class="panel-hdr">
                        <h2>Социальные сети</h2>
                    </div>
                    <div class="panel-content">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group input-group-lg bg-white shadow-inset-2 mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0 py-1 px-3">
                                            <span class="icon-stack fs-xxl">
                                                <i class="base-7 icon-stack-3x" style="color:#4680C2"></i>
                                                <i class="fab fa-vk icon-stack-1x text-white"></i>
                                            </span>
                                        </span>
                                    </div>
                                    <input name="vk" type="text" class="form-control border-left-0 bg-transparent pl-0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group input-group-lg bg-white shadow-inset-2 mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0 py-1 px-3">
                                            <span class="icon-stack fs-xxl">
                                                <i class="base-7 icon-stack-3x" style="color:#38A1F3"></i>
                                                <i class="fab fa-telegram icon-stack-1x text-white"></i>
                                            </span>
                                        </span>
                                    </div>
                                    <input name="tg" type="text" class="form-control border-left-0 bg-transparent pl-0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group input-group-lg bg-white shadow-inset-2 mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0 py-1 px-3">
                                            <span class="icon-stack fs-xxl">
                                                <i class="base-7 icon-stack-3x" style="color:#E1306C"></i>
                                                <i class="fab fa-instagram icon-stack-1x text-white"></i>
                                            </span>
                                        </span>
                                    </div>
                                    <input name="ig" type="text" class="form-control border-left-0 bg-transparent pl-0">
                                </div>
                            </div>
                            <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                <button class="btn btn-success">Добавить</button>
                            </div>
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


    });
</script>
</body>

</html>