<?php get_header(); ?>

<section id="main" role="main">
	
	<h2 class="page-title">Search results for &ldquo;<?php the_search_query(); ?>&rdquo;</h2>

	<?php get_template_part('loop','postexcerpt'); ?>
	
</section><!--#main-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>