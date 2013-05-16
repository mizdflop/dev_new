<div class="hands form">
<?php echo $this->Form->create('Hand'); ?>
	<fieldset>
		<legend><?php echo __('Edit Hand'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('hand_number');
		echo $this->Form->input('profit');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Hand.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Hand.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Hands'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Actions'), array('controller' => 'actions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Action'), array('controller' => 'actions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Streets'), array('controller' => 'streets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Street'), array('controller' => 'streets', 'action' => 'add')); ?> </li>
	</ul>
</div>
