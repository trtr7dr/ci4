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
        <link href="<?= base_url(); ?>/css/admin.css" rel="stylesheet" type="text/css"/>
        <title>Добавить статью</title>
    </head>
    <body>
        <?php echo view('admin-panel/line-menu');?>
        <div class="container">
            <form method="post">
                <?= csrf_field() ?>
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label for="title">Название</label>
                        <input type="text" class="form-control" name="title" placeholder="Тайтл" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="url">URL</label>
                        <input type="text" class="form-control" name="url" placeholder="url" minlength="4" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="template">Шаблон</label>
                        <input type="text" class="form-control" name="template" placeholder="simple" value="simple" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-12">
                        <label for="content">Содержание</label>
                        <textarea class="form-control" name="content" placeholder="Содержание" required></textarea>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    
                    <div class="col-md-6 mb-6">
                        <label for="description">Описание</label>
                        <input type="text" class="form-control" name="description" placeholder="Описание">
                    </div>
                    <div class="col-md-6 mb-6">
                        <label for="keywords">Ключевые слова</label>
                        <input type="text" class="form-control" name="keywords" placeholder="Keywords">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-9 md-9"></div>
                    <div class="col-md-3 md-3">
                        <label class="no_text" for="log">Добавить</label>
                        <button type="submit" name="log" class="btn btn-primary">Добавить</button>
                    </div>
                </div>
                
                <div class="form-row">
                    <?= $error ?>
                </div>

            </form>
        </div>
    </body>
</html>
