<?php
require_once(__DIR__ . '/vendor/autoload.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
			require('common/head-includes.php');
		?>
        <title>Calendar | Association for Computing Machinery UTSA</title>
	</head>
	<body>
		<?php
			require('common/menu.php');
		?>
		<div id="content" class="container">
			<div class="row">
				<div class="col-sm-12">
					<!-- content here! -->
					<h1>
						Calendar
					</h1>
					<div class="section-container">
						<div class="embed-responsive embed-responsive-4by3">
							<iframe src="https://calendar.google.com/calendar/embed?src=hfgke17fnl1b7kqgcv7agd86qk%40group.calendar.google.com&ctz=America/Chicago" class="embed-responsive-item">
							</iframe>
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
