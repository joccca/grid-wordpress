<?php
/**
 * @author Palasthotel <rezeption@palasthotel.de>
 * @copyright Copyright (c) 2014, Palasthotel
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2
 * @package Palasthotel\Grid-Wordpress
 */

$classes = $this->classes;
array_push( $classes, 'grid-box' );

if ( ! empty( $this->style ) ) {
	array_push( $classes, $this->style );
}

?>
<div class="<?php echo esc_attr( implode( $classes, ' ' ) ); ?>">
	<?php if ( ! empty( $this->title ) ) : ?>
		<?php if ( ! empty( $this->titleurl ) ) : ?>
			<h2 class="grid-box-title"><a href="<?php echo esc_url( $this->titleurl ); ?>"><?php echo $this->title; ?></a></h2>
		<?php else : ?>
			<h2 class="grid-box-title"><?php echo $this->title; ?></h2>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( ! empty( $this->prolog ) ) : ?>
		<div class="grid-box-prolog">
			<?php echo $this->prolog; ?>
		</div>
	<?php endif; ?>

	<?php
	// START of WordPress Loop
	$query = new WP_Query( $content );
	while ( $query->have_posts() ) {
		$query->the_post();

		/**
		 * If avoid doublets plugin is activated
		 */
		if ( function_exists( 'grid_avoid_doublets_add' ) ) {
			grid_avoid_doublets_add( get_the_ID(), $this->grid->gridid );
		}

		$found = false;
		// Checks if WordPress has a template for post content ...
		if(is_array($this->storage->templatesPaths))
		{
			foreach($this->storage->templatesPaths as $templatesPath) {
				if(file_exists($templatesPath.'/post_content.tpl.php')) {
					$found=true;
					include $templatesPath.'/post_content.tpl.php';
				}
				if($found) break;
			}
		}
		// ... if not, uses Grid template for post content
		if ( ! $found ) {
			include dirname( __FILE__ ) . '/post_content.tpl.php';
		}
	}
	wp_reset_postdata();
	// END of WordPress Loop
	?>

	<?php if ( ! empty( $this->epilog ) ) : ?>
		<div class="grid-box-epilog">
			<?php echo $this->epilog; ?>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $this->readmore ) ) : ?>
		<a href="<?php echo esc_url( $this->readmoreurl ); ?>" class="grid-box-readmore-link"><?php echo $this->readmore; ?></a>
	<?php endif; ?>

</div>
