<!DOCTYPE html>
<html>
	<head>
		<?php
			require('common/head-includes.php');
		?>
		<title>The Association for Computing Machinery &mdash; UTSA</title>
		<style type="text/css">
			.laptop-list-item {
				margin: 10px;
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
					<!--
					<div class="row section-container" id="home-page-rowdyhacks-image">
						<div class="col-sm-12">
						</div>
					</div>
					-->
					<div class="row section-container">
						<div class="col-sm-12">
							There are several options for new students to be able to use linux on their laptops. These are the three ways we recommend. 
							<ol>
								<li class="laptop-list-item">
									<b>Buy a laptop with linux preinstalled.</b>
									<br />
									The main benefit of this choice is that you know the operating system will have working drivers, and fewer
        possible issues than if you install linux yourself. Same applies for macOS.
								</li>
								<li class="laptop-list-item">
									<b>Dual Boot.</b>
									<br />
									This will allow you to have both Windows and linux installed but is the most technical solution. You 
        will need to format your hard drive into multiple partitions, and install linux on the new one. It may
        also require you to find and install drivers on linux.
								</li>
								<li class="laptop-list-item">
									<b>SSH.</b>
									<br />
									This will allow you to ssh into the servers on campus, and maintain a persistent environment. The main 
        issue is that it will be mostly command line programs that you can run.
								</li>
							</ol>
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
