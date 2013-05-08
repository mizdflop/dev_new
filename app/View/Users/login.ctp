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
	
		<div class="form-extra clearfix">
			Login with facebook <a href="/auth/login/facebook" class="social facebook-button" >Connect using your Facebook account</a>
		</div>
						
		<div class="well well-form txt-lefty">
			<h4>Login to Existing Account</h4>
			<?php echo $this->Form->create('User'); ?>

			<?php 
				echo $this->Form->input('email', array(
					'type' => 'email',
					'div' => 'control-group',					'label' => false,
					'before' => '<div class="controls"><div class="input-prepend">',					'between' => '<span class="add-on"><i class="icon-user"></i></span>',					'after' => '</div></div>',					'class' => 'span3',
					'placeholder' => 'Email address'
				));
				echo $this->Form->input('password', array(					'type' => 'password',					'div' => 'control-group',					'label' => false,					'before' => '<div class="controls"><div class="input-prepend">',					'between' => '<span class="add-on"><i class="icon-lock"></i></span>',					'after' => '</div></div>',					'class' => 'span3',					'placeholder' => 'Password'				));
            ?>
			<div class="form-actions">
				<label class="checkbox"> <?php echo $this->Form->input('remember', array('type' => 'checkbox','label' => false,'div' => false)); ?>
					Remember Me
				</label>
				<button class="btn btn-primary" type="submit">Sign In</button>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>

