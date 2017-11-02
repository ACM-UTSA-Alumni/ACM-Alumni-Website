<!DOCTYPE html>
<html>
	<head>
		<?php
			require('common/head-includes.php');
		?>
		<title>Contact Us | Association for Computing Machinery UTSA</title>
		<style type="text/css">
			select, input[type="text"], input[type="password"], textarea {
				background-color: #DFDFDF;
				border-radius: 3px;
				border-style: none;
				outline-color: #204972;
				outline-width: 1px;
				outline-style: none;
				padding-left: 10px;
				padding-right: 10px;
			}
			select:focus, input[type="text"]:focus, input[type="password"]:focus, textarea:focus {
				outline-style: none;
				box-shadow: 0px 0px 0px 3px #204972;
			}
			/*
			select::selection, input[type="text"]::selection, input[type="password"]::selection, textarea::selection {
				background:#204972;
				color: #FFFFFF;
			}
			*/
		</style>
		<script type="text/javascript">
			$(document).ready(function(){
				<?php
					if(isset($_GET['message_stat'])){
						echo('$("#stat-modal").modal("show");');
					}
				?>
			});
		</script>
	</head>
	<body>
		<?php
			require('common/menu.php');
			$message_stat = '';
			$message_stat_title = '';
			if(isset($_GET['message_stat'])){
				if($_GET['message_stat'] == 1){
					$message_stat_title = 'Thanks';
					$message_stat = 'Your message has successfully been sent';
				}
				else if($_GET['message_stat'] == 2){
					$message_stat_title = 'Error';
					$message_stat = 'Error: message failed to send';
				}
				else{
					$message_stat_title = 'Error';
					$message_stat = 'Message Status: unknown';
				}
			}
		?>
		<div class="modal fade" id="stat-modal" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<div type="button" class="close" data-dismiss="modal">&times;</div>
						<h4 class="modal-title">
							<?php
								echo(htmlentities($message_stat_title));
							?>
						</h4>
					</div>
					<div class="modal-body">
						<p>
							<?php
								echo(htmlentities($message_stat));
							?>
						</p>
					</div>
					<!--
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<div>
					-->
				</div>
			</div>
		</div>
		<div id="content" class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="row section-container group">
						<div class="col-sm-12">
							<h1>Contact Us</h1>
							<br />
							<div class="row">
								<div class="col-sm-8">
									<p>
										ACM's primary form of communication is through <a href="index#slack-container">Slack</a> at <a href="http://acm-utsa.slack.com">acm-utsa.slack.com</a> but you can contact us directly through the form below.
									</p>
								</div>
								<div class="col-sm-4" style="text-align:center;">
									<a class="link" href="slack_invite.php" target="_blank">
										<input type="button" style="outline-style: none;" value="Request Slack Invite" />
									</a>
								</div>
							</div>
							<br />
							<form action="send_message" method="post">
								<?php
									$position = '';
									if(isset($_GET['position'])){
										$position = $_GET['position'];
									}
								?>
								<div class="row">
									<div class="hidden-xs col-sm-12" style="text-align:left;margin-bottom:10px;">
										<input type="text" name="name" placeholder="Your Name" aria-required="true" style="margin-right: 10px; width: 260px;" />
										<input type="text" name="email" placeholder="Your Email" aria-required="true" style="width: 260px;" />
									</div>
									<div class="col-xs-12 hidden-sm hidden-md hidden-lg hidden-xl" style="text-align:center;margin-top:10px;">
										<input type="text" name="m-name" placeholder="Your Name" aria-required="true" style="width:100%;" />
									</div>
									<div class="col-xs-12 hidden-sm hidden-md hidden-lg hidden-xl" style="text-align:center;margin-top:10px;margin-bottom:10px;">
										<input type="text" name="m-email" placeholder="Your Email" aria-required="true" style="width:100%;" />
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<textarea name="text" placeholder="Your Message" style="width:100%;height:400px;"></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12 hidden-xs" style="text-align:right;">
										<input type="submit" value="Send" id="contact-form-submit-button" /> to
										<select name="recipient" style="margin-left:10px;">
											<option value="acm">
												ACM UTSA
											</option>
											<option value="president"<?php if($position == 'president') echo(' selected');?>>
												President
											</option>
											<option value="vice-president"<?php if($position == 'vice-president') echo(' selected');?>>
												Vice President
											</option>
											<option value="secretary"<?php if($position == 'secretary') echo(' selected');?>>
												Secretary
											</option>
											<option value="treasurer"<?php if($position == 'treasurer') echo(' selected');?>>
												Treasurer
											</option>
											<option value="acmw-chair"<?php if($position == 'acmw-chair') echo(' selected');?>>
												ACMW Chair
											</option>
											<option value="pr"<?php if($position == 'pr') echo(' selected');?>>
												Public Relations
											</option>
											<option value="social"<?php if($position == 'social') echo(' selected');?>>
												Social Events
											</option>
											<option value="media"<?php if($position == 'media') echo(' selected');?>>
												Media
											</option>
											<option value="projects"<?php if($position == 'projects') echo(' selected');?>>
												Projects
											</option>
										</select>
									</div>
									<div class="col-xs-12 hidden-sm hidden-md hidden-lg hidden-xl" style="text-align:center;">
										<input type="submit" value="Send" id="contact-form-submit-button" />
										<br />
										to
									</div>
									<div class="col-xs-12 hidden-sm hidden-md hidden-lg hidden-xl" style="text-align:center;margin-top:10px;">
										<select name="recipient">
											<option value="acm">
												ACM UTSA
											</option>
											<option value="president"<?php if($position == 'president') echo(' selected');?>>
												President
											</option>
											<option value="vice-president"<?php if($position == 'vice-president') echo(' selected');?>>
												Vice President
											</option>
											<option value="secretary"<?php if($position == 'secretary') echo(' selected');?>>
												Secretary
											</option>
											<option value="treasurer"<?php if($position == 'treasurer') echo(' selected');?>>
												Treasurer
											</option>
											<option value="acmw-chair"<?php if($position == 'acmw-chair') echo(' selected');?>>
												ACMW Chair
											</option>
											<option value="pr"<?php if($position == 'pr') echo(' selected');?>>
												Public Relations
											</option>
											<option value="social"<?php if($position == 'social') echo(' selected');?>>
												Social Events
											</option>
											<option value="media"<?php if($position == 'media') echo(' selected');?>>
												Media
											</option>
											<option value="projects"<?php if($position == 'projects') echo(' selected');?>>
												Projects
											</option>
										</select>
									</div>
								</div>
							<form>
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
