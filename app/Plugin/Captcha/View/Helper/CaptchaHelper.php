<?php
class CaptchaHelper extends AppHelper {
	
	public $helpers = array('Html','Form');
	
	public function input($field, $options = array()) {
		
		return $this->Form->input($field,array(
			'type' => 'text',
			'label' => false,
			'div' => 'input text captcha required',
			'before' => $this->Html->tag('p','Write the following word').$this->Html->image('/captcha/image?_='.time(),array('id' => 'captcha')).
							$this->Html->link('Not readable? Change text.','#',array('onclick' => "$(this).prev().attr('src','/captcha/image?_='+Math.random());return false;",'style' => 'display:block;')),
			'error' => array(
				'notempty' => __('error_captcha_required'),
				'captcha' => __('error_captcha')
			),
			'class' => 'input-medium',
			'value' => false		
		));		
	}
}