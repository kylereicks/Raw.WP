<?php
if(!class_exists('Raw_WP')){
  class Raw_WP{

    // Setup singleton pattern
    public static function get_instance(){
      static $instance;

      if(null === $instance){
        $instance = new self();
      }

      return $instance;
    }

    private function __clone(){
      return null;
    }

    private function __wakeup(){
      return null;
    }

    public static function deactivate(){
      self::clear_options();
    }

    private static function clear_options(){
      global $wpdb;
      $options = $wpdb->get_col('SELECT option_name FROM ' . $wpdb->options . ' WHERE option_name LIKE \'%raw_wp%\'');
      foreach($options as $option){
        delete_option($option);
      }
    }

    // Constructor, add actions and filters
    private function __construct(){
      add_action('init', array($this, 'add_update_hook'));
      add_filter('media_upload_tabs', array($this, 'register_raw_wp_tab'));
      add_action('media_upload_raw_wp', array($this, 'raw_wp_tab_view'));
    }

    public function register_raw_wp_tab($tabs){
      $raw_tab = array('raw_wp' => 'Raw');
      return array_merge($tabs, $raw_tab);
    }

    public function raw_wp_tab_view(){
      $app_url = 'http://app.raw.densitydesign.org/';
      header('Location: ' . $app_url);
      die();
    }

    public function add_update_hook(){
      if(get_option('raw_wp_version') !== RAW_WP_VERSION){
        update_option('raw_wp_update_timestamp', time());
        update_option('raw_wp_version', RAW_WP_VERSION);
        do_action('raw_wp_updated');
      }
    }

  }
}
