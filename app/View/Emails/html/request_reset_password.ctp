<?php $resetLink = Router::url(array('plugin' => 'account','controller' => 'account', 'action' => 'reset', 'password', $user['UserHash'][0]['token']), true); ?>
<h3 style='padding-top: 20px; margin:20px 0px 10px; font-size:20px;'>
	<span style="font-size: 18px; line-height: 22px; font-weight: bold; color: #18BBBE;">
		<?php echo __('Reset your password');?>
	</span>
</h3>
<p><?php echo $this->Html->link('This link', $resetLink, array('style' => 'color:#0AAAAD;')); ?> will reset your password. If the link cannot be clicked copy the following URL into your browser's address bar.</p>
<i><?php echo $resetLink; ?></i>