<?php
/*
Plugin Name: wp-konami
Plugin URI: http://blog.fusi0n.org/category/wp-konami
Description: Add the Konami Code to your WordPress blog and redirect to a custom URL on successful input sequence
Version: 1.3.1
Author: Pier-Luc Petitclerc
Author URI: http://blog.fusi0n.org
Text Domain: wp-konami
*/

class WP_konami {

  /**
   * @var array WP-Konami Options
   * @access private
   * @since 1.1
  */
  private $opts = array('wpk_index'   => array('default' => 1,
                                               'name'    => 'Hook index',
                                               'desc'    => 'Only watch for Konami Code inputs on the blog\'s home page'),
                        'wpk_url'     => array('defaults'=> 'http://blog.fusi0n.org',
                                               'name'    => 'Landing URL',
                                               'desc'    => 'URL you want your visitors to be redirected to when successfully entering the Konami Code'),
                        'wpk_replace' => array('defaults'=> 0,
                                               'name'    => 'Replace bundled jQuery',
                                               'desc'    => 'Replace WordPress\' bundled jQuery with the one included with the plugin'),
                       );
  /**
   * PHP5 Class Constructor
   * Sets default options, add filters and options page.
   * @author Pier-Luc Petitclerc <pL@fusi0n.org>
   * @param null
   * @return void
   * @since 1.0
  */
  public function __construct() {
    foreach ($this->opts as $k=>$v) { $this->opts[$k]['current'] = get_option($k); }
    if (!is_admin()) {
      if (get_option('wpk_replace') == 1) {
        $wpurl = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__), '', plugin_basename(__FILE__));
        // jQuery - removing to make sure we're using 1.3.2
        wp_deregister_script('jquery');
        wp_register_script('jquery', $wpurl.'/js/jquery-1.4.2.min.js', false, '1.3.2');
        wp_enqueue_script('jquery');
      }
    }
    else { add_action('admin_init', array(&$this, 'wpk_section_register')); }

    if ((get_option('wpk_index') == 1) && (is_home())) { add_action('wp_head', array(&$this, 'wpk_head')); }
    else { add_action('wp_head', array(&$this, 'wpk_head')); }
  }

  /**
   * Overload hack
   * @param string $name Function name
   * @param mixed $args Arguments
   * @return null
   * @access public
   * @author Pier-Luc Petitclerc <pL@fusi0n.org>
   * @since 1.1
  */
  public function __call($name, $args) {
    if (!function_exists($name) || !method_exists($this, $name)) {
      if (substr($name, 0, 13) == 'wpk_settings_') {
        $setting = str_replace('wpk_settings_', '', $name);
        $this->wpk_settings($setting);
      }
    }
  }

  /** Plugin activation hook used to set default option values
   * @param null
   * @return void
   * @since 1.1
   * @author Pier-Luc Petitclerc <pL@fusi0n.org>
   * @access public
  */
  public function wpk_activation_hook() {
    foreach ($this->opts as $k=>$v) {
			if (get_option($k) == false) { update_option($k, $this->opts[$k]['default']); }
    }
  }

  /**
   * Adds the plugin's option page in the 'Settings' menu of the Admin
   * @param null
   * @return void
   * @author Rupert Morris
   * @since 1.0
  */
  function wpk_section_register() {
    add_settings_section('wp-konami', 'WP-Konami Options', array(&$this, 'wpk_section_callback'), 'misc');
    foreach ($this->opts as $optName => &$optVal) {
      register_setting('konami', $optName);
      add_settings_field($optName, $optVal['name'], array(&$this, 'wpk_settings_'.$optName), 'misc', 'wp-konami');
    }
  }

  /**
   * Outputs settings for the settings page
   * I *really* don't like to output directly from a function but apparently there's no other way
   * I'll use include, but it sure as hell ain't prettier. Don't hold it against me.
   * @param null
   * @return void
   * @since 1.1
   * @author Pier-Luc Petitclerc <pL@fusi0n.org>
  */
  public function wpk_settings($opt) {
    $v = $this->opts[$opt];
    switch ($opt) {
      case 'wpk_index':
      case 'wpk_replace':
        $checked = $v['current'] == 1? ' checked="checked"' : '';
        echo '<input type="checkbox" value="1" name="'.$opt.'"'.$checked.' /> <label for="'.$opt.'">'.$v['desc'].'</label>';
        break;
      case 'wpk_url':
        echo '<input type="text" value="'.$v['current'].'" name="'.$opt.'"> <label for="'.$opt.'">'.$v['desc'].'</label>';
        break;
    }
    if ($opt == 'wpk_replace') { settings_fields('konami'); }
    echo "<br />\n";
  }

  /**
   * Adds Konami Code in the page that is being viewed
   * @param null
   * @return void
   * @author Pier-Luc Petitclerc <pL@fusi0n.org>
   * @example add_action('wp_head', 'wpk_head');
   * @since 1.0
  */
  function wpk_head() {
    $output = <<<EOHTML

      <script type="text/javascript" charset="utf-8">
        if ( window.addEventListener ) {
          var kkeys = [], konami = "38,38,40,40,37,39,37,39,66,65";
          window.addEventListener("keydown", function(e){
            kkeys.push( e.keyCode );
            if ( kkeys.toString().indexOf( konami ) >= 0 )
              window.location = "{$this->opts['wpk_url']['current']}";
          }, true);
        }
      </script>
EOHTML;
    echo $output;
  }
}
$wpk = new WP_konami();
register_activation_hook(__FILE__, array(&$wpk, 'wpk_activation_hook'));