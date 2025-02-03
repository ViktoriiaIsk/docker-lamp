<?php
require('User.class.php');

$u = new User('username1', 'email1@example.com', 'avatar1');
$twee = new User('username2', 'email2@example.com', 'avatar2');
$drie = new User('username3', 'email3@example.com');


// $u->setUserName('test');

// print $u->getUserName();

print "<pre>";
print_r($u);
print_r($twee);
print_r($drie);
print "</pre>";
