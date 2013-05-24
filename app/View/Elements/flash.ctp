<div class="alert <?php echo !empty($type)?'alert-'.$type:''; ?> text-left">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong><?php echo ucfirst($type); ?>!</strong> <?php echo $message; ?>
</div>