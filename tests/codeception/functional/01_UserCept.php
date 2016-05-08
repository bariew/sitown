<?php
$I = new FunctionalTester($scenario);
$I->wantTo('ensure that User create work');

$I->fixtureLogin('user1');
$I->go(['/user/user/create']);
$I->testForm('#user-form', 'User', [], [
    'email' => 123,
    'password' => '',
]);

$I->testForm('#user-form', 'User', [
    'email' => 'test@test.test',
    'password' => 'admin',
]);
$I->seeElement('.alert-warning'); // needs polling
