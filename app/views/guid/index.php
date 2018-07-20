<div class="header">
    <img src="/images/renault_logo.png">
    <span class="logo-name">Электронный консультант</span>
</div>
<div class="container-fluid area">
    <div class="text-center block-title">
        Выберите автомобиль
    </div>
    <div class="model-carousel row">
        <?php foreach($models as $model) :?>
            <div class="item-model text-center">
                <img style="height:300px;margin:auto;" src="<?=$model->alpha;?>">
                <div class="car-name">
                    <?=$model->name;?>
                </div>
                <div class="begin-price">от <?= number_format(\app\models\car_6_complect::minPrice($model->id),0,'',' ');?> руб.</div>
            </div>
        <?php endforeach;?>
    </div>
</div>
<div class="footer">
    <div class="oven-logo">
        <img style="width:100px;" src="/images/logo.png">
    </div>
    <div class="oven-info">
        Автосалон Renault (ООО «Фирма «Овен-Авто»)<br/>
        Республика Коми, Сыктывкар, ул. Гаражная 1<br/>
        8(8212) 288-588
    </div>
</div>