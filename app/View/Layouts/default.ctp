<?php

	//$this->Html->meta('icon', '/favicon.png', array('inline' => false));
	
	$this->Html->css(
		array(
			'/bootstrap/css/bootstrap.min',
			'/bootstrap/css/bootstrap-responsive.min',
			'glyphicons',	
			'http://fonts.googleapis.com/css?family=Open+Sans:400,300',	
			'base',	
			'blue',	
			'style',		
		), null, array('inline' => false)
	);

	$this->Html->script(
		array(
			'http://code.jquery.com/jquery.min.js',
			//'https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js',	
			'/bootstrap/js/bootstrap.min',
			'holder',
			'jquery.fitvids',
			//'jqBootstrapValidation',
			'bounce'			
		), 
		array('inline' => false)
	);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>Hold'em Skills Challenge | <?php echo $title_for_layout; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php echo $this->Html->meta('description'); ?>
	
    <?php echo $this->fetch('css'); ?>
    	
	<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="/ico/favicon.png">    
        	
	<?php  echo $this->fetch('script');	?>
	
	<script type="text/javascript">
		$(document).ready(function(){bounce.ui.init();});
	</script>
	
	<script type="text/javascript">
  		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-40159245-1']);
  		_gaq.push(['_trackPageview']);

  		(function() {
    		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  		})();
	</script>	
	
	<script>
		function increment_hand(uid, params) {
			console.log(uid);
			console.log(params);
			//here post call to server
			// $.post('/hands/increment.json',{uid:uid,params:params},function(json){console.log(json)},'json');
			return true;
		}
	</script>
</head>
<body>
	
	<div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-primary btn-dropnav" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>		
          <?php if(empty($auth)): ?>
          <a class="brand" href="/">Hold'em Skills Challenge</a>
          <?php else: ?>
          <a class="brand" href="/users/play">Hold'em Skills Challenge</a>
          <?php endif; ?>
		  <div class="nav-collapse collapse">
            <ul class="nav pull-right animated">
            	<!-- 	
			  <li class="dropdown active">
			    <a class="dropdown-toggle" data-toggle="dropdown" role="button" href="#">Home <b class="caret"></b></a>
				<ul class="dropdown-menu" role="menu">
				  <li><a href="/" tabindex="-1">Default Home</a></li>
				  <li><a href="#" tabindex="-1">Alternative Home</a></li>
				</ul>
			  </li>
              <li><a href="/pages/about">About</a></li>
			  <li class="dropdown">
			    <a class="dropdown-toggle" data-toggle="dropdown" role="button" href="#">Features <b class="caret"></b></a>
				<ul class="dropdown-menu" role="menu">
				  <li><a href="blog.html" tabindex="-1">Blog</a></li>
				  <li><a href="single.html" tabindex="-1">Blog Single</a></li>
				  <li><a href="/pages/dividers" tabindex="-1">Dividers</a></li>
				</ul>
			  </li>
			  <li><a href="/pages/pricing">Pricing</a></li>
			  <li class="dropdown">
			    <a class="dropdown-toggle" data-toggle="dropdown" role="button" href="#">Contact <b class="caret"></b></a>
				<ul class="dropdown-menu" role="menu">
				  <li><a href="/pages/contact" tabindex="-1">Default Contact</a></li>
				  <li><a href="#" tabindex="-1">Alternative Contact</a></li>
				</ul>
			  </li>
			   -->
			  <?php if(empty($auth)): ?>
			  <li><a href="/users/login">Login</a></li>
			  <li><a href="/users/signup">Register</a></li>
			  <?php else: ?>
			  <li><a href="/users/play">Start Play</a></li>
			  <li><a href="/users/logout">Logout</a></li>
			  <?php endif; ?>
            </ul>
		  </div>
        </div>
      </div>
    </div>
    
	<?php if ($this->fetch('landing')): ?>
		<?php echo $this->fetch('landing'); ?>
	<?php endif; ?>   
	
	<?php if ($this->fetch('page_title')): ?>
		<div id="header">
	  		<div class="container">  
	    		<div class="row">
		  			<div class="span12">
		    			<h1><?php echo $this->fetch('page_title'); ?></h1>
		  			</div>
				</div>
	  		</div>
		</div>	
	<?php endif; ?>
	
	<div id="content" class="txt-middle">
	  <div class="container">
	  
	  	<?php echo $this->Session->flash(); ?>
	  	<?php echo $this->Session->flash('auth'); ?>
	  	
		<?php if ($this->fetch('leftnav')): ?>	
			<?php echo $this->fetch('leftnav'); ?>
		<?php endif; ?>
				  	
		<?php echo $this->fetch('content'); ?>
					
	  </div>
	</div>	

	<div id="footer">
	  <div class="container">
	    <div class="row">
	    	<!-- 	
		  <div class="span3">
			<h3>Quick Links</h3>
			<ul class="animated">
			  <li><a href="#">Home</a></li>
			  <li><a href="#">About Us</a></li>
			  <li><a href="#">Features</a></li>
			  <li><a href="#">Pricing</a></li>
			</ul>			
		  </div>
		  <div class="span3">		
			<h3>Company</h3>
			<ul class="animated">
			  <li><a href="#">Privacy Policy</a></li>
			  <li><a href="#">Terms of Use</a></li>
			  <li><a href="#">FAQ</a></li>
			</ul>	
		  </div>
		  <div class="span3">
			<h3>We're Social</h3>
			<ul class="animated">
			  <li><a href="#">Facebook</a></li>
			  <li><a href="#">Twitter</a></li>
			  <li><a href="#">Google +</a></li>
			</ul>		  
		  </div>
		  <div class="span3">
			<h3>Subscribe</h3>
			<p>Subscribe to our newsletter and stay up to date with the latest news and deals!</p>			
		    <form>
              <input type="text" name="subscribe" placeholder="Your Email" class="span3">
			  <button class="btn btn-primary">Subscribe</button>
			</form>
		  </div>
		   -->		  
		</div>	  
      </div>	  
    </div>

	<div id="copywrite">
	  <div class="container">
	    <div class="row">
		  <div class="span12">
		    <p>&copy; Skill In Games, LLC 2013 <span id="totop" class="pull-right">Back to Top <i class="icon-arrow-up icon-white"></i></span></p>			
		  </div>		  
		</div>	  
      </div>	  
    </div>    	
	
</body>
</html>
