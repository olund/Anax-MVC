<?php

require __DIR__.'/config_with_app.php';
/*$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar.php');*/
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);

// Start session.
$app->withSession();

// Set flash.
$di->setShared('flash', function () {
    $flash = new \Anax\Flash\CFlash();
    return $flash;
});

$app->router->add('', function () use ($app) {
    $app->theme->setTitle('Flash');

    $message = $app->flash->success('Lyckades');
    $app->flash->dump();

    $app->views->add('flash/test', [
        'title' => 'Flash',
        'message' => $message,
    ]);
});


$app->router->handle();
$app->theme->render();
