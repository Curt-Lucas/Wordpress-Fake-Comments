<?php
//Wordpress Fake Comment Import
$link = mysqli_connect("localhost", "wp_user", "wp_pass", "wp_databasename");

if($link === false)
    die("ERROR: Could not connect. " . mysqli_connect_error());

//SELECT 20,000 users to import
$sql0 = "SELECT DISTINCT comment FROM messages WHERE comment liek '%depp%' LIMIT 10";

if($result = mysqli_query($link, $sql0)){
	
    if(mysqli_num_rows($result) > 0){
		
        while($row = mysqli_fetch_array($result)){
			
			$user_id = rand(33, 20032);
			$comment = $row['comment'];
			
			$sql1 = "INSERT INTO `wp_comments` (`comment_post_ID`, `comment_author`, `comment_author_email`, `comment_author_url`, `comment_author_IP`, `comment_date`, `comment_date_gmt`, `comment_content`, `comment_karma`, `comment_approved`, `comment_agent`, `comment_type`, `comment_parent`, `user_id`) VALUES 
(59, '', '', '', '198.116.136.184', '2022-04-25 21:48:41', '2022-04-26 01:48:41', '${comment}', 0, '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.127 Safari/537.36', 'comment', 0, ${user_id});";

			if(mysqli_query($link, $sql1)){
				
				echo "Records added successfully.";
				
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