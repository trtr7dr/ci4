<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="<?= base_url(); ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?= base_url(); ?>/css/auth.css" rel="stylesheet" type="text/css"/>
        <title></title>
    </head>
    <body>
        <div class="container">
            <form method="post" >
                <?= csrf_field() ?>
                <div class="form-row">
                    <div class="col-md-4 mb-4">
                        <label for="email">Электронная почта</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Электронная почта" minlength="5" maxlength="255" required>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="pass">Пароль</label>
                        <input type="password" class="form-control" id="pass" name="pass" placeholder="Пароль" minlength="6" maxlength="20" required>
                    </div>
                    <div class="col-md-4 md-4">
                        <label class="no_text" for="log">Войти</label>
                        <button type="submit" name="log" class="btn btn-primary">Вход</button>
                    </div>
                </div>
                <div class="form-row">
                    <?= $error ?>
                </div>

            </form>
        </div>
    </body>
</html>
