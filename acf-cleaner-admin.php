<?php

/* Exit if accessed directly */

if ( ! defined( 'ABSPATH' ) ) {

  exit;

}

$acf_ajax = strpos($_SERVER['HTTP_ACCEPT'], 'application') !== false?'false':'true';
$acf_clean_1 = false;
$acf_clean_2 = false;
$acf_filter = 0;
$acf_prefix = 'ACF__';
$acf_db_prefix = 'wp_';

  if ($acf_ajax == 'true') {

    _e('<h2>Access denied.</h2>', 'acf_cleaner');

  } else if(is_user_logged_in() && is_admin()) {

?>

<div class="wrap">
  <h2><?php _e('ACF Cleaner', 'acf_cleaner'); ?></h2>

<?php

/* Allow custom prefixes for ACF names */

if (isset($_COOKIE['acf_prefix'])) {

    if (!empty($_COOKIE['acf_prefix']) && strlen($_COOKIE['acf_prefix']) > 2) {

      $acf_prefix = $_COOKIE['acf_prefix'];

    }

}

/* Allow custom prefixes for wp-database-tables */

if (isset($_COOKIE['acf_db_prefix'])) {

    if (!empty($_COOKIE['acf_db_prefix']) && strlen($_COOKIE['acf_db_prefix']) > 1) {

      $acf_db_prefix = $_COOKIE['acf_db_prefix'];

    }

}

/* Check or clean the database */

  if (isset($_POST['acf_clean'])) {

    if ($_POST['acf_clean'] === 'clean') {

      $acf_filter = $_POST['acf_filter'];

      switch ($acf_filter) {

        case '1':

          $acf_clean_1 = true;

        break;

        case '2':

          $acf_clean_2 = true;

        break;

        case '3':

          $acf_clean_1 = true;
          $acf_clean_2 = true;

        break;

        default:

          // 2DO

      }

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
      <?php printf( __('Before you do any cleaning <a href="%1$s" target="%2$s" title="view plug-in (external)">backup</a> your database first.<br>This tool only proceeds (ACF) fieldnames with a consistent prefix, like <code>ACF__</code> (case-insensitive).<br><b>Notice :</b> when restoring ACF-entries from trash, <i>false positives</i> can show up as orphans; (re-) save all pages (containing those entries) before cleaning.', 'acf_cleaner'), 'https://wordpress.org/plugins/wp-dbmanager/', '_blank'); ?>
    </p>
  </div>

<?php

  }

?>

  <script>

/* Save alternative prefixes as a cookie (don't mesh the database...) */

    function acf_prefix_save() {

      try {

        document.cookie = "acf_prefix=" + document.getElementById("acf_prefix").value + ";";
        document.cookie = "acf_db_prefix=" + document.getElementById("acf_db_prefix").value + ";";

      } catch (error) {

        alert(error.message);

      }

    }

  </script>

  <form method="post" action="#" onsubmit="acf_prefix_save();">

    <table class="form-table">

      <tr valign="top">
      <th scope="row"><?php _e('What to clean :', 'acf_cleaner'); ?></th>
      <td>
        <select style="min-width:160px;" name="acf_filter" id="acf_filter">
          <option value="3"<?php if ($acf_filter == '3' || $acf_filter == '0') { echo ' selected'; } ?>><?php _e('Clean all', 'acf_cleaner'); ?></option>
          <option value="1"<?php if ($acf_filter == '1') { echo ' selected'; } ?>><?php _e('Orphans only', 'acf_cleaner'); ?></option>
          <option value="2"<?php if ($acf_filter == '2') { echo ' selected'; } ?>><?php _e('Empty only', 'acf_cleaner'); ?></option>
        </select>
      </td>
      </tr>

      <tr valign="top">
      <th scope="row"><?php _e('Database-table prefix :', 'acf_cleaner'); ?></th>
      <td><input type="text" name="acf_db_prefix" id="acf_db_prefix" value="<?php echo $acf_db_prefix; ?>" placeholder="wp_" style="min-width:160px;"></td>
      </tr>

      <tr valign="top">
      <th scope="row"><?php _e('Field prefix (at least 3 chrs.) :', 'acf_cleaner'); ?></th>
      <td><input type="text" name="acf_prefix" id="acf_prefix" value="<?php echo $acf_prefix; ?>" placeholder="ACF__" style="min-width:160px;"></td>
      </tr>

      <tr valign="top">
      <th scope="row"><?php printf( __('Type <code>%1$s</code> before submit :', 'acf_cleaner'), 'clean'); ?></th>
      <td><input type="text" name="acf_clean" value="" placeholder="..." style="min-width:160px;"></td>
      </tr>

    </table>

    <p>
      <button data-action="acf-clean" class="button button-primary" type="submit"><?php _e('ACF <b>clean</b>', 'acf_cleaner'); ?></button>
      <button data-action="acf-check" class="button button-secondary" type="button" onclick="acf_prefix_save();location.href=location.href;"><?php _e('ACF <b>check</b>', 'acf_cleaner'); ?></button>
    </p>

  </form>

  <br>
  <hr>

<?php

  define('ACF_CLEANER', true);
  require __DIR__ . '/acf-cleaner-queries.php'

?>
</div>

<?php

  } else {

    _e('<h2>Access denied.</h2>', 'acf_cleaner');

  }

?>