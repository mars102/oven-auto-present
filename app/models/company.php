<?php
namespace app\models;
Class company extends \app\core\Model
{

    public $table = 'company';

    public function getCompanyByCar($car)
    {
        

        $sql = "SELECT c.* FROM company as c 
            JOIN company_car as a 
                on c.id = a.id_company 
            WHERE 
                (a.vin = '{$car->vin}' or a.model = {$car->id_model} or a.complect = {$car->id_complect}) 
                and FROM_UNIXTIME(c.day_in) <= CURRENT_DATE() AND FROM_UNIXTIME(c.day_out) >= CURRENT_DATE() AND c.status = 2
                ORDER BY c.razdel,c.day_in
        "; 
        //echo "$sql";
        $data = $this->getCustomSQL($sql);
        //echo "$sql";
        //\app\core\Html::prA($data);
        if(is_array($data)) :
        foreach ($data as $key => $value) {
            $sql = "SELECT * FROM company_car WHERE id_company={$value->id} and type = 1"; 
            $c_car = new \app\models\company_car();
            $c_car = $c_car->getCustomSQL($sql);

            $sql2 = "SELECT * FROM company_car WHERE id_company={$value->id} and type = 2"; 
            $negative = new \app\models\company_car();
            $negative = $negative->getCustomSQL($sql2);

            $res = 0;
            foreach ($c_car as $i => $obj) {
                /*НАХОЖУ НЕ ПУСТЫЕ ПОЛЯ В УСЛОВИЯХ ВКЛЮЧОННЫХ МАШИН*/
                $aktualCount = 0;//счётчик не пустых параметров включонных машин
                $count = 0;

                foreach ($obj as $t => $param) {
                    if(!empty($param))
                        if(!is_object($param))
                            $aktualCount++;
                }
                $aktualCount = $aktualCount-4;
                if(!empty($obj->vin))
                {
                    if($obj->vin == $car->vin)
                    {
                        $count++;
                    }
                }
                if(!empty($obj->model))
                {
                    if($obj->model == $car->id_model)
                    {
                        $count++;
                    }
                }
                if(!empty($obj->complect))
                {
                    if($obj->complect == $car->id_complect)
                    {
                        $count++;
                    }
                }
                if(!empty($obj->transmission))
                {
                    if($obj->transmission == $car->motor->transmission)
                    {
                        $count++;
                    }
                }
                if(!empty($obj->privod))
                {
                    if($obj->privod == $car->motor->privod)
                    {
                        $count++;
                    }
                }
                if(!empty($obj->location))
                {
                    if($obj->location == $car->location)
                    {
                        $count++;
                    }
                }
                if(!empty($obj->pricestart))
                {
                    if($obj->pricestart <= $car->getCarPrice())
                    {
                        $count++;
                    }
                }
                if(!empty($obj->pricefinish))
                {
                    if($obj->pricefinish >= $car->getCarPrice())
                    {
                        $count++;
                    }
                }
                
                if($aktualCount==$count)
                    $res = 1;
            }

            if(is_array($negative)) : 
            foreach ($negative as $i => $obj) {
                /*НАХОЖУ НЕ ПУСТЫЕ ПОЛЯ В УСЛОВИЯХ ВКЛЮЧОННЫХ МАШИН*/
                $aktualCount = 0;//счётчик не пустых параметров включонных машин
                $count = 0;

                foreach ($obj as $t => $param) {
                    if(!empty($param))
                        if(!is_object($param))
                            $aktualCount++;
                }
                $aktualCount = $aktualCount-4;
                if($aktualCount==0)
                    continue;
                if(!empty($obj->vin))
                {
                    if($obj->vin == $car->vin)
                    {
                        $count++;
                    }
                }
                if(!empty($obj->model))
                {
                    if($obj->model == $car->id_model)
                    {
                        $count++;
                    }
                }
                if(!empty($obj->complect))
                {
                    if($obj->complect == $car->id_complect)
                    {
                        $count++;
                    }
                }
                if(!empty($obj->transmission))
                {
                    if($obj->transmission == $car->motor->transmission)
                    {
                        $count++;
                    }
                }
                if(!empty($obj->privod))
                {
                    if($obj->privod == $car->motor->privod)
                    {
                        $count++;
                    }
                }
                if(!empty($obj->location))
                {
                    if($obj->location == $car->location)
                    {
                        $count++;
                    }
                }
                if(!empty($obj->pricestart))
                {
                    if($obj->pricestart <= $car->getCarPrice())
                    {
                        $count++;
                    }
                }
                if(!empty($obj->pricefinish))
                {
                    if($obj->pricefinish >= $car->getCarPrice())
                    {
                        $count++;
                    }
                }
                
                if($aktualCount==$count)
                    $res = 0;
            }
            endif;

            if($res==0)
                unset($data[$key]);
        }
        endif;

        if(is_array($data))
            return $data;
        return array();
    }

    public function getStatus()
    {
        switch ($this->status)
        {
            case 1:
                return "Не активна";
                break;
            case 2:
                return "Активна";
                break;
            default:
                return "";
                break;
        }
    }

    public function getRazdel()
    {
        switch ($this->razdel)
        {
            case 1:
                return "Скидка";
                break;
            case 2:
                return "Подарок";
                break;
            case 3:
                return "Сервис";
                break;
            case 4:
                return "Акция";
                break;
            default:
                return "";
                break;
        }
    }

    public function getScenario()
    {
        switch ($this->scenario)
        {
            case 1:
                return "Расчёт";
                break;
            case 2:
                return "Бюджет";
                break;
            case 3:
                return "Номенклатура";
                break;
            case 4:
                return "Описание";
                break;
            default:
                return "";
                break;
        }
    }

    /*HTML*/
    public function getBlock($car)
    {
        //\app\core\Html::prA($car);

        $skidka = 0;
        if(!empty($this->base))
            $skidka+=$car->complect->price;
        if(!empty($this->optionlist))
            $skidka+=$car->getPackPrice();
        if(!empty($this->dop))
            $skidka+=$car->dopprice;

        $skidka = $skidka*($this->value/100);
        if( ($skidka>$this->max) && ($this->max!=0) )
        {
            $skidka = $this->max;
            $skidka = round($skidka,-3);
            $skidka = number_format($skidka,0,'',' ')." руб. ";
        }

        else{
            $skidka = $this->value."% ";
        }

        $bydget = number_format($this->bydget,0,'',' ')." руб. ";
        

        $this->title = str_replace("<model>", $car->model->brand->name.' '.$car->model->name, $this->title);
        $this->title = str_replace("<bydjet>", $bydget, $this->title);
        $this->title = str_replace("<procent>", $skidka, $this->title);

        $this->ofer = str_replace("<model>", $car->model->brand->name.' '.$car->model->name, $this->ofer);
        $this->ofer = str_replace("<bydjet>", $bydget, $this->ofer);
        $this->ofer = str_replace("<procent>", $skidka, $this->ofer);

        $this->text = str_replace("<model>", $car->model->brand->name.' '.$car->model->name, $this->text);
        $this->text = str_replace("<bydjet>", $bydget, $this->text);
        $this->text = str_replace("<procent>", $skidka, $this->text);
    ?>
        <div class="col-sm-6 ">
            <div class="company-wrapper">
                <div class="company">
                    <div class="title">
                        <?=$this->title;?>
                    </div>
                    <div class="description">
                        <?=$this->text;?>
                    </div>
                    <div class="ofer">
                        <div class="type_company">
                            <?=$this->getRazdel();?>
                        </div>
                        <div style="width: 100%;">
                            <?=$this->ofer;?>
                            <div 
                                data-main="<?=$this->main;?>"
                                data-skidka="<?=$skidka;?>"
                                data-bydget = "<?=$this->bydget;?>"
                                data-type="<?=$this->razdel;?>"
                                data-scenario="<?=$this->scenario;?>"
                                data-input="0" 
                                class="checkcompany text-center" 
                                data-id="<?=$this->id;?>" 
                                style="float: right;border:1px solid #ccc;width:25px;height: 25px;cursor: pointer;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?
    }


    public static function getContainerCompany($company,$car)
    {
    ?>
        <div class="container block" style="padding-top: 0px;">
            <div class="row">
                <div class="col-sm-8" style="padding:0px;">
                <?php if(is_array($company)) : ?>
                    <?php foreach ($company as $key => $value) : ?>
                        <?=$value->getBlock($car);?>
                    <?php endforeach;?>
                <?php endif;?>
                </div>
                <div class="col-sm-4">
                    <div class="company-border" style="float: left;">
                        <div class="company-check">
                            <div class="title">
                                Ваши выгоды
                            </div>

                            <div class="car-price" style="">
                                <span class="left-block">Цена базы:</span>
                                <span class="right-block"> <?=number_format($car->complect->price,0,'',' ');?> руб.</span>
                            </div>

                            <div class="car-price" style="">
                                <span class="left-block">Цена опций:</span>
                                <span class="right-block"><?=number_format($car->getPackPrice(),0,'',' ');?> руб.</span>
                            </div>

                            <div class="car-price" style="">
                                <span class="left-block">Цена доп. оборудования:</span>
                                <span class="right-block"><?=number_format($car->dopprice,0,'',' ');?> руб.</span>
                            </div>

                            <div class="total-company " style="width: 100%;float: left;">
                                <span class="left-block">Итого:</span>
                                <span class="right-block ">
                                    <span class="company-total-price"><?=number_format($car->getCarPrice(),0,'',' ');?></span>
                                    <span class="def-price" style="display: none;"><?=number_format($car->getCarPrice(),0,'',' ');?></span>
                                    <span>руб.</span>
                                </span>
                            </div>

                        </div>

                        

                        <div style="padding: 15px;float: left;width: 100%">
                            <?=\app\core\Html::modalPay();?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
}