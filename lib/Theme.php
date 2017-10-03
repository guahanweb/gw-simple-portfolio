<?php
namespace GW\Theme;

class SimplePortfolioException extends \Exception {}

class SimplePortfolio {
  static public function instance() {
    static $instance;
    if ($instance === null) {
      $instance = new SimplePortfolio();
      $instance->configure();
      $instance->listen();
    }
    return $instance;
  }

  public function configure() {
      \add_theme_support('post-formats', array('gallery'));
      \add_theme_support('post-thumbnails');
  }

  public function listen() {
    // hide admin bar
    \add_filter('show_admin_bar', '__return_false');

    // init
    \add_action('init', array($this, 'initialize'), 11);

    // nav bar
    \add_filter('nav_menu_css_class', array($this, 'checkNavClasses'), 10, 2);

    // customize password form for protected posts
    \add_filter('the_password_form', array($this, 'customPasswordForm'));

    // gallery rendering
    \add_filter('use_default_gallery_style', '__return_false');
    \add_filter('post_gallery', array($this, 'renderGallery'), 11, 3);
    \add_filter('the_title', array($this, 'trimTitle'));

    // enqueue styles and scripts
    \add_action('wp_enqueue_scripts', array($this, 'addAssets'), 10);
  }

  public function initialize() {
    add_post_type_support('page', 'post-formats');
    add_post_type_support('post', 'post-formats');

    register_taxonomy_for_object_type('post_format', 'page');
    register_taxonomy_for_object_type('post_format', 'post');

    add_image_size('gw-simple-portfolio-wide', 9999, 480, false);
    add_image_size('gw-simple-portfolio-tall', 320, 9999, false);
    add_image_size('gw-simple-portfolio-banner', 600, 600, false);
    add_image_size('gw-simple-portfolio-main', 720, 9999, true);
    add_image_size('gw-simple-portfolio-tiny', 64, 64, true);

    register_nav_menus(
      array(
        'header_menu' => __('Header Menu')
      )
    );
  }

  public function checkNavClasses($classes, $item) {
    if (in_array('current-menu-item', $classes)) {
      $classes[] = 'active';
    }
    return $classes;
  }

  public function addAssets() {
    // styles
    \wp_register_style('materialize.css', \get_template_directory_uri() . '/css/theme.css');
    \wp_enqueue_style('materialize.css');
    \wp_register_style('materialize-icons.css', 'https://fonts.googleapis.com/icon?family=Material+Icons');
    \wp_enqueue_style('materialize-icons.css');
    \wp_register_style('gw-simple-portfolio.css', \get_template_directory_uri() . '/css/portfolio.css');
    \wp_enqueue_style('gw-simple-portfolio.css');

    // scripts
    \wp_register_script('materialize.js', \get_template_directory_uri() . '/materialize/js/materialize.min.js', array('jquery'));
    \wp_enqueue_script('materialize.js');
    \wp_register_script('gw-gallery.js', \get_template_directory_uri() . '/js/gallery.js', array('jquery'));
    \wp_enqueue_script('gw-gallery.js');
  }

  public function renderGallery($output, $attr, $ids) {
    $images = array();
    $thumbs = array();

    $ids = explode(',', $attr['include']);
    foreach ($ids as $id) {
      $img = get_post($id);
      $images[] = array(
        'id' => 'gallery-image-' . $img->ID,
        'src' => wp_get_attachment_image_src($id, 'gw-simple-portfolio-wide'),
        'caption' => $img->post_excerpt,
        'name' => $img->post_title
      );
      $thumbs[] = wp_get_attachment_image_src($id, 'gw-simple-portfolio-tiny');
    }

    $tpl = <<<EOT
<div class="row">
  <div class="gw-gallery wrapper">
    <div class="col l8 s12">
      <div class="viewport">
        <div class="feature">
          %s
        </div>
      </div>
    </div>
    <div class="col l4 s12">
      <div class="controls">
        <div class="thumbs">
          %s
        </div>
      </div>
    </div>
  </div>
</div>
EOT;

    $o_images = array();
    $o_thumbs = array();

    $img_tpl = <<<EOT
<div class="img" id="%s" style="background-image: url(%s)">
  <div class="info">
    <div class="details">
      <h3>%s</h3>
      <p>%s</p>
    </div>
  </div>
</div>
EOT;

    foreach ($images as $i => $img) {
      $o_images[$i] = sprintf($img_tpl,
        $img['id'],
        $img['src'][0],
        $img['name'],
        $img['caption']
      );
      $o_thumbs[$i] = sprintf('<div class="thumb"><a href="#" data-select="%s" style="background-image: url(%s)"></a></div>', $img['id'], $thumbs[$i][0]);
    }

    return sprintf($tpl, implode('', $o_images), implode('', $o_thumbs));
  }

  /**
   * Remove the Protected or Private prefix from post titles
   */
  public function trimTitle($title) {
    $title = esc_attr($title);
    return preg_replace('/^pr(otected|ivate)\:\s*?/i', '', $title);
  }

  public function customPasswordForm() {
    global $post;
    $label = 'pwbox-' . (empty($post->ID) ? rand() : $post->ID);
    $action = \get_option('siteurl') . '/wp-login.php?action=postpass';
    $out = <<<EOT
<article>
  <div class="row">
    <div class="col l12">
      <form class="protected-post-form" action="$action" method="POST">
        <p>This content is password protected. Please enter the correct password to proceed.</p>
        <label class="pass-label" for="$label">Password</label>
        <input name="post_password" id="$label" type="password" />
        <input type="submit" name="Submit" class="btn" value="Submit" />
      </form>
    </div>
  </div>
</article>
EOT;
    return $out;
  }

  static public function sendMail() {
    $fields = array('fname', 'lname', 'email', 'message');

    foreach ($fields as $field) {
      $$field = isset($_POST[$field]) && !empty($_POST[$field]) ? trim($_POST[$field]) : '';
    }

    if (empty($fname) || empty($lname) || empty($email) || empty($message)) {
      throw new SimplePortfolioException('Something is missing: all fields are required', 100);
    } elseif (!preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i', $email)) {
      throw new SimplePortfolioException('Please provide a valid email address', 100);
    }

    $site = \get_bloginfo('name');

    $to = \get_option('admin_email');
    $headers = array(
      sprintf('From: %s %s <%s>', $fname, $lname, $email),
      sprintf('Reply-To: %s', $email)
    );
    $subject = sprintf('[%s] Message From %s %s', $site, $fname, $lname);
    $contents = file_get_contents(__DIR__ . '/email/form_submission.html');
    $matches = array('{{site}}', '{{name}}', '{{email}}', '{{message}}');
    $replacements = array($site, "$fname $lname", $email, \wpautop($message));
    $html = str_replace($matches, $replacements, $contents);

    $mail = \wp_mail($to, $subject, $html, $headers);
    if (!$mail) {
      throw new SimplePortfolioException('Could not send email: try again later', 200);
    }

    return TRUE;
  }
}
