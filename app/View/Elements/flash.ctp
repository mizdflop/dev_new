<div class="alert <?php echo !empty($type)?'alert-'.$type:''; ?>">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Warning!</strong> <?php echo $message; ?>
</div>