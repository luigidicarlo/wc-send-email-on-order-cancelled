<?php

/*
 * Plugin Name: WooCommerce Send Email On Order Cancelled
 * Plugin URI: http://luigidicarlo.com
 * Description: Sends email to customer whenever an order is cancelled.
 * Author: Luis E. Huerta (luigidicarlo)
 * Version: 1.0
 * Author URI: http://luigidicarlo.com
 * Text Domain: codework_send_cancelled_order_email_to_customer
 * Domain Path: /languages
 * License: GNU
*/
defined( 'ABSPATH' ) or die( '<strong>Permission denied</strong>' );
function codework_send_cancelled_order_email_to_customer() {
    load_plugin_textdomain( 'codework_send_cancelled_order_email_to_customer', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'codework_send_cancelled_order_email_to_customer' );

function codework_send_email( $order_id, $old_status, $new_status, $order ){
    if ( $new_status == 'cancelled' ){
        $wc_emails = WC()->mailer()->get_emails();
        $client_email = $order->get_billing_email();
        $kind = 'WC_Email_Cancelled_Order';

        $wc_emails[$kind]->recipient = $client_email;
        $wc_emails[$kind]->trigger($order_id);
    }
}
add_action('woocommerce_order_status_changed', 'codework_send_email', 10, 4 );

?>