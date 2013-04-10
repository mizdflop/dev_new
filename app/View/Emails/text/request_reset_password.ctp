<?php $resetLink = Router::url(array('plugin' => 'account','controller' => 'account', 'action' => 'reset', 'password', $user['UserHash'][0]['token']), true); ?>
<?php echo __('Reset your password');?>
<?php echo $resetLink; ?> will reset your password. If the link cannot be clicked copy the following URL into your browser's address bar.