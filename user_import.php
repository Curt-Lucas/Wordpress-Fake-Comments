<?php
//Wordpress Fake User Import
//
//Step 1 - Run messages.sql
//Step 2 - Edit SQL settings & run user_import.php
$link = mysqli_connect("localhost", "wp_user", "wp_pass", "wp_databasename");

if($link === false)
    die("ERROR: Could not connect. " . mysqli_connect_error());

//SELECT 20,000 users to import
$sql0 = "SELECT DISTINCT uniqueId FROM messages LIMIT 20000";

if($result = mysqli_query($link, $sql0)){
	
    if(mysqli_num_rows($result) > 0){
		
        while($row = mysqli_fetch_array($result)){
			$nickname = $row['uniqueId'];
			
			$sql1 = "INSERT INTO `wp_users` (`user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES 
			('${nickname}', '', '${nickname}', 'email@email.com', '', '2022-04-21 17:43:03', '1650562983:$P$BlPYsr0QnXfy.yXMR4ya3uJg4YYpX./', 0, '${nickname}');";

			if(mysqli_query($link, $sql1)){
				
				$last_id = mysqli_insert_id($link);
				
				$sql2 = "INSERT INTO `wp_usermeta` (`user_id`, `meta_key`, `meta_value`) VALUES 
							(${last_id}, 'nickname', '${nickname}'),
							(${last_id}, 'first_name', ''),
							(${last_id}, 'last_name', ''),
							(${last_id}, 'description', ''),
							(${last_id}, 'rich_editing', 'true'),
							(${last_id}, 'syntax_highlighting', 'true'),
							(${last_id}, 'comment_shortcuts', 'false'),
							(${last_id}, 'admin_color', 'fresh'),
							(${last_id}, 'use_ssl', '0'),
							(${last_id}, 'show_admin_bar_front', 'true'),
							(${last_id}, 'locale', ''),
							(${last_id}, 'wp_capabilities', 'a:1:{s:10:subscriber;b:1;}'),
							(${last_id}, 'wp_user_level', '0'),
							(${last_id}, 'dismissed_wp_pointers', ''),
							(${last_id}, 'facebook', ''),
							(${last_id}, 'instagram', ''),
							(${last_id}, 'linkedin', ''),
							(${last_id}, 'myspace', ''),
							(${last_id}, 'pinterest', ''),
							(${last_id}, 'soundcloud', ''),
							(${last_id}, 'tumblr', ''),
							(${last_id}, 'twitter', ''),
							(${last_id}, 'youtube', ''),
							(${last_id}, 'wikipedia', '')";
						
				if(mysqli_query($link, $sql2)){
					
					echo "Records added successfully.";
				}else{
					
					echo "ERROR: ".mysqli_error($link);
				}
			}else{
				
				echo "ERROR: ".mysqli_error($link);
			}
        }
        mysqli_free_result($result);
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
mysqli_close($link);