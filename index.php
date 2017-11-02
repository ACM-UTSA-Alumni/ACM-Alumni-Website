<!DOCTYPE html>
<html>
	<head>
		<?php
			require('common/head-includes.php');
		?>
        <title>The Association for Computing Machinery &mdash; UTSA</title>
	</head>
	<body>
		<?php
			require('common/menu.php');
		?>
		<div id="content" class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="row section-container" id="home-page-rowdyhacks-image">
						<div class="col-sm-12">
						</div>
					</div>
					<div class="row section-container" style="display:table;" id="slack-container">
						<div class="col-sm-8">
							<h1>
								Slack
							</h1>
							<p>
								Want to keep in touch with former class mates? Want to talk about the latest and greatest stuff in technology? From app development to unix security, ACM has people who share your interests. The best way to get connected with other students and hear about upcoming events, is through <a href="http://acm-utsa.slack.com">Slack</a>. We use Slack to share information about events and opportunities that ACM Alumni are involved with. Members can recieve an invitation to join by sending an email to <a href="mailto:acm.utsa.alumni@gmail.com">acm.utsa.alumni@gmail.com</a> or by contacting one of our <a href="officers.php">officers</a>.
							</p>
						</div>
						<div class="col-sm-4 hidden-xs">
							<div style="margin:120px 0px 0px 0px;text-align: center;">
								<a class="link" href="slack_invite.php" target="_blank">
									<input type="button" style="outline-style: none;" value="Request Slack Invite" />
								</a>
							</div>
						</div>
						<div class="col-sm-4 hidden-sm hidden-md hidden-lg hidden-xl">
							<div style="margin:40px 0px 0px 0px;text-align: center;">
								<a href="slack_invite.php">
									<input type="button" style="outline-style: none;" value="Request Slack Invite" />
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
			require('common/footer.php');
		?>
	</body>
</html>
