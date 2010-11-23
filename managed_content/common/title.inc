<?php 
$page_title = 'FRAMEWORK';

for ($i = 1; $i < $page_level; $i++) {
	$page_title = $page_title . ' - ' . ${"ancestor_$i"};
}
$page_title = $page_title . ' - ' . $title;
?>