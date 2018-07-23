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

    public static function getDopFromMas($ids=array())
    {
    	$res= 0;
    	$dop = new \app\models\dop_ob();
    	$str = implode(",", $ids);
    	//\app\core\Html::prA($ids);
    	if(!empty($str))
    	{
    		foreach ($ids as $key => $value) {
    			$sql = " SELECT name FROM {$dop->table} WHERE id = {$value} ";
    			
    			$data[] = $dop->getCustomSQLNonClass($sql)[0];
    		}
    		
    		
    		if(is_array($data))
    		{
    			foreach ($data as $key => $value) {
    				$mas[] = $value['name'];
    			}
    			$last = array_pop($mas);
    			$res = implode(", ", $mas);
    			$res.= " и ".$last;
    		}
    		return $res;
    	}
    }
}