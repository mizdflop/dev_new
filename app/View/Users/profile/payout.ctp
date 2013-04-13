<?php 
	$this->start('aside');
		echo $this->element('aside');
	$this->end();
?>

<div class="page-header">
	<h3>Payout Settings</h3>
</div>

	<?php echo $this->Form->create('User', array('class' => 'form-horizontal')); ?>
		<?php
			echo $this->Form->input('id');
			echo $this->Form->input('payment_method',array(	
				'options' => array('PayPal' => 'PayPal','Check' => 'Check'),
				'div' => 'input select control-group',
				'label' => array('class' => 'control-label','text' => 'Payment Method'),
				'between' => '<div class="controls">',
				'after' => '</div>',
				'class' => 'input-xlarge'
			));
			echo $this->Form->input('paypal_email',array(
				'div' => 'input text control-group',
				'label' => array('class' => 'control-label','text' => 'Paypal Email'),
				'between' => '<div class="controls">',
				'after' => '</div>',
				'class' => 'input-xlarge'
			));
			echo $this->Form->input('address',array(
				'div' => 'input text control-group',
				'label' => array('class' => 'control-label','text' => 'Address'),
				'between' => '<div class="controls">',
				'after' => '</div>',
				'class' => 'input-xlarge'
			));
			echo $this->Form->input('address2',array(
				'div' => 'input text control-group',
				'label' => array('class' => 'control-label','text' => 'Address 2'),
				'between' => '<div class="controls">',
				'after' => '</div>',
				'class' => 'input-xlarge'
			));
			echo $this->Form->input('city',array(
				'div' => 'input text control-group',
				'label' => array('class' => 'control-label','text' => 'City'),
				'between' => '<div class="controls">',
				'after' => '</div>',
				'class' => 'input-xlarge'
			));
			echo $this->Form->input('state',array(
				'div' => 'input text control-group',
				'label' => array('class' => 'control-label','text' => 'State'),
				'between' => '<div class="controls">',
				'after' => '</div>',
				'class' => 'input-xlarge'
			));
			echo $this->Form->input('zip',array(
				'div' => 'input text control-group',
				'label' => array('class' => 'control-label','text' => 'Zip Code'),
				'between' => '<div class="controls">',
				'after' => '</div>',
				'class' => 'input-xlarge'
			));
		?>
		<div class="btn-toolbar text-right">
			<?php echo $this->Form->button('Update', array('class' => 'btn btn-primary btn-medium')); ?>
		</div>		
	<?php echo $this->Form->end(); ?>