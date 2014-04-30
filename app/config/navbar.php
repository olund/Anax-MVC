<?php
/**
 * Config-file for navigation bar.
 *
 */
return [

    // Use for styling the menu
    'class' => 'navbar',
 
    // Here comes the menu strcture
    'items' => [

        // This is a menu item
        'home'  => [
            'text'  => '<i class="fa fa-home"></i> Home',
            'url'   => '',
            'title' => 'Home'
        ],
 
        // This is a menu item
        'redovisning'  => [
            'text'  => '<i class="fa fa-edit"></i> Redovisning',
            'url'   => 'redovisning',
            'title' => 'Redovisning',

            // Here we add the submenu, with some menu items, as part of a existing menu item
          /*  'submenu' => [

                'items' => [

                    // This is a menu item of the submenu
                    'item 1'  => [
                        'text'  => 'Item 1',   
                        'url'   => 'item1.php',  
                        'title' => 'Some item 1'
                    ],

                    // This is a menu item of the submenu
                    'item 2'  => [
                        'text'  => 'Item 2',   
                        'url'   => 'item2.php',  
                        'title' => 'Some item 2'
                    ],
                ],
            ], */
        ],

        'theme' => [
            'text'  => '<i class="fa fa-picture-o"></i> Tema',
            'url'   => 'theme',
            'title' => 'Tema',
        ],

        'Users' => [
            'text'  => '<i class="fa fa-user"></i> Användare',
            'url'   => 'users.php',
            'title' => 'Användare',
        ],
 
        // This is a menu item
        'source' => [
            'text'  =>'<i class="fa fa-wrench"></i> Source',
            'url'   =>'source',
            'title' => 'Source'
        ],
    ],
 
    // Callback tracing the current selected menu item base on scriptname
    'callback' => function ($url) {
        if ($url == $this->di->get('request')->getRoute()) {
            return true;
        }
    },

    // Callback to create the urls
    'create_url' => function ($url) {
        return $this->di->get('url')->create($url);
    },
];
