<div class="row">	<div class="span12">			<?php if (!empty($hand)): ?>		<div class="row">			<div class="span6">				<dl class="dl-horizontal">  					<dt>HandID:</dt>  					<dd><?php echo $hand['Hand']['id']; ?></dd>  					<dt>Session:</dt>  					<dd><?php echo $hand['Hand']['session']; ?></dd>  					<dt>Counter:</dt>  					<dd><?php echo $hand['Hand']['hand_number']; ?></dd>  									</dl>							</div>			<div class="span6">				<dl class="dl-horizontal">  					<dt>Played By:</dt>  					<dd><?php printf('%s %s',$hand['User']['first_name'],$hand['User']['last_name']); ?></dd>  					<dt>UserID:</dt>  					<dd><?php echo $hand['User']['id']; ?></dd>  					<dt>Timestamp:</dt>  					<dd><?php echo $hand['Hand']['timestamp']; ?></dd>  									</dl>							</div>		</div>				<table class="table">			<tr>				<th>Street</th>				<th>Action</th>				<th>Action ID</th>				<th>Skill Score</th>			</tr>			<?php foreach ($hand['Street'] as $street): ?>				<?php foreach ($street['Action'] as $action): ?>					<tr>						<td><?php echo $street['street']; ?></td>						<td><?php echo $action['action']; ?></td>						<td><?php echo $action['id']; ?></td>						<td><?php echo $action['skill_score']; ?></td>					</tr>				<?php endforeach; ?>			<?php endforeach; ?>		</table>				<h3>Hand History</h3>				<p class="text-left"><?php echo !empty($hand['HandHistory'])?nl2br($hand['HandHistory'][0]['original_hand_history']):''; ?></p>				<?php else: ?>		<div class="well well-form text-left">			<?php echo $this->Form->create('Hand', array('type' => 'get')); ?>			<?php 				echo $this->Form->hidden('action',array('value' => 'search'));								echo $this->Form->input('hand_id', array(					'type' => 'text',					'div' => 'control-group',					'label' => false,					'before' => '<div class="controls">',					'between' => '',					'after' => '</div>',					'class' => 'span3',					'placeholder' => 'Hand ID'				)).'<h3>OR</h3>';				echo $this->Form->input('session_id', array(					'type' => 'text',					'div' => 'control-group',					'label' => false,					'before' => '<div class="controls">',					'between' => '',					'after' => '</div>',					'class' => 'span3',					'placeholder' => 'Session ID'				));				echo $this->Form->input('hand_number', array(					'type' => 'text',					'div' => 'control-group',					'label' => false,					'before' => '<div class="controls">',					'between' => '',					'after' => '</div>',					'class' => 'span3',					'placeholder' => 'Hand Number'				));				echo $this->Form->input('most_recent_hand', array(					'type' => 'checkbox',					'div' => 'control-group',					'label' => 'Most Recent Hand',					'before' => '<div class="controls">',					'between' => '',					'after' => '</div>',				));            ?>			<button class="btn btn-primary" type="submit">Submit</button>			<?php echo $this->Form->end(); ?>		</div>		<?php endif; ?>					</div></div>