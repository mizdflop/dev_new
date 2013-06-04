<script> 
	/*
	if(  window.opener ){
		window.opener.parent.location.href = "<?php echo is_array($redirect_to)?Router::url($redirect_to):$redirect_to; ?>";
	}
	window.self.close();
	*/
	window.location = '<?php echo is_array($redirect_to)?Router::url($redirect_to):$redirect_to; ?>';
</script>