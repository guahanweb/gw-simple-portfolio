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
        <div class="row">
          <div class="col m6 s12">
            <?php the_content(); ?>
          </div>
          <div class="col m3 s12">
            <?php
            $img = get_the_post_thumbnail(null, 'gw-simple-portfolio-tall');
            printf('<div class="about-image">%s</div>', $img);
            ?>
          </div>
      </article>
      <?php endwhile; ?>
<?php get_footer(); ?>
