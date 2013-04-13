<?php 
	$this->start('leftnav');
		echo $this->element('leftnav', array('active' => ''));
	$this->end();
?>

<div class="span5">

	<div class="page-header">
		<h3>Edit Account</h3>
	</div>
	
	<?php echo $this->Form->create('User', array('type' => 'file','class' => 'form-horizontal')); ?>
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
			if (empty($this->request->data['Authentication'])) {
				echo $this->Html->div('input email control-group',
					$this->Form->label('email','Email',array('class' => "control-label")).
					$this->Html->div('controls',
						$this->Form->hidden('email',array('value' => $this->request->data['User']['email'])).	
						$this->Html->tag('span',$this->request->data['User']['email']).
						$this->Html->link('Change', '/account/reset/email')
					) 
				);
			} else {
				echo $this->Form->input('email',array(
					'div' => 'input text control-group',
					'label' => array('class' => 'control-label','text' => 'Email'),
					'between' => '<div class="controls">',
					'after' => '</div>',
					'class' => 'input-xlarge'
				));				
			}
			echo $this->Form->input('password',array(
				'div' => 'input password control-group',
				'label' => array('class' => 'control-label','text' => 'Password'),
				'between' => '<div class="controls">',
				'after' => '</div>',
				'class' => 'input-xlarge',
				'value' => false,
				'required' => false		
			));
			echo $this->Form->input('confirm_password',array(
				'type' => 'password',
				'div' => 'input password control-group',
				'label' => array('class' => 'control-label','text' => 'Confirm Password'),
				'between' => '<div class="controls">',
				'after' => '</div>',
				'class' => 'input-xlarge',
				'value' => false,
				'required' => false					
			));			
			echo $this->Form->input('avatar',array(
				'type' => 'file',	
				'div' => 'input file control-group',
				'label' => false,
				'between' => '<div class="controls">',
				'after' => $this->Profile->avatar($this->request->data['User'], array('type' => 'small')).'</div>',
				'class' => 'input-xlarge'
			));			
		?>
		<div class="btn-toolbar text-right">
			<?php echo $this->Form->button('Update', array('class' => 'btn btn-primary btn-medium')); ?>
		</div>		
	<?php echo $this->Form->end(); ?>
	
</div>	