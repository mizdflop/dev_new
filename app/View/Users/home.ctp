<?php 
	$this->start('aside');
		echo $this->element('aside');
	$this->end();
?>

<div class="page-header">
	<h3>Account Summary <small>loren ipsam</small></h3>
</div>

<div class="row-fluid">	

	<div class="span2">
		<h3 class="text-success">$0.00</h3>
		<p class="muted"><small>Paid of Today</small></p>
	</div>
	
	<div class="span2">
		<h3 class="text-success">$1.00</h3>
		<p class="muted"><small>Pending Cashback</small></p>	
	</div>
	
	<div class="span2">
		<h3 class="text-success">$34.23</h3>
		<p class="muted"><small>Approved Cashback</small></p>	
	</div>
	
	<div class="span3">
		<h3 class="text-success">$4.23</h3>
		<p class="muted"><small>Referrals Cash Back</small></p>	
	</div>
	
	<div class="span3">
		<h3 class="text-success">17,028</h3>
		<p class="muted"><small>Cashback Websites</small></p>	
	</div>
	
</div>	

<div class="row-fluid">	
	
	<div class="span6">
		<h4>My Account</h4>
		<dl class="dl-horizontal">
			<dt>Email:</dt>
			<dd><?php echo $user['User']['email']; ?></dd>
			<dt>Password:</dt>
			<dd>******</dd>
			<dt>Member Since:</dt>
			<dd><?php echo $this->Time->niceShort($user['User']['created']); ?></dd>
		</dl>
	</div>
	
	<div class="span6">
		<h4>Payout Settings</h4>
		<dl class="dl-horizontal">
			<dt>Payment Method:</dt>
			<dd><?php echo !empty($user['User']['payment_method'])?$user['User']['payment_method']:'Not Set'; ?></dd>
			<dt>PayPal Email:</dt>
			<dd><?php echo !empty($user['User']['payment_email'])?$user['User']['payment_email']:'Not Set'; ?></dd>
		</dl>
	</div>

</div>