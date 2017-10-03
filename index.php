<?php
/**
 * Blog Page Template
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
if (have_posts()):
  while (have_posts()): the_post();
    if ('gallery' == get_post_format(get_the_ID())) {
      get_template_part('content', 'gallery');
    } else {

    }
  endwhile;
endif;
get_footer();
?>
