<!DOCTYPE HTML>
<html lang="en">
<head>

<?php
/* set the site root individually in every environment */
$site_root = 'http://localhost:8888/FRAMEWORK/';

/* set defaults and include common functionality */
$error_title = 'FRAMEWORK - Error';
include("site_handlers/common.php");

/* get the current page */
if (isset($_GET['pageid'])){
	$page_identifier = $_GET['pageid'];
} else {
	$page_identifier = 'PAGE-NAME-1';
}

/* get the page level */
if (isset($_GET['level'])){
	$page_level = $_GET['level'];
} else {
	$page_level = '1';
}

/* get the site xml file for processing */
$site_file = 'xml/FRAMEWORK.xml';
if (!file_exists($site_file)) error_page("Can't find the configuration file “${site_file}”.",$error_title);
$framework_config = simplexml_load_file($site_file);
if (!$framework_config) error_page("Syntax error in configuration file “${framework_config}”.",$error_title);

/*go to page level*/
$xml_level = "sitestructure";

for ($i = 1; $i <= $page_level; $i++) {    
	$xml_level .= "/page";
}

/* load in the right level of the xml */
$pages = $framework_config->xpath($xml_level);
if (!$pages) error_page("Syntax error in configuration file: no pages found (//sitestructure/page/page).",$error_title);

/* set home page position by default */
$page_id = 1;

//echo $page_identifier;

/* load all xml children of the page as variables */
foreach ($pages as $page) {
	if (htmlspecialchars($page['ident']) == $page_identifier) {
		$page_id = htmlspecialchars($page['id']);
		foreach ($page->children() as $child) {
			${"{$child->getName()}"} = $child;
		}
	}
}

/* work backwards to get the ancestory of this page */
if ($partof != 0) {
	
	$temp_partof = $partof;
	for ($i = 1; $i < $page_level; $i++) {   
		/* reduce the page level by 1 */
		$xml_level = substr($xml_level, 0, strlen($xml_level)-5);
		/*echo '<br />' . $xml_level . '<br />';*/
		
		/* get the xml at the new higher level */
		$pages = $framework_config->xpath($xml_level);
		if (!$pages) error_page("Syntax error in configuration file: no pages found (//sitestructure/page/page).",$error_title);
		
		
		/* get the ancestor */
		foreach ($pages as $page) {
			if (htmlspecialchars($page['id']) == $temp_partof) {
				$temp_level = $page_level - $i;
				${"ancestor_$temp_level"} = $page->title;
				${"ancestor_ident_$temp_level"} = htmlspecialchars($page['ident']);
				$temp_partof = $page->partof;				
				/*echo '<br />' . ${"ancestor_$temp_level"} . '<br />';
				echo 'did it get here?';*/
				break;
			}
		}
		
	}	
}

/* if the page is not found */
if (!isset($title)) error_page("Incorrect url variables: no pages found: pageid: " . $page_identifier . " level: " . $page_level ,$error_title);
?>

<!-- Make all declarations -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="FRAMEWORK" />
<meta name="copyright" content="&copy; 2010 FRAMEWORK" />
<meta name="keywords" content="framwork,php<?php echo $keywords; ?>" />
<!-- robots not required ? -->
<?php if ($searchexclude == '1') echo '<META name="robots" content="NOINDEX,NOFOLLOW" />';

//check if this is a mobile device
include("classes/isMobile.php");
$detect = isMobile();
?>

<!-- all styles -->
<link rel="stylesheet" type="text/css" href="styles/reset.css" media="all" />
<link rel="stylesheet" type="text/css" href="styles/layout.css" media="all" />
<link rel="stylesheet" type="text/css" href="styles/style.css" media="all" />
<link rel="stylesheet" type="text/css" href="styles/print.css" media="print" />
<!--[if IE 8]>
<link rel="stylesheet" type="text/css" href="styles/ie8.css" media="all" />
<![endif]-->
<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="styles/ie7.css" media="all" />
<![endif]-->
<!--[if IE 6]>
<link rel="stylesheet" type="text/css" href="styles/ie6_less.css" media="all" />
<![endif]-->

<?php if ($detect == 'iPhone'): ?>	
	<!-- OPTIONAL - TURN ON IF WE ARE DOING A MOBILE VERSION
    <meta name="viewport" content="width = 480">
    <link rel="stylesheet" type="text/css" href="styles/iphone.css" media="screen" />
    -->
<?php endif; ?>

<!-- include all javascript 
<script type="text/javascript" src="scripts/common.js"></script> -->

<!-- include the individual pages header details -->
<?php if ($header == 1) {
	if ($duplicate == 1) {
		//echo 'dupe';
		include("managed_content/level_" . $duplicate_level . "/page_" . $duplicate_page . "/header.inc");
	} else {
		include("managed_content/level_" . $page_level . "/page_" . $page_id . "/header.inc");
	}
}

include("managed_content/common/title.inc");
?>

<link rel="shortcut icon" href="<?php echo $site_root ?>images/common/favicon.ico" type="image/x-icon" />

<title><?php echo $page_title ?> - EXTRA FRAMEWORK DETAILS</title>
</head>
<body<?php if ($page_id == '1') echo ' id="home"' ?>>

<!-- THIS WILL BE REMOVED VERY SOON -->
<div id="accessible_nav">
	<ul>
            <li><a href="#main_content">Skip to content</a></li>
    </ul>
</div>

<div id="main_container" class="<?php echo $page_identifier; ?>">

	<div id="header">
		<?php 
        include("managed_content/common/header.xml");
        include("managed_content/common/navigation.xml");
        ?>
    </div>
    
    <div id="main_content">
        <h1><?php echo $title; ?></h1>
        
        <?php
		
		/* ONLY REQUIRED IF THE PAGE HAS MORE THAN 1 LEVEL */
        include("managed_content/common/breadcrumb.xml");
		
        if ($duplicate == 1) {
            //echo 'dupe';
            include("managed_content/level_" . $duplicate_level . "/page_" . $duplicate_page . "/content.xml");
        } else {
            include("managed_content/level_" . $page_level . "/page_" . $page_id . "/content.xml");
        }
    /* display page timestamp if required - this may be used in the footer as well */
    //echo '<p id="modified">Page last modified: ' . $modified . '</p>';?>
    </div>
    
	<?php include("managed_content/common/footer.xml"); ?>

</div><!-- main_container -->

<!-- PUT SITE SPECIFIC GOOGLE ANALYTICS HERE -->
<?php if(strpos($site_root, 'localhost') == 0 and strpos($site_root, 'dev.lightiseverything') == 0 and strpos($site_root, 'int.lightiseverything') == 0 and strpos($site_root, 'acpt.lightiseverything') == 0) { ?>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-4982591-4");
pageTracker._trackPageview();
} catch(err) {}</script>
<?php } ?>
</body>
</html>