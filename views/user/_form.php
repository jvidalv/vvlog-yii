<?php

use app\models\Language;
use app\models\Media;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $info app\models\UserHasInfo */
/* @var $form yii\widgets\ActiveForm */

$this->title = $model->fullName;

if (Yii::$app->user->identity->isAdmin()) {
    $this->params['breadcrumbs'][] = ['label' => 'Llistat de usuaris', 'url' => ['index']];
}
$this->params['breadcrumbs'][] = $this->title;

?>
    <section class="welcome p-t-10">
        <div class="container">
            <?php $form = ActiveForm::begin([
                'fieldConfig' => [
                    'options' => ['class' => 'form-group row'],
                    'template' => "<div class=\"col col-md-3\">{label}</div>\n<div class=\"col-12 col-md-9\">{input}<small class=\"help-block form-text c-red\">{error}</small></div>\n",
                ]
            ]); ?>
            <div class="table-data__tool">
                <div class="table-data__tool-left">
                    <h1 class="title-1"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="table-data__tool-right">
                    <?= Html::submitButton('💾 ' . Yii::t('app', 'save'), ['class' => 'au-btn au-btn-icon au-btn--green']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-header">
                            <strong><?= Yii::t('app', 'Informació bàsica') ?></strong>
                        </div>
                        <div class="card-body card-block">
                            <?= $form->field($model, 'nom')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($model, 'cognoms')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($model, 'telefon')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($model, 'language_id')->dropDownList(ArrayHelper::map(Language::find()->all(), 'code', 'name')) ?>
                        </div>
                    </div>
                    <?php if (Yii::$app->user->identity->isAdmin()): ?>
                        <div class="card">
                            <div class="card-header">
                                <strong><?= Yii::t('app', 'Dades usuari') ?></strong>
                            </div>
                            <div class="card-body card-block">
                                <?= $form->field($model, 'actiu')->radioList([1 => Yii::t('app', 'yes'), 0 => Yii::t('app', 'no')], ['class' => 'checkbox-inline-josep']) ?>
                                <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
                                <?= $form->field($model, 'role')->dropDownList($model::ROLES) ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <strong><?= Yii::t('app', 'foto') ?></strong>
                        </div>
                        <div class="card-body">
                            <?= FileInput::widget([
                                'name' => 'media_upload[]',
                                'id' => 'media-input',
                                'options' => [
                                    'accept' => '.jpeg,.jpg,.png'
                                ],
                                'language' => 'ca',
                                'pluginOptions' => [
                                    'initialPreview' => [
                                        '/' . Media::img($model->id, Media::TBL_USER, [150, 150]),
                                    ],
                                    'initialPreviewAsData' => true,
                                    'uploadUrl' => Url::to(['/media/upload-files',
                                        'table_id' => $model->id,
                                        'table_name' => Media::TBL_USER,
                                    ]),
                                    'deleteUrl' => Url::to(['/media/delete-files',
                                        'table_id' => $model->id,
                                        'table_name' => Media::TBL_USER,
                                    ]),
                                    'showRemove' => false,
                                    'maxFileSize' => 300,
                                ]
                            ]) ?>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <strong><?= Yii::t('app', 'extra info') ?></strong>
                        </div>
                        <div class="card-body">
                            <?= $form->field($info, 'information_'.$model->language_id)->textArea(['rows' => 2]) ?>
                        </div>
                    </div>
                </div>
    </section>
<?php ActiveForm::end(); ?>