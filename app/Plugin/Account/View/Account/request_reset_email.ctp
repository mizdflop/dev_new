<div class="page-header">
	<h3>Reset your email <small>Please enter the password you used for registration and you'll get an email with further instructions.</small></h3>
</div>

<div class="row-fluid">	

	<div class="span6">
	
	<?php echo $this->Form->create('User', array('class' => 'form-horizontal','url' => Router::url())); ?>
		<?php 
			echo $this->Form->input('password',array(
				'div' => 'input password control-group',
				'label' => array('class' => 'control-label','text' => 'Your Password'),
				'between' => '<div class="controls">',
				'after' => '</div>',
				'class' => 'input-xlarge'
			));
			echo $this->Captcha->input('captcha', array(
				'div' => 'input email control-group',
				'before' => '<div class="controls">',
				'after' => '</div>',
			));
		?>
		<div class="btn-toolbar text-right">
			<?php echo $this->Form->button('Send', array('class' => 'btn btn-primary btn-medium')); ?>
		</div>		
	<?php echo $this->Form->end(); ?>
	
	</div>
</div>