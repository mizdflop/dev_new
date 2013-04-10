<?php $url = Router::url(array('plugin' => 'account','controller' => 'account', 'action' => 'confirm', 'email', $user['UserHash'][0]['token']), true); ?>
<?php echo sprintf(__d('users', 'Hello %s,'), $user['User']['first_name']); ?>
<?php echo __d('users', 'to validate your account, you must visit the URL below within 24 hours'); ?>
<?php echo $url; ?>