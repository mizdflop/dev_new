<script>
	$(function(){
		$('a.social').click(function(){
			window.open(
				$(this).attr('href'), 
				"hybridauth_social_sing_on", 
				"location=0,status=0,scrollbars=0,width=800,height=500"
			);			
			return false;
		});
	});
</script>

<div class="row">	

	<div class="span12">
	
		<h4>Create an Account to get started with the Hold'em Skills Challenge</h4>
	
		<div class="form-extra clearfix">
			<a href="/auth/login/facebook" class="social facebook-button" >Connect using your Facebook account</a>
		</div>	
		
		<h3>or</h3> 
		<p>Create an account with your email address</p>
		
	<div class="well well-form text-left" style="max-width:550px;">
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
				'label' => array('text' => 'I agree to the site\'s Terms and Conditions.'),
				'required' => true	
			));
		?>
		<div class="btn-toolbar text-right">
			<?php echo $this->Form->button('Sign Up', array('class' => 'btn btn-primary btn-medium')); ?>
		</div>		
	<?php echo $this->Form->end(); ?>
	</div>
	
	</div>
</div>