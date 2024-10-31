<?php
/*
File Name: Click Counter Redirection File - Part of the Click Counter Plugin
Version: 1.02
Author: Ozh
Author URI: http://planetOzh.com
*/

require('./wp-blog-header.php');
// IMPORTANT :
// if you don't put this file in your blog root (where your index.php is)
// then modify the path to wp-blog-header.php above

if (!headers_sent()) {
	header('Expires: Mon, 23 Mar 1972 07:00:00 GMT');
	header('Cache-Control: no-cache, must-revalidate');
	header('Pragma: no-cache');
}

if (@$_SERVER["QUERY_STRING"]) {
	$url = $_SERVER["QUERY_STRING"];
	
	if (function_exists('wp_ozh_click_increment'))
		$click= wp_ozh_click_increment($url);

	if ($is_IIS) {
		header("Refresh: 0;url=$url");
	} else {
		if (!headers_sent()) {
			header("Location: $url");
			header("Status: 303");
		} else {
			print "<script>location.replace(\"$url\");</script>";
		}
	}

} else {
	echo "Hmmm ? ";
	if (function_exists('get_option')) {
		echo "<a href=\"" . get_option('siteurl') . "\">Back to Blog</a> !";
	} else {
		echo '<a href="/">Back to the root</a> !';
	}
}
?>