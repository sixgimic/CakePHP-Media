<?php
class MediaHelper extends AppHelper{

	public $helpers = array('Html','Form');
	public $javascript = false;
	public $explorer = false;

	public function crop($image, $width, $height, $options = array()){
		$this->pluginDir = dirname(dirname(dirname(__FILE__)));
		$pathinfo = pathinfo($image);
		$dest = $pathinfo['dirname'] . '/' . $pathinfo['filename'] . '_' . $width . 'x' . $height . '.jpg';
		$image_file = WWW_ROOT . trim($image, '/');
		$dest_file = WWW_ROOT . trim($dest, '/');
		require_once($this->pluginDir . DS . 'Vendor' . DS . 'php-image-magician' . DS . 'php_image_magician.php');
		if (!file_exists($dest_file)) {
			$magician = new imageLib($image_file);
			$magician->resizeImage($width, $height, 'crop');
			$magician->saveImage($dest_file);
		}
		return $this->Html->image($dest, $options);

	}

	public function tinymce($field){
		$this->Html->script('/media/js/tinymce/tiny_mce.js',array('inline'=>false));
		return $this->textarea($field, 'tinymce');
	}

	public function ckeditor($field) {
		$model = $this->Form->_models; $model = key($model);
		$this->Html->script('/media/js/ckeditor/ckeditor.js',array('inline'=>false));
		return $this->textarea($field, 'ckeditor');
	}

	public function redactor($field) {
		$model = $this->Form->_models; $model = key($model);
		$this->Html->script('/media/js/redactor/redactor.min.js',array('inline'=>false));
		$this->Html->css('/Media/js/redactor/redactor.css', null, array('inline'=>false));
		return $this->textarea($field, 'redactor');
	}

	public function textarea($field, $editor = false){
		$html = $this->Form->input($field,array('label'=>false,'style'=>'width:100%;height:500px','row' => 160, 'type' => 'textarea', 'class' => "wysiwyg $editor"));
		$models = $this->Form->_models;
		$model = key($models);
        if(isset($this->request->data[$model]['id']) && !$this->explorer){
			$html .= '<input type="hidden" id="explorer" value="' . $this->Html->url('/admin/media/medias/index/'.$model.'/'.$this->request->data[$model]['id']) . '">';
			$this->explorer = true;
    	}
    	return $html;
	}

	public function iframe($ref,$ref_id){
		return '<iframe src="'.Router::url('/').'admin/media/medias/index/'.$ref.'/'.$ref_id.'" style="width:100%;" id="medias-' . $ref . '-' . $ref_id . '"></iframe>';
	}
}