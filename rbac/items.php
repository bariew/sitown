<?php return [
    'default' => [
        'type' => 1,
        'children' => [
            'user/default/*',
        ],
//        'description' => 'Member',
//        'ruleName' => 'member',
//        'data' => NULL,
    ],
    'user_admin' => ['type' => 1, 'children' => ['user/*/*']],
    'code_admin' => ['type' => 1, 'children' => ['code/*/*']],
    'poll_admin' => ['type' => 1, 'children' => ['poll/*/*']],
    'forum_admin'=> ['type' => 1, 'children' => ['forum/*/*']],
    'page_admin' => ['type' => 1, 'children' => ['page/*/*']],

    // guest
    'app/site/error'        => ['type' => 2],
    'app/site/index'        => ['type' => 2],
    'page/default/view'     => ['type' => 2],
    'user/default/logout'   => ['type' => 2],
    'user/default/login'    => ['type' => 2],

    //default
    'user/default/*'        => ['type' => 2],

    //admin
    'user/*/*' => ['type' => 2],
    'code/*/*' => ['type' => 2],
    'poll/*/*' => ['type' => 2],
    'forum/*/*'=> ['type' => 2],
    'page/*/*' => ['type' => 2],
];
