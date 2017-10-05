<?php
namespace GW\Theme;

class SimplePortfolioSettings {
  static public function instance() {
    static $instance;
    if ($instance === null) {
      $instance = new SimplePortfolioSettings();
      $instance->load();
      $instance->listen();
    }
    return $instance;
  }

  public function load() {
    $this->twitter = \get_option('twitter_url');
    $this->facebook = \get_option('facebook_url');
  }

  public function listen() {
    \add_action('admin_menu', array($this, 'addMenuItem'));
  }

  public function addMenuItem() {
    $menu = \add_menu_page("Theme Options", "Theme Options", "manage_options", "theme-panel", array($this, 'renderThemePanel'), null, 99);
    // \add_action('admin_print_styles-' . $menu, array($this, 'enqueue'));
    \add_action('admin_init', array($this, 'renderOptionsFields'));
  }

  public function enqueue() {
    \wp_register_style('materialize.css', \get_template_directory_uri() . '/css/theme.css');
    \wp_enqueue_style('materialize.css');
    \wp_register_style('materialize-icons.css', 'https://fonts.googleapis.com/icon?family=Material+Icons');
    \wp_enqueue_style('materialize-icons.css');
  }

  public function renderThemePanel() {
?>
    <div class="wrap">
      <h1>Theme Options</h1>
      <?php settings_errors(); ?>
      <form method="post" action="options.php">
        <?php
        settings_fields('section');
        do_settings_sections('theme-options');
        submit_button();
        ?>
      </form>
    </div>
<?php
  }

  public function renderTwitter() {
    ?>
    <input type="text" name="twitter_url" id="twitter_url" value="<?php echo \get_option('twitter_url'); ?>" />
    <?php
  }

  public function renderFacebook() {
    ?>
    <input type="text" name="facebook_url" id="facebook_url" value="<?php echo \get_option('facebook_url'); ?>" />
    <?php
  }

  public function renderOptionsFields() {
    \add_settings_section('section', 'Social Media Profiles', null, 'theme-options');
    \add_settings_field('twitter_url', 'Twitter Profile Url', array($this, 'renderTwitter'), 'theme-options', 'section');
    \add_settings_field('facebook_url', 'Facebook Profile Url', array($this, 'renderFacebook'), 'theme-options', 'section');
    \register_setting('section', 'twitter_url');
    \register_setting('section', 'facebook_url');
  }
}
