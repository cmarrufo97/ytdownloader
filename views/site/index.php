<?php

declare(strict_types=1);
/* @var $this yii\web\View */
/** @var $video YoutubeDl\Entity\Video*/

use yii\bootstrap4\Html;
use YoutubeDl\YoutubeDl;
use YoutubeDl\Options;
use YoutubeDl\Exception\CopyrightException;
use YoutubeDl\Exception\NotFoundException;
use YoutubeDl\Exception\PrivateVideoException;

$this->title = 'Youtube Downloader';

?>
<div class="site-index">
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Ingrese aquí una URL de Youtube para descargar el audio.</h1>
        </div>
        <?= Html::beginForm('', 'get') ?>
        <?= Html::textInput('url', $url, ['class' => 'form-control', 'id' => 'url']) ?>
        <?= Html::submitButton('Obtener', ['class' => 'btn btn-primary mt-2']) ?>
        <?= Html::endForm() ?>
    </div>


    <?php
    $dl = new YoutubeDl();

    if (!empty($url) && $url !== null) {
        $regex = '/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/';
        if (preg_match($regex, $url)) {
            try {
                $collection = $dl->download(
                    Options::create()
                        ->downloadPath(Yii::getAlias('@audio'))
                        ->extractAudio(true)
                        ->audioFormat('mp3')
                        ->audioQuality('0') // best
                        ->output('%(title)s.%(ext)s')
                        ->url($url)
                );

                foreach ($collection->getVideos() as $video) {
                    if ($video->getError() !== null) {
                        echo "Error downloading video: {$video->getError()}.";
                    } else {
                        $img = $video->getThumbnails()[2]->getUrl();
                        $title = $video->getTitle();
                        $fecha = Yii::$app->formatter->asDate($video->getUploadDate());
                        $path = $video->getFile()->getPathname();
                        $viewCount = $video->getViewCount();
                    }
                }
            } catch (Exception $e) {
            }
        } else {
            Yii::$app->session->setFlash('error', 'Por favor, introduzca una url de YouTube correcta.');
            return;
        }
    ?>
        <div>
            <div class="float-left mt-3 ml-3">
                <?= Html::img($img, ['class' => 'img-video', 'alt' => 'Imagen video']) ?>
            </div>
            <div class="float-left meta">
                <div class="title-video mt-3 ml-3">
                    <?= $title ?>
                </div>
                <div class="ml-4">
                    <?= $viewCount . " visualizaciones - $fecha" ?>
                </div>
                <div class="text-center mt-4">
                    <?= Html::a('Descargar', ['site/descargar'], [
                        'class' => 'btn btn-sm btn-primary',
                        'data' => [
                            'method' => 'POST',
                            'params' => ['video' => $title . '.mp3', 'path' => $path],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</div>