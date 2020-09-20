<?php

use YoutubeDl\YoutubeDl;

$dl = new YoutubeDl([
    'extract-audio' => true,
    'audio-format' => 'mp3',
    'audio-quality' => 0, // best
    'output' => '%(title)s.%(ext)s',
]);
$dl->setDownloadPath('/home/christian/Descargas');

$video = $dl->download('https://www.youtube.com/watch?v=oDAw7vW7H0c');

$dl->onProgress(function ($progress) {
    $percentage = $progress['percentage'];
    $size = $progress['size'];
    $speed = $progress['speed'] ?? null;
    $eta = $progress['eta'] ?? null;

    echo "Percentage: $percentage; Size: $size";
    if ($speed) {
        echo "; Speed: $speed";
    }
    if ($eta) {
        echo "; ETA: $eta";
    }
    // Will print: Percentage: 21.3%; Size: 4.69MiB; Speed: 4.47MiB/s; ETA: 00:01
});
