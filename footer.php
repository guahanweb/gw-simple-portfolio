      <!-- end content -->
      </div>
    </div>

    <footer class="page-footer">
      <div class="row">
        <div class="col l4 offset-l2 s12">
          <?php get_template_part('template-parts/content', 'footer'); ?>
        </div>
        <div class="col l4 offset-l2 s12">
          <h5 class="white-text"><?php echo apply_filters('gw-simple-portfoliow-footer-menu-title', __('Links')); ?></h5>
          <ul>
<?php 
$items = wp_get_nav_menu_items('Header Menu');
foreach ($items as $item) {
  printf('<li><a class="grey-text text-lighten-3" href="%s">%s</a></li>',
    $item->url,
    $item->title
  );
}
?>
          </ul>
        </div>
      </div>
      <div class="row">
        <div class="col l10 offset-l2 s12">
          <div class="footer-copyright">
<?php
$title = apply_filters('gw-simple-portfolio-footer-name', get_bloginfo('name'));
printf('&copy; %s %s', date('Y'), $title);
?>
          </div>
        </div>
      </div>
    </footer>
    <?php wp_footer(); ?>
  </body>
</html>
