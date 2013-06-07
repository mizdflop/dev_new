<?php 
	/*
	$this->start('leftnav');
		echo $this->element('leftnav');
	$this->end();*/
?>

<?php /* <div class="pull-left" style="margin-left:20px;">*/?>
	<div class="row-fluid">
		<div class="span9">
			<?php 
				$query = array(
					'token' => 123456,
					'api_uri' => rtrim(Router::url('/',true),'/'),
					'uid_uri' => Router::url('/users/authenticated.json'),
					'hand_uri' => Router::url('/hands/add.json')
				);
			?>
<script language="javascript">AC_FL_RunContent = 0;</script>
<script src="/js/AC_RunActiveContent.js" language="javascript"></script>
<script language="javascript">
	if (AC_FL_RunContent == 0) {
		alert("This page requires AC_RunActiveContent.js.");
	} else {
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0',
			'width', '800',
			'height', '600',
			'src', '/flash/poker',
			'quality', 'high',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'align', 'middle',
			'play', 'true',
			'loop', 'true',
			'scale', 'showall',
			'wmode', 'window',
			'devicefont', 'false',
			'id', 'poker',
			'bgcolor', '#17300a',
			'name', 'poker',
			'menu', 'true',
			'FlashVars', 'FirstName=SkillIn&LastName=Games&UserID=12345&OutputURL=http://ec2-54-224-142-63.compute-1.amazonaws.com:8080/tableAndBotsRestWS',
			'allowFullScreen', 'false',
			'allowScriptAccess','sameDomain',
			'movie', '/flash/poker',
			'salign', ''
			); //end AC code
	}
</script>
<noscript>
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="800" height="600" id="poker" align="middle">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="allowFullScreen" value="false" />
	<param name="movie" value="/flash/poker.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#17300a" />	<embed src="/flash/poker.swf" quality="high" bgcolor="#17300a" width="800" height="600" name="poker" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object>
</noscript>

		</div>	
		<div class="span3">
			<h4>Skills Report</h4>
			<p>Hand played: 252</p>
			<p>Report updates every 25 hands</p>
			<div class="well">
				<p>Total Skills Score</p>
				<h3>75</h3>
				<p><strong>Overall</strong>: Playing Well</p>
			</div>
<!--
			<div class="well">
				<h4>Skills By Street</h4>
				<div class="row-fluid">
					<div class="span3">Preflop <h3>-4</h3></div>
					<div class="span3">Flop <h3>-4</h3></div>
					<div class="span3">Turn <h3>4</h3></div>
					<div class="span3">River <h3>4</h3></div>
				</div>
			</div>
			<h3>Skill Categories</h3>
			<div class="row-fluid">
		    <ul class="thumbnails">
    			<li class="span5">
    				<div class="thumbnail">
    					<p>Bluffing</p>
    					<h3>25</h3>
    				</div>
    			</li>
    			<li class="span5">
    				<div class="thumbnail">
    					<p>Bluffing</p>
    					<h3>25</h3>
    				</div>
    			</li>
    			<li class="span5">
    				<div class="thumbnail">
    					<p>Bluffing</p>
    					<h3>25</h3>
    				</div>
    			</li>
    			<li class="span5">
    				<div class="thumbnail">
    					<p>Bluffing</p>
    					<h3>25</h3>
    				</div>
    			</li>
		    </ul>
		    </div>
-->		    
		</div>
	</div>
<?php /* </div>*/?>

<div id="playModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Play Page</h3>
</div>
<div class="modal-body">
<p>Play against our bots and we'll we'll give you an updated skill assessment every 25 hands.</p>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
</div>
</div>

<script>
	$(function(){
		$('#playModal').modal();
	});
</script>
