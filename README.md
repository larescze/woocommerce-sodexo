<h1>Sodexo One</h1>
<p>Custom plugin for WooCommerce that implements Sodexo One Payment Gateway.</p>
<h2>About Sodexo</h2>
<p>Sodexo (formerly Sodexho Alliance) is a French food services and facilities management company.</p>
<p>Sodexo provides companies and public authorities with meal passes, restaurant vouchers, mobility passes, leisure passes, book cards, and training vouchers. In China and the US, it operates a stored-value card system in cooperation with multiple restaurants. Freedompay is used to power some of these deployments.</p>
<h2>Installation</h2>
<p>1. Move folder to Wordpress plugins directory</p>
<p>2. Activate plugin in WP Admin</p>
<p>3. Change process URL to production or testing URL</p>
<p>4. (OPTIONAL) Add custom parameters</p>
<p>5. Activate Sodexo One in WooCommerce setting</p>
<pre>
public function process_payment($order_id)
{
	global $woocommerce;
	$order = new WC_Order($order_id);
	$order_id  = $order->get_id();
    $process_url = 'https://brana.sodexo-ucet.cz/?EShopOrderId=';

    $total_amount = $woocommerce->cart->cart_contents_total + $woocommerce->cart->tax_total;

    return array(
    	'result'   => 'success',
    	'redirect' =>  $process_url . $order_id . '&BenefitsPrice=' . $this->benefit . ':' . $total_amount
    );

}

</pre>
