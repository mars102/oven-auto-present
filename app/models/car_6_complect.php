<?php
namespace app\models;
Class car_6_complect extends \app\core\Model
{
    public $table="car_6_complect";

    public static function minPrice($model)
    {
        $complect = new \app\models\car_6_complect();
        $sql = "SELECT min(price) as min FROM {$complect->table} WHERE id_model = ? AND status = 1";
        $data = $complect->getCustomSQLNonClass($sql,array($model))[0];
        return $data['min'];
    }

    public function getComplectById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ? LIMIT 1";
        $mas=array($id);
        $complect = $this->getCustomSQL($sql,$mas)[0];

        $option = new \app\models\car_5_option_list();
        $complect->option = $option->getAllComplectFunction($complect->id);

        $packs = new \app\models\car_7_pack();
        $complect->packs = $packs->getPackListByComplectId($complect->id);

        $motor = new \app\models\car_3_motor();
        $complect->motor = $motor->getMotorById($complect->id_motor);

        return $complect;
    }
}