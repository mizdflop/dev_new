<div class="page-header">
	<h1>Reset your email</h1>
</div>

<div class="row-fluid">	

	<div class="span6">
	
	<?php echo $this->Form->create('User', array('class' => 'form-horizontal','url' => Router::url())); ?>
	
		<p class="helptext">Please enter new the email.</p>
		
		<?php 
			echo $this->Form->input('email',array(
				'div' => 'input email control-group',
				'label' => array('class' => 'control-label','text' => 'Email'),
				'between' => '<div class="controls">',
				'after' => '</div>',
				'class' => 'input-xlarge'
			));
			echo $this->Form->input('confirm_password',array(
				'type' => 'password',
				'div' => 'input email control-group',
				'label' => array('class' => 'control-label','text' => 'Confirm Password'),
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
			<?php echo $this->Form->button('Save', array('class' => 'btn btn-primary btn-medium')); ?>
		</div>		
	<?php echo $this->Form->end(); ?>
	
	</div>
</div>