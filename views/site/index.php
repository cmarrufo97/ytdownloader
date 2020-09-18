<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Html;

$this->title = 'My Yii Application';
Yii::debug($url);
?>
<div class="site-index">
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Ingrese aquí una URL de Youtube para descargar el audio.</h1>
        </div>
        <?= Html::beginForm('site/index', 'get') ?>
        <?= Html::textInput('url', $url, ['class' => 'form-control', 'id' => 'url']) ?>
        <?= Html::submitButton('Descargar', ['class' => 'btn btn-primary mt-2']) ?>
        <?= Html::endForm() ?>
    </div>

</div>