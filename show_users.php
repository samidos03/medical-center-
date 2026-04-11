<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
$users = DB::table('users')->select('email','role')->get();
foreach($users as $u) {
    echo $u->email . ' | ' . $u->role . ' | password' . PHP_EOL;
}
