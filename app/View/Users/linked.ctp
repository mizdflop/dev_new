<?php

	$this->start('page_title');		echo 'Link Social media Accounts';	$this->end();

	$this->start('leftnav');
		echo $this->element('leftnav');
	$this->end();
?>

<script>
	$(function(){
		$('.linked-accounts a').click(function(){
			window.open(
				$(this).attr('href'), 
				"hybridauth_social_sing_on", 
				"location=0,status=0,scrollbars=0,width=800,height=500"
			);			
			return false;
		});
	});
</script>

<div class="span5">

	<div class="linked-accounts">
		<?php foreach (array('Facebook','Twitter','Google') as $provider): ?>
			<?php if (in_array($provider,(array)Set::extract('{n}.provider',$user['Authentication']))): ?>
				<span class="active"><?php echo $this->Html->image(sprintf('social-icons/%s.png',strtolower($provider)),array('class' => 'actived')); ?><span class="badge badge-success"><i class="icon-ok icon-white"></i></span></span>
			<?php else: ?>
				<?php echo $this->Html->link($this->Html->image(sprintf('social-icons/%s.png',strtolower($provider))),
							'/auth/login/'.strtolower($provider),array('escape' => false,'title' => 'Connect')); ?>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>

</div>