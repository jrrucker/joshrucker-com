<?php get_header(); ?>

<section id="main" role="main">

	<!-- feature image (if homepage) -->
	<?php if(is_home()): ?>
		<figure class="feature-image">
			<img src="http://farm9.staticflickr.com/8344/8173398261_f345c4c6c8_c.jpg" alt="" />
			<figcaption>
				Earth’s future? It’s sure to include rising temperatures, a growing population, 
				and a dwindling supply of farmable land. Earth’s future? It’s sure to include 
				rising temperatures, a growing population, and a dwindling supply of farmable land.
			</figcaption>
		</figure>
	<?php endif; ?>
	
	<!-- Page title (if applicable) -->	
	<?php if(is_search()): ?>
		<h2 class="page-title">Search results for &ldquo;<?php the_search_query(); ?>&rdquo;</h2>
	<?php elseif(is_404()): ?>
		<h2 class="page-title">Sorry, this page doesn't exist.</h2>
	<?php elseif(is_category()): ?>
		<h2 class="page-title">Category: <?php echo single_cat_title( '', false ); ?></h2>
	<?php elseif(is_tag()): ?>
		<h2 class="page-title">Tag: <?php echo single_tag_title( '', false ); ?></h2>
	<?php endif; ?>
	
	<!-- Loop -->	
	<?php 
		if(is_page() || is_single()){
			get_template_part('loop','posts'); 
		} else{
			get_template_part('loop','postexcerpt'); 
		}
		
	?>
	
</section><!--#main-->

<?php get_Footer(); ?>