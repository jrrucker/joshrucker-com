<?php $cnt = 0; ?>
<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>

	<?php $cnt++; ?>
		
	<article class="excerpt<?php if($cnt == 1){ echo " first"; } ?>">
		
		<h3><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
		
		<p class="meta">
			Published on 
			<?php
				$postDate = get_the_date();
				$timestamp = strtotime($postDate);
			?>
			<time datetime="<?php echo date("Y-m-d",$timestamp); ?>">
				<?php echo date("l, F j, Y", $timestamp); ?></time>
		</p>
		
		<?php the_excerpt(); ?>
		
	</article>
		
<?php endwhile; ?>

<div class="pagination">
	<?php posts_nav_link('&nbsp; &nbsp;', '&laquo; Newer Posts', 'Older Posts &raquo;'); ?>
</div>

<?php else: ?>
	
	<p class="no-posts"><?php _e('Sorry, no posts matched your criteria.'); ?></p>
	
<?php endif; ?>