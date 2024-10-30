<?php 
/**
 * Plugin Name:      Contact Me Icon
 * Plugin URI:        https://maxweb.co
 * Description:       Contact Me Icon adds a WhatsApp icon to your website that make it easy for customers to contact you.
 * Version:           1.0.0
 * Requires at least: 5.6
 * Author:            Max-Web
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       contact-me-icon
 */

 /**
 * Register a custom menu page.
 */
function contact_me_icon_admin_menu(){
    add_menu_page( 
        __( 'Contact Me Icon', 'contact-me-icon' ),
        'Contact Me Icon',
        'manage_options',
        'contact-me-icon',
        'contact_me_icon_callback',
        'dashicons-whatsapp',
        6
    ); 
}
add_action( 'admin_menu', 'contact_me_icon_admin_menu' );
 
/**
 * Display a custom menu page
 */
function contact_me_icon_callback(){
    
    wp_enqueue_style( 'materializecss', 'https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css' );
    wp_enqueue_style( 'materialize_icons', 'https://fonts.googleapis.com/icon?family=Material+Icons' );
    wp_enqueue_script( 'materializejs', 'https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js' );

    ?>

    <div class="container" style="background-color: #fff; padding:50px; margin-top: 7%;">
        <div class="row">

            <h6>Thank You for Downloading <strong>Contact Me Icon</strong></h6>
            <p>Please enter your WhatsApp number below and click the save settings button.</p>

            <div class="col12">
            <form action="admin.php?page=contact-me-icon" method="POST">
                <div class="input-field">
                    <input type="text" name="contact_me_icon_whatsapp" id="contact_me_icon_whatsapp" placeholder="WhatsApp Number" value="<?php if( !empty(get_option('contact_me_icon_whatsapp')) ) { echo get_option('contact_me_icon_whatsapp'); } ?>" required>
                    <button class="btn light-blue accent-2" type="submit" name="submitwhatsapp"> Save Settings
                    <i class="material-icons right">send</i>
                    </button>
                </div>
            </form>

            <button class="btn yellow accent-3">
            <i class="material-icons" style="color:#000;">star_border</i>
            </button> <a href="https://wordpress.org/plugins/contact-me-icon/#reviews" style="font-size: 15px;color:#000;" target="_blank">Please leave a review if you like the plugin!</a>

            </div>

        </div>
    </div>

    <?php 

    if( isset($_POST['submitwhatsapp']) && isset($_POST['contact_me_icon_whatsapp']) && !empty($_POST['contact_me_icon_whatsapp'])  ) {
        update_option( 'contact_me_icon_whatsapp', $_POST['contact_me_icon_whatsapp'] );
        ?>
        <script>
        jQuery(document).ready(function() {
            window.location.reload();
        });
        </script>
        <?php 
    }

}

// Enqueue Stylesheet
add_action( 'wp_enqueue_scripts', function() {

    wp_enqueue_style( 'maxcdn', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', array(), '4.5.0' );
    wp_enqueue_style( 'style', plugins_url('style.css', __FILE__) );

} );

// Show WhatsApp Icon frontend

add_action( 'wp_head', function() {

    if( is_front_page() ) {

        ?>
        <a href="https://api.whatsapp.com/send?phone=<?php echo get_option('contact_me_icon_whatsapp'); ?>" class="float" target="_blank">
        <div class="spinning-border">
            <i class="fa fa-whatsapp my-float"></i>
        </div>
        </a>
        <?php 

    }

} );

// Plugin Settings Link

add_filter( 'plugin_action_links', 'contactmeiconWidgetSettings', 10, 5 );
 
function contactmeiconWidgetSettings( $actions, $plugin_file ) 
{
   static $plugin;
 
   if (!isset($plugin))
        $plugin = plugin_basename(__FILE__);
   if ($plugin == $plugin_file) {
 
      $settings = array('settings' => '<a style="color: #6495ED;font-weight:700;" href="admin.php?page=contact-me-icon">' . __('Settings', 'General') . '</a>');
      $site_link = array('support' => '<a style="color: #DE3163;font-weight:700;" href="mailto:support@maxweb.co" target="_blank">Support</a>');
         
      $actions = array_merge($settings, $actions);
      $actions = array_merge($site_link, $actions);
   }
     
   return $actions;
}