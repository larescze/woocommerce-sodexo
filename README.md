<h1>Sodexo One</h1>
<p>Custom plugin for WooCommerce that implements Sodexo One Payment Gateway.</p>
<h2>About Sodexo</h2>
<p>Sodexo (formerly Sodexho Alliance) is a French food services and facilities management company.</p>
<p>Sodexo provides companies and public authorities with meal passes, restaurant vouchers, mobility passes, leisure passes, book cards, and training vouchers. In China and the US, it operates a stored-value card system in cooperation with multiple restaurants. Freedompay is used to power some of these deployments.</p>
<h2>Installation</h2>
<p>1. Move folder to Wordpress plugins directory</p>
<p>2. Activate plugin in WP Admin</p>
<p>3. (OPTIONAL) Modify payment gateway url with additional parameters</p>
<pre>
$gateway_url = $this->url
. '?EShopOrderId=' . $order_id
. '&BenefitsPrice=' . $this->benefit
. ':' . $total_amount;
</pre>
<p>4. Activate Sodexo One in WooCommerce setting</p>
