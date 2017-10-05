<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php wp_title('|', true, 'right'); ?></title>
    <meta charset="utf-8" />
    <?php wp_head(); ?>
  </head>
  <body class="gw-simple-portfolio">
    <div class="row">
      <div class="col l2 m3 s6">
        <div class="header-logo brand-primary">
          <a href="#" class="brand-logo">
            <?php echo get_bloginfo('name'); ?>
          </a>
        </div>
      </div>
      <div class="col l4 m5 s6">
        <div class="header-logo brand-secondary">
          <a href="#" class="brand-logo">
            Photography
          </a>
        </div>
      </div>
      <div class="col l2 m4 s12 right">
        <?php get_template_part('template-parts/content', 'social-nav'); ?>
      </div>
    </div>
    <div class="row">
      <div class="col l2 s12">
        <?php wp_nav_menu(array(
            'theme_location' => 'header_menu',
            'menu_class' => 'main-nav',
            'menu_id' => 'nav-mobile'
          ));?>
      </div>
      <div class="col l10 s12">
      <!-- content start -->
