# Ydownloder v.0.1

Youtube Downloader is a php library to Create youtube Direct Link for download purpose, this library using two methods now, 1st using Youtube API v3, if using this option you need to create your own API Key instead using mine, 2nd method is not using Youtube API, with this library we can download youtube video with various format

```
<?php 
require __DIR__ . '/vendor/autoload.php';

use Khairu\Ydownloader\Youtube;

$testing = new Youtube;

// if using Youtube Api v 3
$testing->Download("https://www.youtube.com/watch?v=ceAamLAFpHs", true);
$respon = $testing->msg['data'];
print_r($respon->snippet->title);

// when not using an api
$testing->Download("https://www.youtube.com/watch?v=0t0jkYw2iXg",false,"webm");
$respon = $testing->msg;
print_r($respon);
```

## Install

clone this repository or download the sources, then run `composer update` then you good to go
[Relases Download](https://github.com/khairu-aqsara/Ydownloader/releases)