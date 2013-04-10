<h2 class="main-header"><?php echo __d('users', 'Reset your email'); ?></h2>

<div class='login password content'>
	<?php echo $this->Form->create('User', array('url' => Router::url())); ?>
		<p class="helptext"><?php echo __d('users', 'Please enter new the email.'); ?></p>
		<?php
			echo $this->Form->input('email', array(
				'label' => __d('users', 'Email'),
				'error' => array(
					'notempty' => __('error_email_required'),
					'email' => __('error_supply_valid_email_address'),
					'isUnique' => __('error_unique_email_address')
				)
			));
			echo $this->Form->submit(__d('users', 'Submit'));
		?>
	<?php echo $this->Form->end(); ?>
</div>

<div class='login-sidebar'>

	<h3>Need an account?</h3>

	<a href="/" class='button shader'>Sign Up</a>

</div>