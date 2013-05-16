<div class="hands view">
<h2><?php  echo __('Hand'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($hand['Hand']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hand Number'); ?></dt>
		<dd>
			<?php echo h($hand['Hand']['hand_number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Profit'); ?></dt>
		<dd>
			<?php echo h($hand['Hand']['profit']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($hand['Hand']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Hand'), array('action' => 'edit', $hand['Hand']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Hand'), array('action' => 'delete', $hand['Hand']['id']), null, __('Are you sure you want to delete # %s?', $hand['Hand']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Hands'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Hand'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Actions'), array('controller' => 'actions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Action'), array('controller' => 'actions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Streets'), array('controller' => 'streets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Street'), array('controller' => 'streets', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Actions'); ?></h3>
	<?php if (!empty($hand['Action'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Hand Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Street'); ?></th>
		<th><?php echo __('Action Number'); ?></th>
		<th><?php echo __('Hand Number'); ?></th>
		<th><?php echo __('Skill Score'); ?></th>
		<th><?php echo __('Max Equity'); ?></th>
		<th><?php echo __('Did You End Up Folding'); ?></th>
		<th><?php echo __('Action'); ?></th>
		<th><?php echo __('Action Amount'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($hand['Action'] as $action): ?>
		<tr>
			<td><?php echo $action['id']; ?></td>
			<td><?php echo $action['hand_id']; ?></td>
			<td><?php echo $action['user_id']; ?></td>
			<td><?php echo $action['street']; ?></td>
			<td><?php echo $action['action_number']; ?></td>
			<td><?php echo $action['hand_number']; ?></td>
			<td><?php echo $action['skill_score']; ?></td>
			<td><?php echo $action['max_equity']; ?></td>
			<td><?php echo $action['did_you_end_up_folding']; ?></td>
			<td><?php echo $action['action']; ?></td>
			<td><?php echo $action['action_amount']; ?></td>
			<td><?php echo $action['created']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'actions', 'action' => 'view', $action['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'actions', 'action' => 'edit', $action['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'actions', 'action' => 'delete', $action['id']), null, __('Are you sure you want to delete # %s?', $action['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Action'), array('controller' => 'actions', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Streets'); ?></h3>
	<?php if (!empty($hand['Street'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Hand Id'); ?></th>
		<th><?php echo __('Street'); ?></th>
		<th><?php echo __('Hand Number'); ?></th>
		<th><?php echo __('Chance'); ?></th>
		<th><?php echo __('Situation'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($hand['Street'] as $street): ?>
		<tr>
			<td><?php echo $street['id']; ?></td>
			<td><?php echo $street['user_id']; ?></td>
			<td><?php echo $street['hand_id']; ?></td>
			<td><?php echo $street['street']; ?></td>
			<td><?php echo $street['hand_number']; ?></td>
			<td><?php echo $street['chance']; ?></td>
			<td><?php echo $street['situation']; ?></td>
			<td><?php echo $street['created']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'streets', 'action' => 'view', $street['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'streets', 'action' => 'edit', $street['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'streets', 'action' => 'delete', $street['id']), null, __('Are you sure you want to delete # %s?', $street['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Street'), array('controller' => 'streets', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
