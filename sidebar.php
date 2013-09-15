<aside id="sidebar" role="complementary">
	
	<?php get_search_form(); ?>
	
	<section class="sidebar-section" id="about" aria-label="About the Author">

		<p>I’m the senior web developer for the Web Communications team at North 
			Carolina State University in Raleigh, NC.  This site is a collection
			of thoughts on web development, life, and the things that happen in 
			between. <a class="more" href="<?php echo bloginfo('url'); ?>/about/">Read&nbsp;more about me &raquo;</a>

    </section><!-- end #about -->

	<section class="sidebar-section">
		
		<h2>Follow Me on Twitter</h2>
		
		<?php jr_show_twitter(); ?>
		
		<a href="https://twitter.com/ifiamblue" class="twitter-follow-button" data-show-count="false">Follow @ifiamblue</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
		
	</section>
    

	<?php /* 
    
    <section id="work" class="clearfix">
    
		<h2>Recent Work</h2>
		
		<ul>
			<li><a href="#"><img src="http://placehold.it/300x200/" /></a></li>
			<li><a href="#"><img src="http://placehold.it/300x200/" /></a></li>
			<li class="third"><a href="#"><img src="http://placehold.it/300x200/" /></a></li>
		</ul>
    
    </section>
    
	*/ 
	
	?>
	
</aside>