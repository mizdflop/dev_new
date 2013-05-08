<?php 
	$this->start('page_title');		echo 'Account Summary';	$this->end();
	
	$this->start('leftnav');
		echo $this->element('leftnav');
	$this->end();
?>

<div class="span5 pull-left">
	<?php echo $this->Profile->avatar($user['User'], array('type' => 'large')); ?>
	<dl class="dl-horizontal">
		<dt>Name</dt>
    	<dd><?php printf('%s %s',$user['User']['first_name'],$user['User']['last_name']); ?></dd>
		<dt>Email</dt>
    	<dd><?php echo $user['User']['email']; ?></dd>    	
	</dl>
</div>