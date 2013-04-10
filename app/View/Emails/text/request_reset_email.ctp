<?php $resetLink = Router::url(array('plugin' => 'account','controller' => 'account', 'action' => 'reset', 'email', $user['UserHash'][0]['token']), true); ?>
<?php echo __('Reset your email');?>
<?php echo $resetLink; ?> will reset your email. If the link cannot be clicked copy the following URL into your browser's address bar.