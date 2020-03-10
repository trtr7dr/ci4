<!doctype html>
<html>
    <head>
        <title>Главная</title>

        <link rel="shortcut icon" type="image/png" href="/favicon.ico"/>
    </head>
    <body>
        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrf"/>
        
        <div id="news">
        <?php foreach ($news as $news_item): ?>
        <div class="one_news" data-id="<?php echo $news_item['id']; ?>"><a href="/news/<?php echo $news_item['url']; ?>"><?php echo ($news_item['title']); ?></a> <br></div>
        <?php endforeach; ?>
        </div>
        <div id="more" onclick="more()">Еще!</div>

        <?= $pager->links() ?>
        
        <script src="<?= base_url(); ?>/js/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script src="<?= base_url(); ?>/js/loadmore.js" type="text/javascript"></script>
    </body>
</html>
