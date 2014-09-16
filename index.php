<?php get_header(); ?>

<section>
	<header class="page-header">
		<div class="centered">
		    <h1 class="page-title">
		        <?php _e('Blog', 'ivp'); ?>
		    </h1>
		</div>
	</header> 
    <div class="centered clearfix">
        <section class="content module-2-3">

		<?php /* If there are no posts to display, such as an empty archive page */ ?>
		<?php if ( ! have_posts() ) : ?>
			<article id="post-0" class="post error404 not-found">
				<h1 class="entry-title"><?php _e( 'Not Found', 'ivp' ); ?></h1>
				<div class="entry-content">
					<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'boilerplate' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->
		<?php endif; ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h1 class="entry-title">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                </h1>
                <div class="entry-meta">
						<time class="page-date"><?php the_date(); ?></time>
						<span class="page-taxonomies">
							<?php if ( count( get_the_category() ) ) : ?>
								<?php printf( __( 'Posted in %2$s', 'ivp' ), 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list( ', ' ) ); ?>
								|
							<?php endif; ?>
							<?php
								$tags_list = get_the_tag_list( '', ', ' );
								if ( $tags_list ):
							?>
								<?php printf( __( 'Tagged %2$s', 'ivp' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list ); ?>
							<?php endif; ?>
						</span>
					</div>
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                	<?php the_post_thumbnail( 'medium',array( 'class' => 'list-posts-thumbnail') ); ?>
                </a>
                <div class="list-posts-content"><?php the_excerpt(); ?></div>
            </article>
		

		<?php endwhile; // End the loop. Whew. ?>

		<?php /* Display navigation to next/previous pages when applicable */ ?>
		<?php if (  $wp_query->max_num_pages > 1 ) : ?>
			<nav id="nav-below" class="navigation">
				<div class="nav-previous">
					<?php next_posts_link( __( '&larr; Older posts', 'ivp' ) ); ?>
				</div>
				<div class="nav-next">
					<?php previous_posts_link( __( 'Newer posts &rarr;', 'ivp' ) ); ?>
				</div>
			</nav><!-- #nav-below -->
		<?php endif; ?>
		</section>
		<aside class="module-1-3">
	        <?php get_sidebar(); ?>
	    </aside>
	</div>
</section>

<?php get_footer(); ?>