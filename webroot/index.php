<?php

require __DIR__.'/config_with_app.php';

// Start session.
$app->withSession();

$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar.php');
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);
$di->set('form', '\Mos\HTMLForm\CForm');

$di->setShared('db', function () {
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require ANAX_APP_PATH . 'config/database_mysql.php');
    $db->connect();
    return $db;
});

// Använd nyskapad Comment och commentcontroller...
$di->set('CommentsController', function () use ($di) {
    $controller = new \Anax\Comments\CommentsController();
    $controller->setDI($di);
    return $controller;
});


$app->router->add('', function () use ($app) {
    $app->theme->setTitle('Me-sida');
    $content = $app->fileContent->get('me.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->add('me/page', [
        'content' => $content,
        'byline'  => $byline,
    ], 'main');
});

$app->router->add('redovisning', function () use ($app) {
    $app->theme->setTitle("Redovisning");
    $content = $app->fileContent->get('redovisning.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
    $app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
    ], 'main');

    // Comments
    $app->dispatcher->forward([
        'controller' => 'comments',
        'action'     => 'view',
    ]);
});


$app->router->add('theme', function () use ($app) {
    $app->theme->setTitle('Mitt tema');

    $slideshow = <<<EOD
    <div id="slideshow" class='slideshow' data-host="" data-path="img/slideshow/" data-images='["s-1.png", "s-2.png"]'>
    <img src='img/slideshow/s-1.png' width='960' height='180' alt='Slides'/>
    </div>
EOD;
    $app->views->add('me/theme', [
        'content' => $slideshow,
    ],'flash');

    $app->views->addString('<h3>Detta är en feature</h3><p>Feature numero uno</p>', 'featured-1')
               ->addString('<h3>KOLLA IN SLIDESHOWEN::D:D::D:</h3><p>Feature numero dos</p>', 'featured-2')
               ->addString('<h3>Detta är en feature</h3><p>Feature numero tres</p>', 'featured-3')
               ->addString('<h1>Main</h1><p>Detta är main. Uber fint innehåll kan man skriva här xDxdDxDxD</p>', 'main')
               ->addString('<h2>Även en sidebar finns!</h2><p>fin sidebar, fin sidebar, fin sidebar, fin sidebar, fin sidebar, fin sidebar, fin sidebar, fin sidebar, fin sidebar, fin sidebar, fin sidebar, fin sidebar, </p>', 'sidebar')
               ->addString('<h4>Triptych</h4><p>Första kolumnens innehåll</p>', 'triptych-1')
               ->addString('<h4>Triptych</h4><p>Andra kolumnens innehåll</p>', 'triptych-2')
               ->addString('<h4>Triptych</h4><p>Tredje kolumnens innehåll</p>', 'triptych-3');

});

$app->router->add('source', function () use ($app) {
    $app->theme->addStylesheet('css/source.css');
    $app->theme->setTitle('Source');

    $source = new \Mos\Source\CSource([
        'secure_dir' => '..',
        'base_dir'   => '..',
        'add_ignore' => ['.htaccess'],
    ]);

    $app->views->add('me/source', [
        'content' => $source->View(),
    ]);
});


$app->router->handle();
$app->theme->render();
