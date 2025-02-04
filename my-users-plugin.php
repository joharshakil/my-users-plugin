<?php
/*
Plugin Name: My Users Plugin
Description: Displays users in a custom table using data from a third-party API.
Version: 1.0
Author: JOHAR SHAKIL
*/

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Autoload dependencies via Composer.
require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

// Include necessary files.
require_once plugin_dir_path(__FILE__) . 'includes/class-user-data-handler.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-user-table-renderer.php';

class MyUsersPlugin {
    public function __construct() {
       register_activation_hook(__FILE__, [$this, 'flush_rewrite_rules']);
       register_deactivation_hook(__FILE__, [$this, 'flush_rewrite_rules']);
       add_action('init', [$this, 'add_custom_endpoint']);
       add_action('template_redirect', [$this, 'handle_custom_endpoint']);
       add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
       add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
       add_action('wp_ajax_fetch_user_details', [$this, 'fetch_user_details']);
       add_action('wp_ajax_nopriv_fetch_user_details', [$this, 'fetch_user_details']);
    }

    public function add_custom_endpoint() {
        add_rewrite_rule('^my-lovely-users-table/?$', 'index.php?my_lovely_users_table=1', 'top');
        add_rewrite_tag('%my_lovely_users_table%', '1');
    }

    public function handle_custom_endpoint() {
      if (get_query_var('my_lovely_users_table', false)) {
        $renderer = new UserTableRenderer();
        echo $renderer->render(); // Output the HTML table.
        exit; // Ensure no other content is appended.
      }
    }

    public function enqueue_scripts() {
      if (is_page('my-users-table') || is_admin()) { 
        wp_enqueue_style('my-users-style', plugin_dir_url(__FILE__) . 'assets/style.css', [], '1.0');
        wp_enqueue_script('my-users-script', plugin_dir_url(__FILE__) . 'assets/script.js', ['jquery'], '1.0', true);
        wp_localize_script('my-users-script', 'MyUsersPlugin', [
            'ajax_url' => admin_url('admin-ajax.php'),
        ]);
    }
    }

    public function fetch_user_details() {

        if (!isset($_POST['user_id'])) {
            wp_send_json_error('Invalid request.');
        }
        $user_id = sanitize_text_field($_POST['user_id']);
        $handler = new UserDataHandler();
        $details = $handler->fetch_user_details($user_id);
        wp_send_json_success($details);
    }
    public function flush_rewrite_rules() {
    $this->add_custom_endpoint();
    flush_rewrite_rules();
 }
}

// Initialize the plugin.
if (class_exists('MyUsersPlugin')) {
    // The class exists, so you can use it.
    new MyUsersPlugin();
} else {
    // The class does not exist, handle accordingly.
    error_log('MyUsersPluginClass is missing.');
}

add_action('admin_menu', function() {
    add_menu_page(
        'My Users Plugin', 
        'My Users Plugin', 
        'manage_options', 
        'my-users-table', 
        function() {
            $renderer = new UserTableRenderer();
            echo '<div class="user-listing-container wrap"><h2>Users List</h2>' . $renderer->render() . '</div>';
        }, 
        'dashicons-admin-users', 
        25
    );
});
