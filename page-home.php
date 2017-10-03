<?php
/**
 * Blog Home Page Template
 * The home page template file
 *
 * This is the template for the Home Page
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage GWSimplePortfolio
 * @since GWSimplePortfolio 1.0
 */

get_header();
?>
    <?php
    while (have_posts()): the_post();
      $thumb = get_the_post_thumbnail(null, 'gw-simple-portfolio-main');
      printf('<div class="main-splash">%s</div>', $thumb);
    endwhile;
    ?>
<?php get_footer(); ?>
