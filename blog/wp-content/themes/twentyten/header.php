<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
	<link rel="shortcut icon" href="http://www.malama-kai.org/000/favicon.ico">
	<link rel="stylesheet" href="http://www.malama-kai.org/000/css/awesome.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="http://www.malama-kai.org/000/css/buttons.css" type="text/css" media="screen" />
	<script type="text/javascript" src="http://www.malama-kai.org/000/scripts/js/date.js"></script>
	<script type="text/javascript" src="http://www.malama-kai.org/000/scripts/js/flip.js"></script>
	<script type="text/javascript" src="http://www.malama-kai.org/000/scripts/js/google-analytics.js"></script>
</head>

<body class="island">
<div class="root_matrix">
	<div class="root_00"><!--o--></div>

	<div class="root_12"><!--o--></div>
	<div class="root_13"><!--o--></div>
	<div class="root_14"><!--o--></div>
	<div class="root_15"><!--o--></div>
	<div class="root">
<!-- roots | above -->

<!-- header beign -->
	<header>
	<div class="header_matrix">
	<div class="header">
		<!-- header_logo_00 -->
			<div class="header_logo_00">
				<a href="http://www.malama-kai.org/"><span>Malama Kai</span></a>
			</div>
		<!-- header_logo_00 -->
		<!-- header_logo_01 -->
			<div class="header_logo_01">
				<h1><a href="http://www.malama-kai.org/"><span>Malama Kai Foundation - Stewardship Of The Sea</span></a></h1>
			</div>
		<!-- header_logo_01 -->
		<!-- header_contact -->
	  <div class="header_contact">
				<h6 class="email"><a href="mailto:info@malama-kai.org"><span><!--o--></span></a>info@malama-kai.org</h6>
				<h6 class="phone"><a href="#"><span><!--o--></span></a>808.885.6354</h6>
            <h6 class="contactlink"><a href="http://www.malama-kai.org/contact-us.html"><span>Contact Us</span></a></h6>
			</div>
		<!-- header_contact -->
		<!-- nav_main -->
			<!-- at bottom for z-index -->
		<!-- nav_main -->
	</div>
	</div>
	</header>
    <a name="topOfPage"></a>
    <a name="topOfSearch"></a>
<!-- header end --><!-- InstanceBeginEditable name="Topper" -->
<!-- surface_03 begin -->

<!-- surface_03 end -->
<!-- InstanceEndEditable -->
<!-- surface_04 begin -->
<div class="surface_04_matrix">
  <div class="surface_04_top">
    <!--o-->
  </div>
  <div class="surface_04_00">
    <!--o-->
  </div>
  <div class="surface_04_01">
    <!--o-->
  </div>
  <div class="surface_04_bottom">
    <!--o-->
  </div>
  <div class="surface_04">
    <!-- content_02 -->
    <div class="subsurface_04-main_matrix">
      <div class="subsurface_04-main_top">
        <!--o-->
      </div>
      <div class="subsurface_04-main_bottom">
        <!--o-->
      </div>
      <a name="topOfContent"></a>
<div class="subsurface_04-main content_02"><!-- InstanceBeginEditable name="Content" -->

	<div id="main">
