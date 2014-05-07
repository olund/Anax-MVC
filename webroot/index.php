<?php

require __DIR__.'/config_with_app.php';

$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar.php');
$app->session;
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

    $form = $app->form;

    $name = isset($_SESSION['data']['name']) ? $_SESSION['data']['name'] : null;
    $text = isset($_SESSION['data']['content']) ? $_SESSION['data']['content'] : null;
    $email = isset($_SESSION['data']['email']) ? $_SESSION['data']['email'] : null;
    $web = isset($_SESSION['data']['web']) ? $_SESSION['data']['web'] : null;
    $url = isset($_SESSION['data']['url']) ? $_SESSION['data']['url'] : null;
    $id = isset($_SESSION['data']['id']) ? $_SESSION['data']['id'] : null;

    $app->session->noSet('data');

    $form = $form->create(['id' => 'form-link'], [
        'id' => [
            'type'        => 'hidden',
            'value'       => isset($id) ? $id : null,
            'required'    => false,
        ],
        'url' => [
            'type'        => 'hidden',
            'value'       => $app->request->getCurrentUrl(),
            'required'    => false,
        ],
        'name' => [
            'type'        => 'text',
            'label'       => 'Name:',
            'required'    => true,
            'value'       => isset($name) ? $name : null,
            'validation'  => ['not_empty'],
        ],
        'text' => [
            'type'        => 'textarea',
            'label'       => 'Comment:',
            'required'    => true,
            'value'       => isset($text) ? $text : null,
            'validation'  => ['not_empty'],
        ],
        'email' => [
            'type'        => 'email',
            'label'       => 'Email:',
            'required'    => true,
            'value'       => isset($email) ? $email : null,
            'validation'  => ['email_adress'],
        ],
        'web' => [
            'type'        => 'url',
            'label'       => 'Website:',
            'required'    => false,
            'value'       => isset($web) ? $web : null,
        ],
        'submit' => [
            'type'      => 'submit',
            'callback'  => function($form) {
                $form->saveInSession = true;
                return true;
            }
        ],
        'reset' => [
            'type'      => 'reset',
            'callback'  => function($form) {
                $form->saveInSession = false;
                return true;
            }
        ],
    ]);

    // Check the status of the form
    $status = $form->check();

    if ($status === true) {

        // What to do if the form was submitted?
        $name = $_SESSION['form-save']['name']['value'];
        $text = $_SESSION['form-save']['text']['value'];
        $email = $_SESSION['form-save']['email']['value'];
        $web = $_SESSION['form-save']['web']['value'];
        $url = $_SESSION['form-save']['url']['value'];
        $id = $_SESSION['form-save']['id']['value'];

        session_unset($_SESSION['form-save']);

        if (!empty($id)) {
            $app->dispatcher->forward([
                'controller' => 'comments',
                'action'     => 'save',
                'params'     => [$name, $text, $email, $web, $id],
            ]);
        } else{
            $app->dispatcher->forward([
                'controller' => 'comments',
                'action'     => 'add',
                'params'     => [$name, $text, $email, $web, $url],
            ]);
        }
    }

    $app->views->addString('<div class="article1">' . $form->getHTML() . '</div>', 'sidebar');
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
