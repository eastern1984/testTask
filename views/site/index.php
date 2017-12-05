<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="body-content">

        <h2>Выбор ингридиентов:</h2>
        <div class="row">
            <ul class="list-unstyled ">
                <?php foreach ($ingridients as $item) {
                    if ($item->status == 1) {?>
                    <li> <?= Html::checkbox('ingridient', false, ['label' => $item->name,'data-id' => $item->id]);?> </li>
                    <?php }
                }?>
            </ul>
        </div>

        <h2>Найденные блюда:</h2>
        <p class = "result"></p>

    </div>
</div>

<?php
$this->registerJs(
    <<<JS
    
    $(function() {
        $("input[type=checkbox]").on( "click", function() {
            var string = '';
            $("input[type=checkbox]").attr('disabled', false);
            $("input:checked").each(function( index ) {
                string = string + $( this ).data('id') + ',';
            });
            if ($("input:checked").length > 4) {
                $("input:not(:checked)").attr('disabled', true);
            }
            if (string.length > 2) {
                string = string.substr(0, string.length - 1);
            }
            
            if ($("input:checked").length > 1)
                {
                    console.log(string);
                    $.ajax({
                    method: 'POST',
                    url: '?r=dish/find',
                    data: {string: string}
                }).done(function(msg) {
                    $(".result").text(msg.result);
                });    
                } else{
                    $(".result").text('Выберите больше ингредиентов');    
                }
        } );
    });
JS
);?>

