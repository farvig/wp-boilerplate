<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

<section class="container">
	<header class="page-header">
		<div class="centered">
		    <h1 class="page-title">
		        <?php the_title(); ?>
		    </h1>
		</div>
	</header>

	<div class="grid-group">
        <section class="grid size-8 size-8--lap size-12--palm">

		<?php the_content(); ?>
			
		</section>
		<aside>
			<?php get_sidebar(); ?>
		</aside>
	</div>		


</section>

<?php endwhile; ?>

<?php get_footer(); ?>