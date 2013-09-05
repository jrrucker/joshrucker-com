<?php

    /** 
     **  This file is organized in 5 main components:
     ** 
     **  i.   Wordpress Resets
     **  ii.  Custom Post Types
     **  iii. Custom Taxonomies
     **  iv.  Theme Functions
     **  v.   Short Codes
     ** 
     **/

    /*****************************************************************************
     ** i.   Wordpress Resets 
     *****************************************************************************/

     ## Resource: http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
	add_theme_support( 'post-thumbnails' );
	
	// Add specific CSS class by filter
	add_filter('body_class','jr_class_names');
	function jr_class_names($classes) {
		
		if(is_single() && has_post_thumbnail()){
			$classes[] = 'single-featured-image';
			return $classes;
		}
		
		return $classes;
	
	}
	
	add_action('wp_head','jr_open_graph');
	function jr_open_graph(){
	
		$site_name = get_bloginfo('name');
		echo '<meta property="og:site_name" content="'.$site_name.'"/>'.PHP_EOL;
		
		if (is_singular()){
			echo '<meta property="og:title" content="'.get_the_title().'" />'.PHP_EOL;
			echo '<meta property="og:type" content="article" />'.PHP_EOL;
			echo '<meta property="og:description" content="' . get_the_excerpt() . '" />'.PHP_EOL;
			
			if(has_post_thumbnail()){
				
				$src = wp_get_attachment_image_src( 
					get_post_thumbnail_id($post->ID), 
					array( 720,405 ), false, '' 
				);
				echo '<meta property="og:image" content="'. $src[0] .' "/>'.PHP_EOL;
			
			}
			
		} else {
			echo '<meta property="og:description" content="Josh Rucker writes on web development, life, and things that happen in between." />'.PHP_EOL;
			echo '<meta property="og:type" content="website" />'.PHP_EOL;
		}
		echo '<meta property="og:url" content="'. get_permalink() .'" />'.PHP_EOL;
		
	}
    
	add_action( 'init', 'jr_page_excerpt' );
	function jr_page_excerpt() {
		add_post_type_support( 'page', 'excerpt' );
	}

    /*****************************************************************************
     ** ii.   Custom Post Types
     *****************************************************************************/
     
     ## Documentation: http://codex.wordpress.org/Post_Types

	function jr_featured_image_post_type(){
		
		$labels = array(
			'name' => 'Featured Images',
		    'singular_name' => 'Featured Image',
		    'add_new' => 'Add New',
		    'add_new_item' => 'Add New Featured Image',
		    'edit_item' => 'Edit Featured Image',
		    'new_item' => 'New Featured Image',
		    'all_items' => 'All Featured Image',
		    'view_item' => 'View Featured Image',
		    'search_items' => 'Search Featured Images',
		    'not_found' =>  'No Featured Image found',
		    'not_found_in_trash' => 'No Featured Images found in Trash', 
		    'parent_item_colon' => '',
		    'menu_name' => 'Featured Images'
		);

		$args = array(
		    'labels' => $labels,
		    'public' => true,
		    'publicly_queryable' => true,
		    'show_ui' => true, 
		    'show_in_menu' => true, 
		    'query_var' => true,
		    'rewrite' => array( 'slug' => 'featured-image' ),
		    'capability_type' => 'post',
		    'has_archive' => true, 
		    'hierarchical' => false,
		    'menu_position' => null,
		    'supports' => array( 'title', 'editor', 'author', 'excerpt', 'thumbnail', 'comments' )
		); 

		register_post_type( 'featured-image', $args );
		
	}
	
	add_action('init','jr_featured_image_post_type');
	add_image_size( 'featured-image', 800, 9999 ); //300 pixels wide (and unlimited height)

      
    /*****************************************************************************
     ** iii.  Custom Taxonomies
     *****************************************************************************/
     
     ## Documentation: http://codex.wordpress.org/Taxonomies
      
      
    /*****************************************************************************
     ** iv.  Theme Functions
     *****************************************************************************/

     ## FYI: http://codex.wordpress.org/Functions_File_Explained
     
     function ncsu_show_feed( $source = "", $cnt = 5 , $class = "" ){

         if(!empty($source)){

         	// content of feed 
         	$feedContent = "";

         	// create curl object and set options
         	if(strlen($feedContent) < 1){

         		$curl = curl_init();
         		curl_setopt($curl, CURLOPT_URL,$source);
         		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
         		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);

         		// load xml object from curl execution
         		$feedContent = curl_exec($curl);
         		curl_close($curl);

         	} 

         	if($feedContent == false || strstr($feedContent,"<title>WordPress &rsaquo; Error</title>")){

         		return false;

         	} else {

         		// load curl content into simplexml
         		$feedObj = simplexml_load_string($feedContent);
         		
         		if(count($feedObj->channel->item) < 1)
         		    return;
         		    
         		if(empty($class))       echo "<ul>";
         		else                    echo "<ul class=\"$class\">";
         		             		    
         		foreach($feedObj->channel->item as $item){

            		if($cnt-- > $cnt){

                		echo "<li><a href=\"" . $item->link . "\">" . $item->title . "</a> <span>" . date("n/j/Y",strtotime($item->pubDate)) . "</span></li>";

                    }

            	}
            	
            	echo "</ul>";

         	}        

         }

     }
     
     function ncsu_show_twitter( $handle = "ncstate" , $cnt = 5 ){

         // json source
         $source = "https://api.twitter.com/1/statuses/user_timeline.json?include_entities=true&include_rts=true&screen_name=$handle&count=$cnt";

       	$curl = curl_init();
     	curl_setopt($curl, CURLOPT_URL,$source);
     	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
     	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);

     	// load xml object from curl execution
     	$twitterSource = curl_exec($curl);
     	curl_close($curl);

     	$twitterObj = json_decode($twitterSource);

     	if(count($twitterObj) < 1)
     	    return;

        echo "<ul>";

     	foreach($twitterObj as $status){

     	    $text = $status->text;

     	    // check for links
     	    foreach($status->entities->urls as $l){
     	        $url = $l->url;
     	        $replace = "<a href=\"" . $url . "\">" . $url . "</a>";
     	        $text = str_replace( $url , $replace, $text);
     	    }

     	    $id = $status->id;
     	    $time = strtotime($status->created_at);

     	    echo "<li>" . $text . " &mdash;  <a href=\"https://twitter.com/intent/retweet?tweet_id=" . $id . "\">" . date("n/j/Y, g:h a", $time)  . "</a></li>";
     	    
     	}

     	echo "</ul>";

     }
     
	function jr_load_featured_image(){
		
		$query = new WP_query(
			array(
				'post_type' => 'featured-image',
				'posts_per_page' => 1
			)
		);
		
		if($query->have_posts()){
			
			$query->the_post();
			
			get_template_part('loop','featimage'); 
		}
		
	}

    /*****************************************************************************s
     ** v.  Short Codes
     *****************************************************************************/

     ## Docuementation: http://codex.wordpress.org/Shortcode_API


?>