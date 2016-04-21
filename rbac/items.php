<?php return [
    'default' => [
        'type' => 1,
        'children' => [
            'user/default/update',
        ],
    ],
    'user_admin' => [
        'type' => 1,
        'children' => [
            'user/user/index',
            'user/user/create',
            'user/user/update',
            'user/user/view',
        ],
//        'description' => 'Member',
//        'ruleName' => 'member',
//        'data' => NULL,
    ],
    'user/user/index' => ['type' => 2],
    'user/user/create' => ['type' => 2],
    'user/user/update' => ['type' => 2],
    'user/user/view' => ['type' => 2],
];
