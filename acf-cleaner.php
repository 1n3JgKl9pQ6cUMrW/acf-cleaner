<?php

/*
  Plugin Name: ACF Cleaner
  Plugin URI: https://github.com/1n3JgKl9pQ6cUMrW/acf-cleaner
  Description: Remove empty and orphaned ACF entries.
  Version: 1.4.1
  Author: 1n3JgKl9pQ6cUMrW
  Author URI: https://github.com/1n3JgKl9pQ6cUMrW/
*/

add_action('admin_menu', 'acf_cleaner_admin_menu');
define('ACF_CLEANER_PAGE', 'acf-cleaner/acf-cleaner-admin.php');

function acf_cleaner_admin_menu()	{

  add_management_page(__('ACF Cleaner | Manage', 'acf_cleaner'),
                      __('ACF Cleaner', 'acf_cleaner'),
                      'manage_options',
                      ACF_CLEANER_PAGE,
                      '');

}

add_filter('plugin_row_meta', 'acf_cleaner_meta_links', 10, 2);
add_filter('plugin_action_links', 'acf_cleaner_manage_link', 10, 2);

function acf_cleaner_manage_link($links, $file) {

  static $this_plugin;

    if (!$this_plugin){

      $this_plugin = plugin_basename(__FILE__);

    }

    if ($file == $this_plugin) {

      $settings_link = '<a href="tools.php?page=' . ACF_CLEANER_PAGE . '" title="' . __('Use this plugin', 'acf_cleaner') . '">' . __('Manage', 'acf_cleaner') . '</a>';
      array_unshift($links, $settings_link);

    }

    return $links;

}

function acf_cleaner_meta_links($links, $file) {

  $plugin = plugin_basename(__FILE__);

  if ($file == $plugin) {

    $links[] = '<a href="tools.php?page=' . ACF_CLEANER_PAGE . '" title="' . __('Use this plugin', 'acf_cleaner') . '">' . __('Manage', 'acf_cleaner') . '</a>';
    return $links;

  }

  return $links;

}

?>