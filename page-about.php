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
      <?php while (have_posts()): the_post(); ?>
      <article>
        <?php the_content(); ?>
      </article>
      <?php endwhile; ?>
<?php get_footer(); ?>
