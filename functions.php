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
		} elseif(is_page() && has_post_thumbnail()){
			$classes[] = 'page-featured-image';
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
     
  	function jr_show_feed( $source = "", $cnt = 5 , $class = "" ){

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
     
    function jr_show_twitter( $handle = "ifiamblue" , $cnt = 3 ){
         
        $path = WP_CONTENT_DIR . "/twitter.txt";
        $serializedStatuses = jr_load_cache($path,(60*60));
        
        if($serializedStatuses !== false){
             
        	$statuses = json_decode($serializedStatuses);

        } else {
	
			require_once('_includes/twitteroauth/twitteroauth/twitteroauth.php');
		 	require_once('_includes/twitteroauth/config.php');

     	    $oauth_token = "19710733-32ZL9NBxFdcQfqFxPAqQwVGR7Fo3FjYGC42Zv9PEN";
         	$oauth_token_secret = "irBInt9KNyv9kuFuzxj3b8anfCsfiXerP0kCguUs";
         	$twitterUser = "ifiamblue";

			$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
			$statuses = $connection->get('statuses/user_timeline', array('screen_name' => $handle, 'count' => $cnt));
             
            $serializedStatuses = $statuses;
            
            jr_write_cache($path,json_encode($statuses));
         
        }
         
		echo "<div class=\"tweet-list\"><ul>";

     	foreach($statuses as $status){

			if($cnt-- > 0){

    			$text = $status->text;

	     	    // check for links
	     	    foreach($status->entities->urls as $l){
	     	        $url = $l->url;
	     	        $replace = "<a href=\"" . $url . "\">" . $url . "</a>";
	     	        $text = str_replace( $url , $replace, $text);
	     	    }

	     	    $id = $status->id;
	     	    $time = strtotime($status->created_at);

	            echo "<li>" . $text . "</li>";
	
			}

    	}

    	echo "</ul></div>";

	}
	
	// 4 hour timeout 60*60*4
	function jr_load_cache($file, $timeout=14400){
	    
	   	if(strlen($file) > 0){

       		if(file_exists($file)){

        		$modified = filemtime($file);

        		if((time() - $timeout) < $modified){
					$feedContent = file_get_contents($file);
                    return $feedContent;
        		} 

        	}
        }
        	
        return false;
    
	}
	
	function jr_write_cache($cachefile, $content){
	 
	    if(strlen($cachefile) > 0){
  			$file = fopen($cachefile,"w");
  			fwrite($file,$content);
  			fclose($file);
  		}
	    
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

     ## Documentation: http://codex.wordpress.org/Shortcode_API

	function jr_youtube_shortcode( $atts, $content = null ) {
		
		extract( shortcode_atts( array(
			'id' => ''
		), $atts ) );
		
		$output .= "<div class=\"video\">";
		$output .= "<div class=\"video-wrapper\">";
		$output .= "<iframe frameborder=\"0\" allowfullscreen=\"\"";  	 
		$output .= "src=\"http://www.youtube.com/embed/";
		$output .= $id;
		$output .= "?showinfo=0&amp;rel=0\"></iframe>";
		$output .= "</div>";
		
		if(!empty($content)){
			$output .= "<p class=\"wp-caption-text\">" . $content . "</p>";
		}
		
		$output .= "</div>";
		
		return $output;
	}
	add_shortcode( 'youtube', 'jr_youtube_shortcode' );


?>