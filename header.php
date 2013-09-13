<!DOCTYPE html>
<html>

	<head>	

		<title><?php wp_title(' :: ', true, 'right'); ?><?php bloginfo('name'); ?></title>
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/_css/main.css" />

		<meta charset="utf-8">
        <meta content="General" name="rating"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=1100" />
        
        <!-- <link type="text/plain" rel="author" href="humans.txt" /> -->
		<meta name="description" content="<?php
			if(is_single() || is_page()){
				echo get_the_excerpt();
			} else {
				echo "Josh Rucker writes on web development, life, and things that happen in between.";
			}
		?>" />

		<!-- Typekit -->
        <script type="text/javascript" src="//use.typekit.net/meg6qsn.js"></script>
        <script type="text/javascript">try{Typekit.load();}catch(e){}</script>

		<?php wp_head(); ?>

	</head>
	
	<body <?php body_class(); ?>>
		
		<div id="wrapper">
			
			<div id="side-column">
					
				<header id="header" role="banner">
				
	                <h1 class="heading-branding"><a href="<?php bloginfo("home"); ?>">Joshua <b>Rucker</b></a></h1>
				
	            </header><!-- end #header -->

				<?php get_sidebar(); ?>

			</div>