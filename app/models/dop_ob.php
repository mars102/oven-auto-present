<?php

namespace app\models;
Class dop_ob extends \app\core\Model
{
    public $table = 'dop_ob';
 
    public static function getDop($str="")
    {
        $obj = new \app\models\dop_ob();
        $str = trim($str,',');
        $data = $obj->getCustomSQLNonClass("SELECT GROUP_CONCAT(name SEPARATOR '<br/>') as nam FROM {$obj->table} WHERE id in ({$str})")[0]['nam'];
        return $data;
    }
}