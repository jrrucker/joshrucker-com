<?php get_header(); ?>

<section id="main" role="main">

	<!-- feature image (if homepage) -->
	<?php 
		$pageNum = (get_query_var('paged')) ? get_query_var('paged') : 1;
		if(is_home() && $pageNum == 1){
			jr_load_featured_image();
		} elseif(is_single() && has_post_thumbnail()){
			get_template_part('loop','featimage'); 
		}
	?>
	
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