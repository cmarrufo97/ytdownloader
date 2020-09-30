<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Html;
use YoutubeDl\YoutubeDl;
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
    $dl = new YoutubeDl([
        'extract-audio' => true,
        'audio-format' => 'mp3',
        'audio-quality' => 0, // best
        'output' => '%(title)s.%(ext)s',
    ]);

    $dl->setDownloadPath(Yii::getAlias('@audio'));


    if ($url !== '' && $dl->getInfo($url) !== null && $dl->getInfo($url) !== '') {
        try {
            $video = $dl->download($url);
        } catch (NotFoundException $e) {
        } catch (PrivateVideoException $e) {
        } catch (CopyrightException $e) {
        } catch (\Exception $e) {
        }
        $info = $dl->getInfo($url);
        $img = $info->getThumbnails()[2]['url'];
        $title = $info->getTitle();
        $fecha = Yii::$app->formatter->asDate($info->getUploadDate());
        $path = $video->getFile()->getPathname();

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
                    <?= $info->getViewCount() . " visualizaciones - $fecha" ?>
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