<?php

/*
  Plugin Name: Simple Admin Posts
  Plugin URI: http://viniwp.wordpress.com
  Description: Plugin para gerenciar as postagens(visualização/deleção) de seu blog de forma facil
  Version: 1
  Author: viniciusgomes
  Author URI: http://viniwp.wordpress.com
 */
ini_set('display_errors', '0');
ini_set('error_reporting', ~E_ALL);

function simple_admin_posts_activate() {
    global $wpdb;
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}simple_admin_posts(
  ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  post_author bigint(20) unsigned NOT NULL DEFAULT '0',
  post_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  post_date_gmt datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  post_content longtext NOT NULL,
  post_title text NOT NULL,
  post_excerpt text NOT NULL,
  post_status varchar(20) NOT NULL DEFAULT 'publish',
  comment_status varchar(20) NOT NULL DEFAULT 'open',
  ping_status varchar(20) NOT NULL DEFAULT 'open',
  post_password varchar(20) NOT NULL DEFAULT '',
  post_name varchar(200) NOT NULL DEFAULT '',
  to_ping text NOT NULL,
  pinged text NOT NULL,
  post_modified datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  post_modified_gmt datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  post_content_filtered text NOT NULL,
  post_parent bigint(20) unsigned NOT NULL DEFAULT '0',
  guid varchar(255) NOT NULL DEFAULT '',
  menu_order int(11) NOT NULL DEFAULT '0',
  post_type varchar(20) NOT NULL DEFAULT 'post',
  post_mime_type varchar(100) NOT NULL DEFAULT '',
  comment_count bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (ID));");
}
function simple_admin_posts_desactivate() {
    global $wpdb;
//    $wpdb->query("DROP database {$wpdb->prefix}x");
}

function simple_admin_posts_menu() {
    if (function_exists("add_menu_page")) {
        add_menu_page("Manage Posts", "Posts", 10, "simpleAdminPosts/posts.php");
    }
}

register_activation_hook(__FILE__, "simple_admin_posts_activate");
register_deactivation_hook(__FILE__, "simple_admin_posts_desactivate");
add_action("admin_menu", "simple_admin_posts_menu");
?>
