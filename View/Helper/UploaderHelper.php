<?php
class UploaderHelper extends AppHelper{

	var $helpers = array('Html','Form');
	var $javascript = false;

	public function tinymce($field){
		$model = $this->Form->_models; $model = key($model);
		$this->javascript('tinymce');
        $html = $this->Form->input($field,array('label'=>false,'class'=>'wysiwyg','style'=>'width:100%;height:500px','row' => 160, 'type' => 'textarea'));
    	if(isset($this->request->data[$model]['id'])){
			$html .= '<input type="hidden" id="explorer" value="'.$this->Html->url('/admin/media/medias/index/'.$model.'/'.$this->request->data[$model]['id']).'/textEditor:tinymce">';
    	}
		return $html;
	}

	public function ckeditor($field) {
		$model = $this->Form->_models; $model = key($model);
		$this->javascript('ckeditor');
        $html = $this->Form->input($field,array('label'=>false,'class'=>'','style'=>'width:100%;height:500px','row' => 160, 'type' => 'textarea', 'id' => 'editor1'));
        if(isset($this->request->data[$model]['id'])){
			$html .= '<input type="hidden" id="explorer" value="'.$this->Html->url('/admin/media/medias/index/'.$model.'/'.$this->request->data[$model]['id']).'/textEditor:ckeditor">';
    	}
		return $html;
	}

	private function javascript($library){
		switch($library) {
			case 'tinymce' :
				$this->Html->script('/media/js/tinymce/tiny_mce.js',array('inline'=>false));
				break;
			case 'ckeditor' :
				$this->Html->script('/media/js/ckeditor/ckeditor.js',array('inline'=>false));

				break;
		}
	}

	public function iframe($ref,$ref_id){
		return '<iframe src="'.Router::url('/').'admin/media/medias/index/'.$ref.'/'.$ref_id.'" style="width:100%;" id="medias'.$ref.'"></iframe>';
	}
}