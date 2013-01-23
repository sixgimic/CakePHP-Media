<?php
class MediaHelper extends AppHelper{

	public $helpers = array('Html','Form');
	public $javascript = false;
	public $explorer = false;

	public function resize($image, $width, $height, $options = array()){
		return $this->Html->image($this->resizedUrl($image, $width, $height), $options);
	}

	public function resizedUrl($image, $width, $height){
		$this->pluginDir = dirname(dirname(dirname(__FILE__)));
		$pathinfo = pathinfo($image);
		$dest = $pathinfo['dirname'] . '/' . $pathinfo['filename'] . '_' . $width . 'x' . $height . '.jpg';
		$image_file = WWW_ROOT . trim($image, '/');
		$dest_file = WWW_ROOT . trim($dest, '/');

		if (!file_exists($dest_file)) {
			require_once APP . 'Plugin' . DS . 'Media' . DS . 'Vendor' . DS . 'imagine.phar';
			$imagine = new Imagine\Gd\Imagine();
			$imagine->open($image_file)->thumbnail(new Imagine\Image\Box($width, $height), Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND)->save($dest_file, array('quality' => 90));
		}
		return '/' . $dest;
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
		return '<iframe src="'.Router::url('/').'admin/media/medias/index/'.$ref.'/'.$ref_id.'" style="width:100%;" id="'.$ref.'"></iframe>';
	}
}