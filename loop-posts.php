<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>

	<article class="full">
		
		<h2><?php the_title(); ?></h2>
		
		<p class="meta">
			Published on 
			<?php
				$postDate = get_the_date();
				$timestamp = strtotime($postDate);
			?>
			<time datetime="<?php echo date("Y-m-d",$timestamp); ?>">
				<?php echo date("l, F j, Y", $timestamp); ?></time>
		</p>
		
		<?php the_content(); ?>
		
		<?php the_tags( "<p><b>Tagged:</b> ", ", ","</p>"); ?>
		
	</article>
		
<?php endwhile; else: ?>
	
	<p class="no-posts"><?php _e('Sorry, no posts matched your criteria.'); ?></p>
	
<?php endif; ?>