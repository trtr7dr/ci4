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
        <title>Добавить новость</title>
    </head>
    <body>
        <?php echo view('admin-panel/line-menu');?>
        <div class="container">
            <form method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label for="title">Название</label>
                        <input type="text" class="form-control" name="title" placeholder="Тайтл" value="<?= $news['title'] ?>" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="url">URL</label>
                        <input type="text" class="form-control" name="url" placeholder="url" minlength="4" value="<?= $news['url'] ?>" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <img class="pre_img" src="<?= base_url(); ?>/upload/image/news/<?= $news['url'] ?>/<?= $news['pre_img'] ?>" width="100%">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="pre_img">Превью</label>
                        <input type="file" name="pre_img" value="">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-12">
                        <label for="text">Содержание</label>
                        <textarea class="form-control" name="text" placeholder="Содержание" required><?= $news['text'] ?></textarea>
                    </div>
                    
                </div>
                <div class="form-row">
                    <div class="col-md-3 md-3"><p>Создано: <?= $news['created_at'] ?></p></div>
                    <div class="col-md-3 md-3"><p>Изменено: <?= $news['updated_at'] ?></p></div>
                    <div class="col-md-3 md-3"></div>
                    <div class="col-md-3 md-3">
                        <label class="no_text" for="log">Добавить</label>
                        <button type="submit" name="log" class="btn btn-primary">Обновить</button>
                    </div>
                </div>
                
                <div class="form-row">
                    <?= $error ?>
                </div>

            </form>
        </div>
        <script src="<?= base_url(); ?>/js/dashboard/tinymce.min.js" type="text/javascript"></script>
        <script>tinymce.init({selector:'textarea'});</script>
    </body>
</html>
