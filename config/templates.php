<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 9/6/15 - 12:08 PM
 */
return [
    'templates' => [
        'layout' => 'app::layout',
        'map' => [
            //html templates
            'app::layout' => 'view/layout/layout.phtml',
            'page::home' => 'view/action/home.phtml',
            'page::user-list' => 'view/action/user-list.phtml',
            'page::user-registration' => 'view/action/user-registration-form.phtml',
            'page::user-todo-list' => 'view/action/user-todo-list.phtml',
            'page::user-todo-form' => 'view/action/user-todo-form.phtml',
            //riot tags
            'riot::user-form' => 'view/riot/user-form.phtml',
            'riot::user-todo-form' => 'view/riot/user-todo-form.phtml',
        ],
        'plugins' => [
            'riotTag' => \Prooph\ProophessorDo\App\View\Helper\RiotTag::class,
        ]
    ]
];
