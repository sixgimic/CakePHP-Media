<?php
class Media extends AppModel{
	
	public $useTable = 'medias';
	public $order    = 'position ASC';
	
	private $IMAGES_EXT = array("jpg","gif","png");
	private $MOVIES_EXT = array("avi","mov","mkv","mp4","wmv");
	private $MUSIC_EXT = array("mp3","wma");
	private $ZIP_EXT = array("rar","tar.gz","tgz","zip");

	function beforeDelete($cascade = true){
		$file = $this->field('file');
		$info = pathinfo($file);
		foreach(glob(IMAGES.$info['dirname'].'/'.$info['filename'].'_*x*.jpg') as $v){
			unlink($v);
		}
		unlink(IMAGES.$file); 
		return true;
	}

	function afterFind($data){
		foreach($data as $k=>$v){
			$i = key($v); 
			$v = current($v);
			if(isset($v['file'])){
				$data[$k][$i]['filef'] = substr($v['file'],0,-4).'_%dx%d.jpg';
				$extension = strtolower(end(explode('.', $v['file'])));
				if(in_array($extension, $this->IMAGES_EXT)){
					$data[$k][$i]['type'] = 'image';
					$data[$k][$i]['icon'] = 'picture.png';
				} elseif(in_array($extension, $this->MOVIES_EXT)) {
					$data[$k][$i]['type'] = 'movie';
					$data[$k][$i]['icon'] = 'film.png';
				}  elseif(in_array($extension, $this->MUSIC_EXT)) {
					$data[$k][$i]['type'] = 'music';
					$data[$k][$i]['icon'] = 'music.png';
				}  elseif(in_array($extension, $this->ZIP_EXT)) {
					$data[$k][$i]['type'] = 'zip';
					$data[$k][$i]['icon'] = 'file_extension_zip.png';
				}
			}
		}
		return $data; 
	}

	function beforeSave($options = array()){
		if( isset($this->data['Media']['file']) && is_array($this->data['Media']['file']) && isset($this->data['Media']['ref']) ){
			$model 		= ClassRegistry::init($this->data['Media']['ref']);
			$dir 		= $model->medias['path'];
			$ref_id 	= $this->data['Media']['ref_id']; 
			$pathinfo 	= pathinfo($this->data['Media']['file']['name']);
			$filename 	= Inflector::slug($pathinfo['filename'],'-');
			$search 	= array('%id','%mid','%cid','%y','%m','%f');
			$replace 	= array($ref_id,ceil($ref_id/1000),ceil($ref_id/100),date('Y'),date('m'),Inflector::slug($filename));
			$dir  		= str_replace($search,$replace,$dir).'.'.$pathinfo['extension'];
			$this->testDuplicate($dir); 
			if(!file_exists(dirname(IMAGES.$dir))){
				mkdir(dirname(IMAGES.$dir),0777,true);
			}
			move_uploaded_file($this->data['Media']['file']['tmp_name'], IMAGES.$dir);
			chmod(IMAGES.$dir,0777);
			$this->data['Media']['file'] = $dir;
		}
		return true; 
	}

	/**
	* If the file $dir already exists we add a {n} before the extension
	**/
	function testDuplicate(&$dir,$count = 0){
		$file = $dir; 
		if($count > 0){
			$pathinfo = pathinfo($dir);
			$file = $pathinfo['dirname'].'/'.$pathinfo['filename'].'-'.$count.'.'.$pathinfo['extension'];
		}
		if(!file_exists(IMAGES.$file)){
			$dir = $file; 
		}else{
			$count++;
			$this->testDuplicate($dir,$count);
		}
	}

}