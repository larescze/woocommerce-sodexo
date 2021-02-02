<?php
/*
 * Plugin Name: WooCommerce Sodexo One Payment Gateway
 * Plugin URI: https://www.willilazarov.cz/
 * Description: Implementation of Sodexo One Payment Gateway for WooCommerce
 * Author: Willi Lazarov
 * Author URI: https://www.willilazarov.cz/
 * Version: 1.1
 *
 * /

 /*
 * This action hook registers PHP class as a WooCommerce payment gateway
 */
add_filter('woocommerce_payment_gateways', 'sodexo_add_gateway_class');
function sodexo_add_gateway_class($gateways)
{
    $gateways[] = 'WC_Sodexo_Gateway';
    return $gateways;
}

/*
 * The class itself, please note that it is inside plugins_loaded action hook
 */
add_action('plugins_loaded', 'sodexo_init_gateway_class');

function sodexo_init_gateway_class()
{

    class WC_Sodexo_Gateway extends WC_Payment_Gateway
    {

        /**
         * Class constructor
         */
        public function __construct()
        {

            $this->id = 'sodexo'; // Payment gateway plugin ID
            $this->icon = plugin_dir_url(__FILE__) . 'sodexo.jpg'; // URL of the icon that will be displayed on checkout page near your gateway name
            $this->has_fields = true; // Custom form
            $this->method_title = 'Sodexo One'; // Payment gateway name
            $this->method_description = 'Payment gateway Sodexo One.'; // Payment gateway description
            // Supported WooCommerce payment by payment gateway
            $this->supports = array(
                'products'
            );

            // SEttings options fields
            $this->init_form_fields();

            // Load the settings.
            $this->init_settings();
            $this->title = $this->get_option('title');
            $this->description = $this->get_option('description');
            $this->url = $this->get_option('url');
            $this->benefit = $this->get_option('benefit');
            $this->enabled = $this->get_option('enabled');

            add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
        }

        /**
         * Plugin options
         */
        public function init_form_fields()
        {

            $this->form_fields = array(
                'enabled' => array(
                    'title' => __('Activate/Deactivate', 'woocommerce'),
                    'type' => 'checkbox',
                    'label' => __('Activate payment gateway in checkout page', 'woocommerce'),
                    'default' => 'yes'
                ),
                'title' => array(
                    'title' => __('Title', 'woocommerce'),
                    'type' => 'text',
                    'description' => __('Title of payment gateway', 'woocommerce'),
                    'default' => __('Sodexo', 'woocommerce'),
                    'desc_tip'      => true,
                ),
                'url' => array(
                    'title' => __('Sodexo payment gateway URL', 'woocommerce'),
                    'type' => 'text',
                    'description' => __('Sodexo URL', 'woocommerce'),
                    'default' => __('', 'woocommerce'),
                    'desc_tip'      => true,
                ),
                'benefit' => array(
                    'title' => __('ID Benefitu', 'woocommerce'),
                    'type' => 'text',
                    'description' => __('Benefit ID', 'woocommerce'),
                    'default' => __('', 'woocommerce'),
                    'desc_tip'      => true,
                ),
            );
        }

        /*
		 * Payments process called after clicked on pay button
		 */
        public function process_payment($order_id)
        {
            global $woocommerce;
            // WooCommerce order object
            $order = new WC_Order($order_id);
            $order_id  = $order->get_id();

            $total_amount = $woocommerce->cart->cart_contents_total + $woocommerce->cart->tax_total;
            // Prepare payment gateway address to complete the order
            $gateway_url = $this->url . '?EShopOrderId=' . $order_id . '&BenefitsPrice=' . $this->benefit . ':' . $total_amount;

            return array(
                'result'   => 'success',
                'redirect' =>  $gateway_url,
            );
        }
    }
}
