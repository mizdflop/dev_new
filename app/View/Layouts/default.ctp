<?php

	$this->Html->meta('icon', '/favicon.png', array('inline' => false));
	
	$this->Html->css(
		array(
			'bootstrap.min',
			'bootstrap-responsive.min',
			'style',		
		), null, array('inline' => false)
	);

	$this->Html->script(
		array(
			'http://code.jquery.com/jquery.min.js',	
			'bootstrap.min',
			'hsc',		
		), 
		array('inline' => false)
	);
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>Bounce | <?php echo $title_for_layout; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
		echo $this->Html->meta('icon');

		//echo $this->Html->css('cake.generic');

		echo $this->fetch('meta');
		echo $this->fetch('css');		
	?>
	<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
	
    <div class="navbar navbar-fixed-top">
      	<div class="navbar-inner">
        	<div class="container">
          		<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            		<span class="icon-bar"></span>
            		<span class="icon-bar"></span>
            		<span class="icon-bar"></span>
          		</button>
          		<a class="brand" href="/">Bounce</a>
          		<div class="nav-collapse collapse">
          			<?php if (!empty($auth)): ?>
						<p class="navbar-text pull-right">
              				Logged in as <?php echo $auth['first_name']; ?> <a class="navbar-link" href="/users/logout">Logout</a>
            			</p>
            		<?php else: ?>
            			<ul class="nav pull-right">
              				<li><a href="/users/login">Login</a></li>
              				<li><a href="/users/signup">Sign Up</a></li>
            			</ul>            		
            		<?php endif; ?>	          		
            		<ul class="nav">
              			<li><a href="/">Home</a></li>
              			<li><a href="/pages/price">Price</a></li>
              			<li><a href="/blog">Blog</a></li>
            		</ul>
          		</div>
        	</div>
      	</div>
    </div>
	
	<div id="content" class="txt-middle">
	  <div class="container">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>		
	  </div>
	</div>	
	
	<div id="copywrite">
	  <div class="container">
	    <div class="row">
		  <div class="span12">
		    <p>&copy; 2013 Bounce Template <span id="totop" class="pull-right">Back to Top <i class="icon-arrow-up"></i></span></p>			
		  </div>		  
		</div>	  
      </div>	  
    </div>	
	
	<?php echo $this->fetch('script');?>
	
</body>
</html>
