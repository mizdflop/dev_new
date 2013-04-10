<?php $url = Router::url(array('plugin' => 'account','controller' => 'account', 'action' => 'confirm', 'email', $user['UserHash'][0]['token']), true); ?>
<span style="font-size: 18px; line-height: 22px; font-weight: bold; color: #18BBBE;"><?php echo __('Activate Your Account'); ?></span><br/><br/>
<span style="font-weight: bold; color: #646464;">
	<?php printf(__('%s to activate your account or copy and paste the following link in your brower'),$this->Html->link(__('Click here'),$url,array('target' => "_blank",'style' => "color: #0aaaad;text-decoration: none;"))); ?>
</span>
<p><span style="font-style: italic; font-weight: bold; border-bottom: dashed 1px #999;"><?php echo $url; ?></span></p>