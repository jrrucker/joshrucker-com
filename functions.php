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

      
    /*****************************************************************************
     ** ii.   Custom Post Types
     *****************************************************************************/
     
     ## Documentation: http://codex.wordpress.org/Post_Types
      
      
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
     
     function ncsu_show_flickr_set( $set = "" , $api = "ddd4387ab0f016240787f9b72c9f9df4" ){
         
         ## phpFlickr Documentation: http://phpflickr.com/
         
 	     $f = new phpFlickr($api);
 	     
         $photos = $f->photosets_getPhotos($set);
         
         foreach ($photos['photoset']['photo'] as $photo){
             
             echo "<li><a rel=\"gallery\" href=\"" . $f->buildPhotoURL($photo, 'large') . "\">";
             echo "<img src=\"" . $f->buildPhotoURL($photo, 'square') . "\" alt=\"" . $photo['title'] . "\" title=\"" . $photo['title'] . "\" width=\"75\" height=\"75\" />";
             echo "</a></li>";
             
         }
         
     }

    /*****************************************************************************s
     ** v.  Short Codes
     *****************************************************************************/

     ## Docuementation: http://codex.wordpress.org/Shortcode_API


?>