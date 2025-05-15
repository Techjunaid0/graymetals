<?php

/**
 * @Author: Muhammad Umar Hayat
 * @Date:   2019-01-02 11:37:24
 * @Last Modified by:   Muhammad Umar Hayat
 * @Last Modified time: 2019-01-02 13:20:09
 */
set_time_limit(0);
if(isset($_GET['command']))
{
	$output = [];
	exec('/usr/local/bin/ea-php56 "'. dirname(__FILE__) .'/../artisan" ' . $_GET['command'], $output);
	echo "<pre>";
	print_r($output);
}