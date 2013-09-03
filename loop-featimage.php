<?php
	
	$permalink = get_permalink();
	$postid = get_the_ID();
	$thumbnail = get_the_post_thumbnail( $postid, 'featured-image');
	
	if(empty($thumbnail)){
		$thumbnail = get_the_post_thumbnail( $postid );
	}
	
	echo '<figure class="feature-image">';
	echo '<a href="' . $permalink . '">' . $thumbnail . '</a>';
	
	$excerpt = get_the_excerpt();
	
	if(!is_single()){
		echo '<figcaption>' . $excerpt . '</figcaption>';
	}
	
	
	
	
	
	echo '</figure>';

?>