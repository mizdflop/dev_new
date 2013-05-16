<?php $activateUrl = Router::url(array('plugin' => 'account','controller' => 'account', 'action' => 'confirm', 'email', $user['UserHash'][0]['token']), true); ?>
<?php echo printf('Thank you for registering at HoldemSkillsChallenge.com.to activate your account copy and paste the following link in your browser.'); ?>
<?php echo $activateUrl; ?>