<script>
	$(function(){
		$('a.facebook').click(function(){
			window.open(
				$(this).attr('href'), 
				"hybridauth_social_sing_on", 
				"location=0,status=0,scrollbars=0,width=800,height=500"
			);			
			return false;
		});
	});
</script>

<div class="page-header">
	<h3>Sign Up</h3>
</div>

<div class="row-fluid">	

	<div class="span6">
	
	<?php echo $this->Form->create('User', array('class' => 'form-horizontal')); ?>
		<?php 
			echo $this->Form->input('first_name',array(
				'div' => 'input text control-group',
				'label' => array('class' => 'control-label','text' => 'First Name'),
				'between' => '<div class="controls">',
				'after' => '</div>',
				'class' => 'input-xlarge'				
			));
			echo $this->Form->input('last_name',array(
				'div' => 'input text control-group',
				'label' => array('class' => 'control-label','text' => 'Last Name'),
				'between' => '<div class="controls">',
				'after' => '</div>',
				'class' => 'input-xlarge'
			));
			echo $this->Form->input('email',array(
				'div' => 'input email control-group',
				'label' => array('class' => 'control-label','text' => 'Email'),
				'between' => '<div class="controls">',
				'after' => '</div>',
				'class' => 'input-xlarge'
			));
			echo $this->Form->input('password',array(
				'div' => 'input password control-group',
				'label' => array('class' => 'control-label','text' => 'Password'),
				'between' => '<div class="controls">',
				'after' => '</div>',
				'class' => 'input-xlarge',
			));
			echo $this->Form->input('confirm_password',array(
				'type' => 'password',	
				'div' => 'input password control-group',
				'label' => array('class' => 'control-label','text' => 'Confirm Password'),
				'between' => '<div class="controls">',
				'after' => '</div>',
				'class' => 'input-xlarge',
			));
				
			echo $this->Form->input('terms',array(
				'type' => 'checkbox',
				'div' => 'input checkbox control-group',
				'before' => '<div class="controls">',
				'after' => '</div>',
				'label' => array('text' => 'Agree'),	
			));
		?>
		<div class="btn-toolbar text-right">
			<?php echo $this->Form->button('Sign Up', array('class' => 'btn btn-primary btn-medium')); ?>
		</div>		
	<?php echo $this->Form->end(); ?>
	
	</div>
</div>