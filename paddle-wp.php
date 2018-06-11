<?php
/*
Plugin name: Paddle WP
Description: A plugin to enable the Paddle checkout on a WordPress site.
Author: Ed Long
Author URI: https://paddle.com
Version: 0.1
*/


// Load menu in dashboard
add_action( 'admin_menu', 'paddle_settings_menu' );

// Add Paddle submenu
if( ! function_exists( "paddle_settings_menu" ) )
{

    function paddle_settings_menu()
    {
        $page_title = 'Paddle';
        $menu_title = 'Paddle';
        $capability = 'manage_options';
        $menu_slug  = 'paddle-wp';
        $function   = 'paddle_settings_page';
        add_submenu_page( 'options-general.php',
                          $page_title,
                          $menu_title, 
                          $capability, 
                          $menu_slug, 
                          $function );

        // Update database settings on save
        add_action( 'admin_init', 'update_paddle_settings' );
    }
}

// Settings update function
if( !function_exists( "update_paddle_settings" ) ) {
    function update_paddle_settings()
    {
        register_setting( 'paddle-settings', 'paddle_vendor_id' );
        register_setting( 'paddle-settings', 'paddle_selector' );
    }
}

// Admin page content
if( !function_exists( "paddle_settings_page" ) )
{
    function paddle_settings_page()
    {
        ?>

            <h1>Paddle vendor settings</h1>
            <form method="post" action="options.php">

                <?php settings_fields( 'paddle-settings' ); ?>
                <?php do_settings_sections( 'paddle-settings' ); ?>

                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Vendor ID</th>
                        <td><input type="text" name="paddle_vendor_id" value="<?php echo get_option( 'paddle_vendor_id' ); ?>"/></td>
                        <td>Find your vendor ID in your Paddle dashboard</td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Custom selector</th>
                        <td><input type="text" name="paddle_selector" value="<?php echo get_option( 'paddle_selector' ); ?>"/></td>
                        <td>Specify a custom selector to trigger the Paddle checkout when clicked. (Default is <code>.buy-button</code>).</td>
                    </tr>
                </table>

                <?php submit_button(); ?>

            </form>

            <h2>Adding a checkout button to your page</h2>
            <p>To add a standard Paddle-styled button to your page, use the following code, replacing <code>12345</code> with the ID of the product you are selling:</p>
            <code>&lt;a href=&quot;#!&quot; class=&quot;paddle_button&quot; data-product=&quot;12345&quot;&gt;Buy Now!&lt;/a&gt;</code>
            <p>To add an unstyled button to your page, you can use:</p>
            <code>&lt;a href=&quot;#!&quot; class=&quot;buy-button&quot; data-product=&quot;12345&quot;&gt;Buy Now!&lt;/a&gt;</code>
            <p>You may also use a different <code>class</code> or <code>id</code> attribute and update the value of the custom selector above.</p>
            <h2>Specifying checkout properties</h2>
            <p>For either of the two above examples, you can specify additional checkout properties by adding data attributes to the tag. For example, to set the quantity of the checkout to 5 you can specify <code>data-quantity="5"</code>.</p>
            <p>See the <a href="https://paddle.com/docs/paddlejs-buttons-checkout#checkout-properties">Paddle documentation</a> for a full list of the configurable checkout properties.</p>

        <?php
    }
}

// Import Paddle.js library and setup script into footer
if( !function_exists("enqueue_paddle_scripts") ) {
    function enqueue_paddle_scripts()
    {
        // Paddle.js library
        wp_register_script( 'paddle-js', 'https://cdn.paddle.com/paddle/paddle.js', null, null, true );
        // Paddle setup and checkout opening code
        wp_register_script( 'paddle-setup', plugins_url('/js/paddle-setup.js', __FILE__), array( 'jquery' ), null, true );
        $paddle_settings_data = array(
            'vendor_id' => get_option( 'paddle_vendor_id '),
            'selector'  => get_option( 'paddle_selector '),
        );
        // Pass settings into JS via CDATA
        wp_localize_script( 'paddle-setup', 'paddle_settings_data', $paddle_settings_data );
        // Enqueue the scripts:
        wp_enqueue_script( 'paddle-js' );
        wp_enqueue_script( 'paddle-setup' );
    }
}

add_action( 'wp_enqueue_scripts', 'enqueue_paddle_scripts' );

?>
