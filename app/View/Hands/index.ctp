<div class="hands index">
	<h2><?php echo __('Hands'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('hand_number'); ?></th>
			<th><?php echo $this->Paginator->sort('profit'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($hands as $hand): ?>
	<tr>
		<td><?php echo h($hand['Hand']['id']); ?>&nbsp;</td>
		<td><?php echo h($hand['Hand']['hand_number']); ?>&nbsp;</td>
		<td><?php echo h($hand['Hand']['profit']); ?>&nbsp;</td>
		<td><?php echo h($hand['Hand']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $hand['Hand']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $hand['Hand']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $hand['Hand']['id']), null, __('Are you sure you want to delete # %s?', $hand['Hand']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Hand'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Actions'), array('controller' => 'actions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Action'), array('controller' => 'actions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Streets'), array('controller' => 'streets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Street'), array('controller' => 'streets', 'action' => 'add')); ?> </li>
	</ul>
</div>
