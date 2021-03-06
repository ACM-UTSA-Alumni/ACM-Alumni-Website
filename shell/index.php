<html>
	<head>
		<?php
			include('../common/google-analytics.php');
		?>
		<style type="text/css">
			body{
				background-color: black;
				color: green;
				font-family: courier;
				font-size:18px;
			}
			.command-block{
				margin: 0px;
				padding: 0px;
			}
			.ps1{
				display:inline-block;
			}
			.stdin{
				margin: 0px;
				padding: 0px;
				display:inline-block;
			}
			.stdout{
				
			}
			.help-row{
				display:block;
			}
			.help-item{
				display:inline-block;
				width:160px;
				font-weight:bold;
			}
			.help-description{
				display:inline-block;
			}
			#shell-window{
				min-height:100%;
				width:100%;
			}
		</style>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script type="text/javascript">
			var disallowedCommands = ["rm", "srm", "mkdir", "touch", "ftp", "ssh", "mv", "cp", "chmod", "chown", "mysql", "tar"];
			// "su" || "sudo"
			var supportedCommands = ["cd", "ls", "cat", "clear", "vi", "vim", "open", "exit", "help", "pwd", "sudo", "su"];
			window.processing = false; // indicates whether a command is currently being processed
			window.commandCancelled = false;
			window.session_terminated = false;
			// address of the current directory
			var pwd = "/";
			var path = [];
			var commandHistory = [];
			var historyIndex = -1;
			// use the filesystem object to simulate the real filesystem
			var filesystem = JSON.parse('{"type":"folder","name":"/","address":"/","children":[{"type":"file","name":"about.php","address":"/about.php"},{"type":"file","name":"calendar.php","address":"/calendar.php"},{"type":"file","name":"contact.php","address":"/contact.php"},{"type":"folder","name":"css","address":"/css","children":[{"type":"file","name":"index.css","address":"/css/index.css"},{"type":"file","name":"index.pyp","address":"/css/index.pyp"},{"type":"file","name":"master.css","address":"/css/master.css"}]},{"type":"file","name":"dues.php","address":"/dues.php"},{"type":"file","name":"favicon.ico","address":"/favicon.ico"},{"type":"file","name":"groups.php","address":"/groups.php"},{"type":"folder","name":"images","address":"/images","children":[{"type":"folder","name":"icons","address":"/images/icons","children":[{"type":"file","name":"add-to-slack.png","address":"/images/icons/add-to-slack.png"}]},{"type":"file","name":"logo-bordered.png","address":"/images/logo-bordered.png"},{"type":"file","name":"logo.png","address":"/images/logo.png"},{"type":"folder","name":"officer_photos","address":"/images/officer_photos","children":[{"type":"file","name":"andrew_bennett.jpg","address":"/images/officer_photos/andrew_bennett.jpg"},{"type":"file","name":"andrew_hutton.jpg","address":"/images/officer_photos/andrew_hutton.jpg"},{"type":"file","name":"andrew_sanetra.jpg","address":"/images/officer_photos/andrew_sanetra.jpg"},{"type":"file","name":"chris_doege.jpg","address":"/images/officer_photos/chris_doege.jpg"},{"type":"file","name":"default.jpg","address":"/images/officer_photos/default.jpg"},{"type":"file","name":"diego_romero.jpg","address":"/images/officer_photos/diego_romero.jpg"},{"type":"file","name":"jason_blig.jpg","address":"/images/officer_photos/jason_blig.jpg"},{"type":"file","name":"nishant_grover.jpg","address":"/images/officer_photos/nishant_grover.jpg"},{"type":"file","name":"shane_becker.jpg","address":"/images/officer_photos/shane_becker.jpg"}]}]},{"type":"file","name":"index.php","address":"/index.php"},{"type":"file","name":"join.php","address":"/join.php"},{"type":"file","name":"officers.php","address":"/officers.php"}]}');
			path = [filesystem];
			/*
			var filesystem = JSON.parse('{
				"type": "folder",
				"name": "/",
				"address": "/",
				"children": [
					{
						"type": "file",
						"name": "about.php",
						"address": "/about.php"
					}, {
						"type": "file",
						"name": "calendar.php",
						"address": "/calendar.php"
					}, {
						"type": "file",
						"name": "contact.php",
						"address": "/contact.php"
					}, {
						"type": "folder",
						"name": "css",
						"address": "/css",
						"children": [
							{
								"type": "file",
								"name": "index.css",
								"address": "/css/index.css"
							}, {
								"type": "file",
								"name": "index.pyp",
								"address": "/css/index.pyp"
							}, {
								"type": "file",
								"name": "master.css",
								"address": "/css/master.css"
							}
						]
					}, {
						"type": "file",
						"name": "dues.php",
						"address": "/dues.php"
					}, {
						"type": "file",
						"name": "favicon.ico",
						"address": "/favicon.ico"
					}, {
						"type": "file",
						"name": "groups.php",
						"address": "/groups.php"
					}, {
						"type": "folder",
						"name": "images",
						"address": "/images",
						"children": [
							{
								"type": "folder",
								"name": "icons",
								"address": "/images/icons",
								"children": [
									{
										"type": "file",
										"name": "add-to-slack.png",
										"address": "/images/icons/add-to-slack.png"
									}
								]
							}, {
								"type": "file",
								"name": "logo-bordered.png",
								"address": "/images/logo-bordered.png"
							}, {
								"type": "file",
								"name": "logo.png",
								"address": "/images/logo.png"
							}, {
								"type": "folder",
								"name": "officer_photos",
								"address": "/images/officer_photos",
								"children": [
									{
										"type": "file",
										"name": "andrew_bennett.jpg",
										"address": "/images/officer_photos/andrew_bennett.jpg"
									}, {
										"type": "file",
										"name": "andrew_hutton.jpg",
										"address": "/images/officer_photos/andrew_hutton.jpg"
									}, {
										"type": "file",
										"name": "andrew_sanetra.jpg",
										"address": "/images/officer_photos/andrew_sanetra.jpg"
									}, {
										"type": "file",
										"name": "chris_doege.jpg",
										"address": "/images/officer_photos/chris_doege.jpg"
									}, {
										"type": "file",
										"name": "default.jpg",
										"address": "/images/officer_photos/default.jpg"
									}, {
										"type": "file",
										"name": "diego_romero.jpg",
										"address": "/images/officer_photos/diego_romero.jpg"
									}, {
										"type": "file",
										"name": "jason_blig.jpg",
										"address": "/images/officer_photos/jason_blig.jpg"
									}, {
										"type": "file",
										"name": "nishant_grover.jpg",
										"address": "/images/officer_photos/nishant_grover.jpg"
									}, {
										"type": "file",
										"name": "shane_becker.jpg",
										"address": "/images/officer_photos/shane_becker.jpg"
									}
								]
							}
						]
					}, {
						"type": "file",
						"name": "index.php",
						"address": "/index.php"
					}, {
						"type": "file",
						"name": "join.php",
						"address": "/join.php"
					}, {
						"type": "file",
						"name": "officers.php",
						"address": "/officers.php"
					}
				]
			}');
			*/
			
			function get_child_index(parentDir, childName){
				for(var i = 0; i < parentDir.children.length; i++){
					if(parentDir.children[i].name == childName){
						return i;
					}
				}
				return -1;
			}
			
			function get_item(relative_path){
				var i = 0;
				var pwd_copy = pwd;
				var path_copy = JSON.parse(JSON.stringify(path));
				if(relative_path.charAt(relative_path.length - 1) == '/'){
					relative_path = relative_path.split("/").slice(0, -1).join("/");
				}
				var temp_path = relative_path.split(/\//);
				if(relative_path.charAt(0) == '/'){
					pwd_copy = "/";
					path_copy = [];
					path_copy[0] = filesystem;
					temp_path.shift();
				}
				var ever = true;
				for(ever; i < temp_path.length; i++){
				//  ^ lolz
					if(temp_path[i] == ".."){
						if(pwd_copy.split("/").length > 2){
							pwd_copy = pwd_copy.split("/").slice(0, -1).join("/");
							path_copy = path_copy.slice(0, -1);
						}
						else{
							pwd_copy = "/";
							path_copy = [];
							path_copy[0] = filesystem;
						}
					}
					else{
						var dir = (path_copy.length > 1) ? path_copy[path_copy.length - 1] : filesystem;
						var child_index = get_child_index(dir, temp_path[i]);
						if(child_index == -1){
							if(pwd_copy == "/"){
								$("#stdout").html("'" + pwd_copy + temp_path[i] + "' does not exist");
							}
							else{
								$("#stdout").html("'" + pwd_copy + "/" + temp_path[i] + "' does not exist");
							}
							i = path_copy.length;
						}
						else{
							path_copy.push(dir.children[child_index]);
							if(pwd_copy == "/"){
								pwd_copy += temp_path[i]; //dir.children[child_index].name;
							}
							else{
								pwd_copy += "/" + temp_path[i];
							}
						}
					}
				}
				return path_copy[path_copy.length - 1];
			}
			
			function prepare_stdin(){
				$("#ps1").removeAttr("id");
				$("#stdin").removeAttr("id");
				$("#stdout").removeAttr("id");
				$("#shell-window").append("<div class=\"command-block\"><div class=\"ps1\" id=\"ps1\">acm-utsa.org $&nbsp;</div><div class=\"stdin\" id=\"stdin\">_</div><div class=\"stdout\" id=\"stdout\"></div></div>");
				$("html, body").scrollTop($(document).height());
			}
			
			$(document).ready(function(){
				$(window).resize(function(){
					$(".clear-block").height($(window).height());
				});
				document.getElementById('fake-input').focus();
				$("#fake-input").on("keydown", function(e){
					var keyCode = e.which || e.keyCode || 0;
					if(keyCode == 8){
						// backspace key pressed
						$("#stdin").text($("#stdin").text().slice(0, -2));
						window.setTimeout(function(){
							$("#stdin").append('_');
						}, 0);
					}
				});
				$(document).on("keydown", function(e){
					var keyCode = e.which || e.keyCode || 0;
					window.commandCancelled = (keyCode == 67 || keyCode == 99) && e.ctrlKey;
					if(keyCode == 38){
						// up arrow pressed
						e.preventDefault();
						if(historyIndex < 0){
							historyIndex = commandHistory.length - 1;
						}
						else{
							historyIndex--;
							if(historyIndex == -1){
								historyIndex = 0;
							}
						}
						$("#stdin").text(commandHistory[historyIndex]);
					}
					else if(keyCode == 40){
						// down arrow pressed
						e.preventDefault();
						if(historyIndex < commandHistory.length){
							historyIndex++;
						}
						$("#stdin").text(commandHistory[historyIndex]);
					}
					else if((keyCode == 67 || keyCode == 99) && e.ctrlKey && !window.session_terminated){
						if($("#stdin").text().slice(-1) == '_'){
							// will replace '_' with '^C' at end of stdin
							// TODO fix the case where the user typed '_' at the end of stdin
							$("#stdin").text($("#stdin").text().slice(0, -1));
							window.typingPassword = false;
							$("#stdin").append('^C');
						}
						else{
							$("#stdout").append('^C');
						}
						prepare_stdin();
						window.setTimeout(function(){
							window.commandCancelled = false;
						}, 100);
					}
					else{
						//alert(keyCode);
					}
				});
				$(document).on("keypress", function(e){
					if(!window.processing){
						// shell is free to process the next command
						var keyCode = e.which || e.keyCode || 0;
						var stdin = $("#stdin").text();
						stdin = stdin.substring(0, stdin.length - 1);
						$("#stdin").text(stdin);
						if(keyCode == 13){
							// new command
							if(window.typingPassword){
								window.typingPassword = false;
								if(!window.commandCancelled){
									$("#wrong-password-box").html("incorrect password");
								}
								$("#wrong-password-box").removeAttr("id");
								prepare_stdin();
								return;
							}
							window.processing = true;
							var input = $("#stdin").text();
							commandHistory.push(input + "_");
							historyIndex = -1;
							var argv = input.split(/\s+/);
							var argc = argv.length;
							var inputCommand = argv[0];
							if(inputCommand.charCodeAt(0) < 5){
								// removes EOT left over from ctrl+c
								inputCommand = inputCommand.substring(1, inputCommand.length);
							}
							if($.inArray(inputCommand, disallowedCommands) != -1){
								// insufficeint privileges
								// must use sudo
								$("#stdout").html("insufficient privileges: requires root access");
							}
							else if($.inArray(inputCommand, supportedCommands) != -1){
								switch(inputCommand){
									case "cd":
										// switch to directory
										if(argc < 2){
											$("#stdout").html("cd expects a directory");
										}
										else{
											if(argv[1].length > 1 && argv[1].charAt([argv[1].length - 1]) == '/'){
												argv[1] = argv[1].split("/").slice(0, -1).join("/");
											}
											else if(argv[1].length == 1 && argv[1].charAt([argv[1].length - 1]) == '/'){
												pwd = "/";
												path = [];
												path[0] = filesystem;
												window.processing = false;
												prepare_stdin();
												return;
											}
											var item = get_item(argv[1]);
											if(item.type != "folder"){
												$("#stdout").html("'" + argv[1] + "' is not a directory");
												window.processing = false;
												prepare_stdin();
												return;
											}
											var temp_path = argv[1].split(/\//);
											var i = 0;
											if(argv[1].charAt(0) == '/'){
												pwd = "/";
												path = [];
												path[0] = filesystem;
												i++;
												argv[1] = argv[1].substring(1, argv[1].length);
											}
											var ever = true;
											for(ever; i < temp_path.length; i++){
											//  ^ lolz
												if(temp_path[i] == ".."){
													if(pwd.split("/").length > 2){
														pwd = pwd.split("/").slice(0, -1).join("/");
														path = path.slice(0, -1);
													}
													else{
														pwd = "/";
														path = [];
														path[0] = filesystem;
													}
												}
												else{
													var dir = (path.length >= 1) ? path[path.length - 1] : filesystem;
													var child_index = get_child_index(dir, temp_path[i]);
													if(child_index == -1){
														if(pwd == "/"){
															$("#stdout").html("'" + pwd + temp_path[i] + "' does not exist");
														}
														else{
															$("#stdout").html("'" + pwd + "/" + temp_path[i] + "' does not exist");
														}
														i = temp_path.length;
													}
													else{
														path.push(dir.children[child_index]);
														if(pwd == "/"){
															pwd += temp_path[i]; //dir.children[child_index].name;
														}
														else{
															pwd += "/" + temp_path[i];
														}
													}
												}
											}
										}
									break;
									case "clear":
										$("#stdout").html("<div class=\"clear-block\"></div>");
										$(".clear-block").innerHeight($(window).height());
									break;
									case "pwd":
										// prints current directory
										$("#stdout").html(pwd);
									break;
									case "ls":
										// lists items in pwd
										var ls_output = "";
										var dir;
										if(path.length > 1){
											dir = path[path.length - 1];
										}
										else{
											dir = filesystem;
										}
										for(var i = 0; i < dir.children.length; i++){
											if(dir.children[i].type == "folder"){
												ls_output += "<b>" + dir.children[i].name + "</b>&emsp;";
											}
											else{
												ls_output += dir.children[i].name + "&emsp;";
											}
										}
										$("#stdout").html(ls_output);
									break;
									case "cat":
										// print out the specified file
										if(argc < 2){
											$("#stdout").html("cat expects a file");
											break;
										}
										var item = get_item(argv[1]);
										if(item){
											if(item.type == "file"){
												var address = window.location.href.split("/").slice(0, -2).join("/") + item.address;
												$.ajax({
													method: "post",
													url: "fetch_html.php",
													data: {
														target_url: address
													},
													success: function(response){
														$("#stdout").html(response);
														window.setTimeout(function(){
															prepare_stdin();
														}, 100);
														window.processing = false;
														return;
													}
												});
											}
											else{
												$("#stdout").html("'"+argv[1]+"' is not a file");
											}
										}
										else{
											$("#stdout").html("'"+argv[1] + "' does not exist");
										}
									break;
									case "vi":
									case "vim":
										// opens the file for editing
										$("#stdout").html("permission denied: write access required");
									break;
									case "open":
										// open file in new tab
										var item = get_item(argv[1]);
										if(item){
											var url = window.location.href.split("/").slice(0, -2).join("/") + item.address;
											window.open(url);
										}
										else{
											$("#stdout").html("'"+argv[1] + "' does not exist");
										}
									break;
									case "exit":
										// close the tab
										$("#stdout").html("terminating session...<br /><br />session terminated");
										window.session_terminated = true;
										window.close();
										return;
									break;
									case "help":
										// prints help menu
										$("#stdout").html("<div class=\"help-row\"><div class=\"help-item\">cd [dir]</div><div class=\"help-description\">Goes to the specified directory</div></div> <div class=\"help-row\"><div class=\"help-item\">pwd</div><div class=\"help-description\">Prints the path of the current directory</div></div> <div class=\"help-row\"><div class=\"help-item\">ls</div><div class=\"help-description\">Lists the items in the current directory</div></div> <div class=\"help-row\"><div class=\"help-item\">cat [file]</div><div class=\"help-description\">Lists the items in the current directory</div></div> <div class=\"help-row\"><div class=\"help-item\">vi [file]</div><div class=\"help-description\">Opens a file for editing</div></div> <div class=\"help-row\"><div class=\"help-item\">open [item]</div><div class=\"help-description\">Opens an item in the browser</div></div> <div class=\"help-row\"><div class=\"help-item\">help</div><div class=\"help-description\">Prints commands and options</div></div> <div class=\"help-row\"><div class=\"help-item\">sudo [command]</div><div class=\"help-description\">Executes the command as root</div></div><div class=\"help-row\"><div class=\"help-item\">exit</div><div class=\"help-description\">Exits the session</div></div><div class=\"help-item\">clear</div><div class=\"help-description\">Clears previous commands</div></div> <!--<div class=\"help-row\"><div class=\"help-item\"></div><div class=\"help-description\"></div></div> -->");
									break;
									case "sudo":
									case "su":
										// pretend to check for password
										window.typingPassword = true;
										$("#stdout").html("Password: <div id=\"wrong-password-box\"></div>");
									break;
									case "":
										prepare_stdin();
									break;
									default:
										$("#stdout").html(""+inputCommand+": command not found");
									break;
								}
							}
							else if(inputCommand == "" || window.commandCancelled){
								//do nothing
							}
							else{
								// unsuppoted command
								$("#stdout").html(""+inputCommand+": command not found");
							}
							prepare_stdin();
							if(window.typingPassword){
								$("#ps1,#stdin,#stdout").hide();
							}
							window.processing = false;
						}
						else if(keyCode == 8){
							// moved to keydown event for compatibility
							// backspace key pressed
							// $("#stdin").text($("#stdin").text().slice(0, -1));
						}
						else{
							// write to #stdin
							if(!window.typingPassword){
								$("#stdin").append(String.fromCharCode(keyCode));
								$("#stdin").append('_');
							}
						}
					}
				});
			});
		</script>
	</head>
	<body>
		<input type="text" id="fake-input" style="position:fixed;bottom:-1000px;opacity:0.0;" />
		<div id="shell-window" onclick="document.getElementById('fake-input').focus();">
			Type 'help' for help
			<div class="command-block">
				<div class="ps1" id="ps1">
					<!-- pwd -->
					acm-utsa.org $
				</div>
				<div class="stdin" id="stdin"><!-- Standard Input -->_</div>
				<div class="stdout" id="stdout">
					<!-- Standard Output -->
					
				</div>
			</div>
		</div>
	</body>
</html>