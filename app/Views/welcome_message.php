<!doctype html>
<html>
    <head>
        <title>Главная</title>

        <link rel="shortcut icon" type="image/png" href="/favicon.ico"/>
    </head>
    <body>
        <?php foreach ($news as $news_item): ?>
            <a href="/news/<?php echo $news_item['url']; ?>"><?php echo ($news_item['title']); ?></a> <br>
        <?php endforeach; ?>

        <?= $pager->links() ?>
    </body>
</html>
