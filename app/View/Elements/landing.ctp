<div id="landing">
	<div class="container">
		<div class="row">
			<div class="span6">
				<h1>We measure your hold'em skills.</h1>
				<ul>
					<li class="landing">We have a billion-hand database.</li>
					<li class="landing">We know what every player did in every situation.</li>
					<li class="landing">And we can compare you to the rest.</li>
				</ul>
				<div class="row">
					<div class="span4 offset1">
						<h2>How do You Stack Up?</h2>
						<h4>
							<strong>Take the Hold'em Skills Challenge</strong>
						</h4>
						<?php if (empty($auth)): ?>
						<p>
							<a href="/users/signup" class="btn btn-primary btn-action"><strong>Get Started Now</strong></a>
						</p>
						<?php else: ?>
						<p>
							<a href="/users/play" class="btn btn-primary btn-action"><strong>Start Play Now</strong></a>
						</p>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="span6">
				<img src="/img/hero_graph_false.jpeg">
			</div>
		</div>
	</div>
</div>	