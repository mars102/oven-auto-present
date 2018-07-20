<?php
namespace app\core;
Class Image
{
	public function canUpload($data, $path){
		$data = (object)$data;
		if($data->name == '') return false;
		if($data->size == 0) return false;

		$getMime = explode('.', $data->name);
		$mime = strtolower(end($getMime));
		$types = array('jpg', 'png', 'gif', 'bmp', 'jpeg', 'pdf','txt');

		if(!in_array($mime, $types)) return false;
		
		return $this->make_upload($data, $path);
	}

	public function make_upload($data, $path){	
		// формируем уникальное имя картинки: случайное число и name
		
		$filename=ROOT.$path;
		//echo $filename;
		if (!file_exists($filename)) {
			umask(0);
			mkdir($filename, 0777, true);
			umask(0);
		}

		$data->name = date('d-m')."_".rand(1,1000)."_".$data->name;
		$name = $data->name;
		$current_path=$filename.'/'.$name;
		
		if(copy($data->tmp_name, $current_path)) return $path.'/'.$name;
		
		return false;
	}

	public static function getImgList($path)
	{
		if(!empty($path)) :
			$data = NULL;
			
			if(!is_dir($path)) return array('Не существует каталога');
			$files = scandir($path);
			if(!is_array($files)) return array('Каталог пуст');
			$skip = array('.', '..');
			foreach ($files as $key => $value) :
				if(!in_array($value, $skip))
				{
					$data[] = $path.'/'.$value;
				}
			endforeach;
			/*если фаилы обнаруженны*/
			if(!empty($data)) return $data;
			/*иначе ложь*/
			return array('Не обнаруженнл');
		endif;
		return array('Отрицательно');
	}

	public static function deleteImage($img)
	{
		if(is_file(ROOT.$img))
			unlink(ROOT.$img);
	}

	public static function deleteCatalog($path)
	{
		if(file_exists(ROOT.'/'.$path)) ://проверяем есть ли каталог
			if(!empty($path)) : //на всякий случай на пустоту относительного адреса
				$files = new \RecursiveDirectoryIterator(ROOT.'/'.$path); //получаем фаилы
				foreach($files as $file){
					unlink($file->getRealPath());
				}
				rmdir(ROOT.'/'.$path);
			endif;
		endif;
	}


}