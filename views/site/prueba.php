<?php

use YoutubeDl\Exception\CopyrightException;
use YoutubeDl\Exception\NotFoundException;
use YoutubeDl\Exception\PrivateVideoException;
use YoutubeDl\YoutubeDl;

$dl = new YoutubeDl([
    'continue' => true, // force resume of partially downloaded files. By default, youtube-dl will resume downloads if possible.
    'format' => 'bestvideo',
]);
// For more options go to https://github.com/rg3/youtube-dl#user-content-options

// You can set the youtube-dl binary path directly, so the library will know
// how to execute it without trying to locate it automatically. Also you can
// add it to PATH environment variable.
// $dl->setBinPath('/path/to/youtube-dl');

// If you are getting some Python related errors on windows (ex.: https://github.com/norkunas/youtube-dl-php/pull/40),
// you can try to set the python path, it may help.
// $dl->setPythonPath('C:\Python\python.exe');

// Set the download path where you want to store downloaded data
$dl->setDownloadPath('/home/christian/Descargas');

// Enable debugging
/*$dl->debug(function ($type, $buffer) {
    if (\Symfony\Component\Process\Process::ERR === $type) {
        echo 'ERR > ' . $buffer;
    } else {
        echo 'OUT > ' . $buffer;
    }
});*/
try {
    $video = $dl->download('https://www.youtube.com/watch?v=oDAw7vW7H0c');
    echo $video->getTitle(); // Will return Phonebloks
    // $video->getFile(); // \SplFileInfo instance of downloaded file
} catch (NotFoundException $e) {
    // Video not found
} catch (PrivateVideoException $e) {
    // Video is private
} catch (CopyrightException $e) {
    // The YouTube account associated with this video has been terminated due to multiple third-party notifications of copyright infringement
} catch (\Exception $e) {
    // Failed to download
}
