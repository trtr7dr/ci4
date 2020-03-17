<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <link href="<?= base_url();?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?= base_url();?>/css/auth.css" rel="stylesheet" type="text/css"/>
        <title></title>
    </head>
    <body>
        <div class="container">
        <form method="post" >
            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrf"/>
            <?= csrf_field() ?>
            <div class="form-row">
            <div class="col-md-4 mb-4">
                <label for="name">Имя</label>
                <input class="form-control" id="name" name="name" type="text" placeholder="Имя" minlength="4" maxlength="255" required>
                
            </div>
            <div class="col-md-4 mb-4">
                <label for="email">Электронная почта</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Электронная почта" minlength="5" maxlength="255" required>
                <small id="emailHelp" class="form-text text-muted">Скрыта от всех пользователей.</small>
            </div>
            <div class="col-md-4 mb-4">
                <label for="pass">Пароль</label>
                <input type="password" class="form-control" id="pass" name="pass" placeholder="Пароль" minlength="6" maxlength="20" required>
                
            </div>
            </div>
            <div class="form-row">
                
                <div class="col-md-2 md-2">
                <img src="data:image/png;base64,<?= $captcha ?>" id="cap" width="220" height="120"/>
                <div id="ref" onclick="recaptcha()">⥁</div>
                <input class="form-control" id="captcha" name="captcha" type="text" placeholder="Код с картинки" minlength="4" maxlength="255" required>
                
                    <button type="submit" class="btn btn-primary">Регистрация</button>
                   
                </div>
                <div class="col-md-10"></div>
            </div>
            <div class="row">
                 <div class="col-md-10">
                <p><?= $error ?></p>
                 </div>
            </div>
        </form>
        </div>
        <script src="<?= base_url(); ?>/js/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script src="<?= base_url(); ?>/js/recaptcha.js" type="text/javascript"></script>
    </body>
</html>
