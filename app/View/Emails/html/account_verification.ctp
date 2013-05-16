<?php $activateUrl = Router::url(array('plugin' => null,'controller' => 'account', 'action' => 'confirm', 'email', $user['UserHash'][0]['token']), true); ?>
<span style="font-weight: bold; color: #646464;">
	<?php printf(__('Thank you for registering at HoldemSkillsChallenge.com. %s to activate your account or copy and paste the following link in your browser.'),$this->Html->link(__('Click here'),$activateUrl,array('target' => "_blank",'style' => "color: #0aaaad;text-decoration: none;"))); ?>
</span>
<p><span style="font-style: italic; font-weight: bold; border-bottom: dashed 1px #999;"><?php echo $activateUrl; ?></span></p>