<?php
class ProfileHelper extends AppHelper {
	
	public $helpers = array('Html','Form');
	
	public function avatar($user, $htmlAttributes = array()) {

		$options = array_merge(array('class' => 'thumb'),$htmlAttributes);
		
		$link = '';
		if (!empty($options['remove'])) {
			$link = $this->Html->link('Remove...','#',array('class' => 'remove user-avatar-remove'));
			unset($options['remove']);
		}		
		
		if (!empty($options['type'])) {
			$type = $options['type'];
			unset($options['type']);
		} else {
			$type = 'large';
		}
		
		if (!empty($user['avatar'])) {
			
			if (strpos($user['avatar'], '://') !== false) {
				
				$url = parse_url($user['avatar']);
				if (!empty($options['type'])) {
					$url['query'] = "type={$options['type']}";
				}
				
				return $this->Html->image($url['scheme'].'://'.$url['host'].$url['path'].'?'.$url['query'],$options).$link;
			} else {
				return $this->Html->image('/files/user/avatar/thumb/'.$type.'/'.$user['avatar'],$options).$link;	
			}			
		} elseif (!empty($user['avatar_fb'])) {
			
			$url = parse_url($user['avatar_fb']);
			if (!empty($options['type'])) {
				$url['query'] = "type={$options['type']}";
			}			
			return $this->Html->image($url['scheme'].'://'.$url['host'].$url['path'].'?'.$url['query'],$options);				
		} else {
			return '<img data-src="/js/holder.js/64x64" alt="">';	
		}		
	}	
	
	public function name($user) {
		return $user['name'];
	}
}