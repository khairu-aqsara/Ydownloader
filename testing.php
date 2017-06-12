<?php 
require __DIR__ . '/vendor/autoload.php';

use Khairu\Ydownloader\Youtube;

$testing = new Youtube;

// if using Youtube Api v 3
//$testing->Download("https://www.youtube.com/watch?v=ceAamLAFpHs", true);
//$respon = $testing->msg['data'];
//print_r($respon->snippet->title);

// when not using an api
$testing->Download("https://www.youtube.com/watch?v=0t0jkYw2iXg",false,"webm");
$respon = $testing->msg;
print_r($respon);