<?php

/* Exit if accessed directly */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$acf_ajax = strpos($_SERVER['HTTP_ACCEPT'], 'application') !== false?'false':'true';
$acf_clean = false;

  if ($acf_ajax == "true") {

    _e('<h2>Access denied.</h2>', 'acf_cleaner');

  } else if(is_user_logged_in() && is_admin()) {

?>

<div class="wrap">
  <h2><?php _e('ACF cleaner', 'acf_cleaner'); ?></h2>

<?php

  if (isset($_POST['clean'])) {

    if ($_POST['clean'] == 'clean') {

      $acf_clean = true;

    } else {

?>

  <div class="notice notice-error is-dismissible">
    <p>
      <?php printf( __('<b>Error</b> : passphrase doesn\'t match "<code>%1$s</code>".', 'acf_cleaner'), 'clean'); ?>
    </p>
  </div>

<?php

    }

  } else {

?>

  <div class="notice notice-warning is-dismissible">
    <p>
      <?php printf( __('Before you do any cleaning <a href="%1$s" target="%2$s" title="view plug-in (external)">backup</a> your database first.<br>This tool only proceeds (ACF) fieldnames starting with <code>ACF__</code> (case-insensitive).', 'acf_cleaner'), 'https://wordpress.org/plugins/wp-dbmanager/', '_blank'); ?>
    </p>
  </div>

<?php

  }

?>

  <form method="post" action="#">

    <table class="form-table">
      <tr valign="top">
      <th scope="row"><?php printf( __('Type <code>%1$s</code> before submit :', 'acf_cleaner'), 'clean'); ?></th>
      <td><input type="text" name="clean" value="" placeholder="..."></td>
      </tr>
    </table>

    <p>
      <button data-action="acf-clean" class="button button-primary" type="submit"><?php _e('ACF <b>clean</b>', 'acf_cleaner'); ?></button>
      <button data-action="acf-check" class="button button-secondary" type="button" onclick="location.href=location.href;"><?php _e('ACF <b>check</b>', 'acf_cleaner'); ?></button>
    </p>

  </form>

  <br>
  <hr>

<?php

  define('ACF_CLEANER', true);
  require __DIR__ . '/db.php'

?>
</div>

<?php

  } else {

    _e('<h2>Access denied.</h2>', 'acf_cleaner');

  }

?>