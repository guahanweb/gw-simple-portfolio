<?php
/**
 * The template for displaying page content
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <div class="container">
    <div class="entry-content">
      <?php
      the_content();
      ?>
    </div>
  </div>
</article>
