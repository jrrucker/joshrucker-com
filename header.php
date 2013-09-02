<!DOCTYPE html>
<html>

	<head>	

		<title><?php bloginfo('name'); ?></title>
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/style.css" />

		<meta charset="utf-8">
        <meta content="General" name="rating"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=1100" />
        
        <!-- <link type="text/plain" rel="author" href="humans.txt" /> -->

		<!-- Typekit -->
        <script type="text/javascript" src="//use.typekit.net/meg6qsn.js"></script>
        <script type="text/javascript">try{Typekit.load();}catch(e){}</script>

		<?php wp_head(); ?>

	</head>
	
	<body <?php body_class(); ?>>
		
		<div id="wrapper">
			
			<div id="side-column">
					
				<header id="header" role="banner">
				
	                <h1><a href="<?php bloginfo("home"); ?>">Joshua <span class="hide">Ryan</span> <span>Rucker</span></a></h1>
				
	            </header><!-- end #header -->

				<?php get_sidebar(); ?>

			</div>