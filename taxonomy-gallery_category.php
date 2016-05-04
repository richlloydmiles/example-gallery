<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package _tk
 */

get_header(); 
global $wp_query;
$term = $wp_query->get_queried_object();
?>

<div class="container">
	<div id="content" class="main-content-inner col-md-12">

		<?php // add the class "panel" below here to wrap the content-padder in Bootstrap style ;) ?>
		<div class="content-padder">

			<?php if ( have_posts() ) : ?>

				<header>
					<h1 class="page-title">
						<?php echo $term->name; ?>
					</h1>
					<?php
						// Show an optional term description.
					$term_description = term_description();
					if ( ! empty( $term_description ) ) :
						printf( '<div class="taxonomy-description">%s</div>', $term_description );
					endif;
					?>
				</header><!-- .page-header -->

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php 
					$images = get_post_meta(get_the_id() , 'images' , true);
					$i = 0;
					foreach ($images as $image) {
						?>
						<a data-number="<?php echo $i; ?>" class="modal_target_<?php echo get_the_id(); ?>" data-toggle="modal" data-target="#modal_<?php echo get_the_id(); ?>">
							<div style="display:inline-block;width: 11.1111111111%;background-size: cover; background-repeat:no-repeat;position:relative;height: 120px; background-position: center;background-image:url(<?php echo $image; ?>); ?>);">
							</div>
						</a>
						<?php 
						$i++; 
						?>
						<?php
					}
					?>

					<!-- Modal -->
					<div id="modal_<?php echo get_the_id(); ?>" class="modal fade" role="dialog">
						<div class="modal-dialog modal-lg">
							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">
										<?php the_title(); ?>
									</h4>
								</div>
								<div class="modal-body">
									<div id="slider_<?php echo get_the_id(); ?>">
										<?php
										foreach ($images as $image) {
											?>
											<div style="background-size: contain; background-repeat:no-repeat;position:relative;height: 600px; background-position: center;background-image:url(<?php echo $image; ?>); ?>);">
											</div>
											<?php
										}
										?>
									</div> 
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>
					<script>
						jQuery(document).ready(function($) {	
							jQuery('#slider_<?php echo get_the_id(); ?>').slick({
								infinite: true,
								speed: 300,
								slidesToShow: 1,
								dots: false
							});		
							jQuery(document).on('click', '.modal_target_<?php echo get_the_id(); ?>', function(event) {
								var temp = jQuery(this).attr('data-number');


								jQuery('#slider_<?php echo get_the_id(); ?>').slick('slickGoTo' , temp);


							});	
							
						});
					</script>
				<?php endwhile; ?>

				<?php _tk_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<?php get_template_part( 'no-results', 'archive' ); ?>

			<?php endif; ?>

		</div><!-- .content-padder -->
	</div><!-- close .*-inner (main-content or sidebar, depending if sidebar is used) --> 
</div>
<?php get_footer(); ?>
