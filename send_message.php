<?php
$from = 'noreply@acm-utsa.org';

$text = $_POST['text'];
$to = 'acm.utsa@gmail.com';
$sender = $_POST['name'] . $_POST['m-email'];

if(strlen($text) <= 1 || strlen($sender) <= 1 || strlen($from) <= 1){
	die('Please complete all fields of the contact form.');
}

$recipient = 'ACM UTSA';
if($_POST['recipient'] == 'president'){
	$recipient = 'Trase Westbrook';
	$to = 'acm.utsa@gmail.com';
}
else if($_POST['recipient'] == 'vice-president'){
	$recipient = 'Myka Hancevic';
	$to = 'acm.utsa@gmail.com';
}
else if($_POST['recipient'] == 'president'){
	$recipient = 'Dalton Sumrall';
	$to = 'acm.utsa@gmail.com';
}
else if($_POST['recipient'] == 'treasurer'){
	$recipient = 'Julia Vasquez';
	$to = 'acm.utsa@gmail.com';
}
else if($_POST['recipient'] == 'pr'){
	$recipient = 'Soe Than';
	$to = 'acm.utsa@gmail.com';
}
else if($_POST['recipient'] == 'media'){
	$recipient = 'Andrew Hutton';
	$to = 'acm.utsa@gmail.com';
}
else if($_POST['recipient'] == 'social'){
	$recipient = 'Luke Taylor';
	$to = 'acm.utsa@gmail.com';
}
else if($_POST['recipient'] == 'projects'){
	$recipient = 'Brandon Kristian Bell';
	$to = 'acm.utsa@gmail.com';
}
else if($_POST['recipient'] == 'acmw-chair'){
	$recipient = 'Cassidy Matousek';
	$to = 'acm.utsa@gmail.com';
}

$body = 'Message from acm-utsa.org, sent by ' . htmlentities($sender) . '<br />Email: ' . htmlentities($_POST['email']) . '<br />For: '.htmlentities($recipient).'<br />Message: <br />' . htmlentities($text);

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "From: " . $from . "\r\n"."X-Mailer: php";

$message_stat = '';
if(mail($to, 'Message on acm-utsa.org', $body, $headers)){
	$message_stat = '1';
}
else{
	$message_stat = '2';
}

header('Location: contact?message_stat='.rawurlencode($message_stat));
?>
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
		</style>
	</head>
	<body>
		<?php
			require('common/menu.php');
		?>
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
									<a class="link" href="slack_invite" target="_blank">
										<input type="image" src="images/icons/add-to-slack.png" class="slack-button" style="outline-style: none;" />
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