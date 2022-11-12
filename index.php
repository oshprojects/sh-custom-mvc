<?php
use app\Http\Controllers\Core\DotEnv;
use app\Http\Controllers\Core\DB;

spl_autoload_register(static function ($class) {
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }
    return false;
});

(new DotEnv(__DIR__.'\.env'))->load();
$db = new DB();

//example
print_r($db->from('users')->get());

