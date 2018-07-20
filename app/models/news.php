<?php 
namespace app\models;
Class news extends \app\core\Model
{
    public $table='news';
    
    public function __construct($data=array())
    {
        parent::__construct($data);
        if(empty($this->main_pic))
            $this->main_pic = "/images/logonews.png";
    }

    public function getActualNews($type="1",$limit="")
    {
        if($limit) $limit = "LIMIT {$limit}";
        $sql = "SELECT id,title,text,summary,main_pic,date_in,status FROM {$this->table} 
            WHERE id_type={$type} AND status <> '0' and ( date_out is NULL OR FROM_UNIXTIME(date_out)>CURRENT_DATE() ) 
            ORDER BY id DESC {$limit}";
        $data = $this->getCustomSQL($sql);
        return $data;
    }

    public function getDateIn()
    {
        return date('d.m.Y',$this->date_in);
    }

    public function getMainPic()
    {
        if($this->main_pic)
            return $this->main_pic;
        return "/images/logonews.png";
    }

    public function getBeginDate()
    {
        return date('d.m.Y',$this->date_in);
    }

    public function getTotalNews($type)
    {
        $brand = BRAND;
        $sql = "
            SELECT count(*) as total FROM {$this->table} 
            WHERE status<>'0' and 
            ( date_out is NULL OR FROM_UNIXTIME(date_out)>=CURRENT_DATE() ) AND
            brand = {$brand} AND id_type = {$type}
        ";
        $data = $this->getCustomSQLNonClass($sql)[0]['total'];
        return $data;
    }

    public function getNewsList($page,$amount,$type)
    {
        $page = $amount*$page-$amount;
        $brand = BRAND;
        $sql = "
            SELECT * FROM {$this->table} 
            WHERE status<>'0' and 
            ( date_out is NULL OR FROM_UNIXTIME(date_out)>=CURRENT_DATE() ) AND 
            brand = {$brand} AND id_type = {$type}
            ORDER BY id DESC
            LIMIT ?
            OFFSET ?
        ";
        $mas[] = $amount;
        $mas[] = $page;
        $data = $this->getCustomSQL($sql,$mas);
        return $data;
    }
}