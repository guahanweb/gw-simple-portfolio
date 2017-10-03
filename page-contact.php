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

$fields = array('fname', 'lname', 'email', 'message');
foreach ($fields as $field) {
  $$field = isset($_POST[$field]) && !empty($_POST[$field]) ? trim($_POST[$field]) : '';
}

$error = null;
$success = null;
if (isset($_POST['action'])) {
  try {
    \GW\Theme\SimplePortfolio::sendMail();
    $success = true;
  } catch (\GW\Theme\SimplePortfolioException $e) {
    $error = $e->getMessage();
  }
}

get_header();
?>
      <?php while (have_posts()): the_post(); ?>
      <article>
        <div class="row">
          <div class="col l6 s12">
<?php if ($success) { ?>
            <div class="success contact-success">
              <p>Message Sent!</p>
            </div>
            <div>
              <p>Thanks for contacting us! Please be patient, and we will get back to you as soon as possible.</p>
            </div>
<?php } else { ?>
<?php if ($error) { ?>
            <div class="error contact-error">
              <p><?php echo $error; ?></p>
            </div>
<?php } ?>
            <form name="contact" action="" class="contact-form" method="POST">
              <div class="row">
                <div class="input-field col s6">
                  <input type="text" name="fname" value="<?php echo $fname; ?>" id="f-fname" class="validate" />
                  <label for="f-fname" data-error="required">First Name</label>
                </div>
                <div class="input-field col s6">
                  <input type="text" name="lname" value="<?php echo $lname; ?>" id="f-lname" class="validate" />
                  <label for="f-lname" data-error="required">Last Name</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input type="email" name="email" value="<?php echo $email; ?>" id="f-email" class="validate" />
                  <label for="f-email" data-error="please provide a valid email address" data-success="looks good">Email Address</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <textarea name="message" id="f-message" class="materialize-textarea"><?php echo $message; ?></textarea>
                  <label for="f-message">Thoughts, Questions or Comments</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <button class="btn waves-effect waves-light" type="submit" name="action">Submit
                    <i class="material-icons right">send</i>
                  </button>
                </div>
              </div>
            </form>
<?php } ?>
          </div>
          <div class="col l4">
            <?php the_content(); ?>
          </div>
        </div>
      </article>
<?php endwhile; ?>
<?php get_footer(); ?>
