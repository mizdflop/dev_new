<?php 
	$this->start('aside');
		//echo $this->element('aside');
	$this->end();
?>
<script>
	$(function(){
		$('.social-panels a').click(function(){
			window.open(
				$(this).attr('href'), 
				"hybridauth_social_sing_on", 
				"location=0,status=0,scrollbars=0,width=800,height=500"
			);			
			return false;
		});
	});
</script>

<?php echo $this->Session->flash('auth'); ?>

<div class="page-header">
	<h3>Login Page</h3>
</div>

<div class="row-fluid">	

	<div class="span6">
	
	<?php echo $this->Form->create('User', array('class' => 'form-horizontal')); ?>
		<?php 
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
			echo $this->Form->input('remember_me',array(
				'type' => 'checkbox',
				'div' => 'input checkbox control-group',
				'before' => '<div class="controls">',
				'after' => $this->Html->link('forgot password?', '/account/reset/password',array('class' => 'forgot-password')).'</div>',
				'label' => array('text' => 'Keep me logged in on this computer'),	
			));
		?>
		<div class="btn-toolbar text-right">
			<?php echo $this->Form->button('Login', array('class' => 'btn btn-primary btn-medium')); ?>
		</div>		
	<?php echo $this->Form->end(); ?>
	
	<div class="social-panels">
		<span class="label">or...</span>
		<?php 
			echo $this->Html->link($this->Html->image('social-icons/facebook.png'),'/auth/login/facebook',array('escape' => false));
			echo $this->Html->link($this->Html->image('social-icons/twitter.png'),'/auth/login/twitter',array('escape' => false));
			echo $this->Html->link($this->Html->image('social-icons/google.png'),'/auth/login/google',array('escape' => false));
			//echo $this->Html->link($this->Html->image('social-icons/linkedin.png'),'/auth/linkedin',array('escape' => false));
		?>
	</div>
		
	</div>
</div>