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
        <title>Admin panel</title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>Новости <a class="edit" href="<?= base_url(); ?>/admin/news/create">➕</a></h2>
                    <?php foreach ($news as $news_item): ?>
                    <div class="line">
                    <a class="edit" href="<?= base_url(); ?>/admin/news/edit/<?php echo $news_item['id']; ?>">✍</a> 
                    <a class="delete" href="<?= base_url(); ?>/admin/news/delete/<?php echo $news_item['id']; ?>">✖</a> 
                    <a href="<?= base_url(); ?>/news/<?php echo $news_item['url']; ?>"><?php echo ($news_item['title']); ?></a> 
                    <br>
                    </div>
                    <?php endforeach; ?>
                        <?= $pager->links() ?>
                </div>
                <div class="col-md-6">
                    <h2>Страницы <a class="edit" href="<?= base_url(); ?>/admin/page/create">➕</a></h2> 
                    <?php foreach ($pages as $page_item): ?>
                    <div class="line">
                    <a class="edit" href="<?= base_url(); ?>/admin/page/edit/<?php echo $page_item['id']; ?>">✍</a> 
                    <a class="delete" href="<?= base_url(); ?>/admin/page/delete/<?php echo $page_item['id']; ?>">✖</a> 
                    <a href="<?= base_url(); ?>/<?php echo $page_item['url']; ?>"><?php echo ($page_item['title']); ?></a> 
                    <br>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </body>
</html>
