<?php return [
    'default' => [
        'type' => 1,
        'children' => [
            '.*/default/.*',
        ],
//        'description' => 'Member',
//        'ruleName' => 'member',
//        'data' => NULL,
    ],
    'user_admin' => ['type' => 1, 'children' => ['user/.*']],
    'code_admin' => ['type' => 1, 'children' => ['code/.*']],
    'poll_admin' => ['type' => 1, 'children' => ['poll/.*']],
    'page_admin' => ['type' => 1, 'children' => ['page/.*']],
    // guest
    'app/site/.*'        => ['type' => 2],
    'user/default/.*'    => ['type' => 2],
    'page/default/.*'    => ['type' => 2],
    //default
    '.*/default/.*'      => ['type' => 2],
    //admin
    'user/.*' => ['type' => 2],
    'code/.*' => ['type' => 2],
    'poll/.*' => ['type' => 2],
    'page/.*' => ['type' => 2],
];
