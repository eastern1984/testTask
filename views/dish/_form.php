<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Dish */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dish-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ingredients')->hiddenInput(['class' => 'hidden', 'id' => 'ingredients']) ?>

    <ul class="list-unstyled ">
    <?php foreach ($ingridients as $item) { ?>
        <li> <?= Html::checkbox('ingridient', false, ['label' => $item->name . ' - ' . (($item->status) ? ('Включен') : ('Выключен')), 'class' => 'main' , 'data-id' => $item->id]);?> </li>
    <?php }?>
    </ul>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs(
    <<<JS
    
    $(function() {
    
        function checkboxProcessing() {
            var arr = $('#ingredients').val().split(',');
            for (i = 0; i < arr.length; i++) {
                console.log(arr[i]);
                if ((arr[i] != null) && (arr[i] != '')) {
                    $('[data-id=' + arr[i] + ']').attr('checked', true);
                    if ($('[data-id=' + arr[i] + ']').hasClass('main')) {
                       
                        $('[data-id=' + arr[i] + ']').closest('li').find('ul').find('input').attr("disabled", true);
                    }
                }
            } 
        }
       
        checkboxProcessing();
        
        $("input[type=checkbox]").on( "click", function() {
            var string = '';
            $("input[type=checkbox]").attr('disabled', false);
            $("input:checked").each(function( index ) {
                string = string + $( this ).data('id') + ',';
                $(this).closest('li').find('ul').find('input').attr("disabled", true);
                $(this).closest('li').find('ul').find('input').attr("disabled", true);
            });
            if (string.length > 2) {
                string = ',' + string;
            }
            $('#ingredients').val(string);
        } );
    });
JS
);?>
