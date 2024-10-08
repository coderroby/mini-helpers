
function custom_product_order_form_shortcode($atts) {
    // Shortcode attributes for product IDs
    $atts = shortcode_atts(
        array(
            'product_ids' => '',
        ),
        $atts,
        'custom_product_order_form'
    );

    // Convert product IDs into an array
    $product_ids = explode(',', $atts['product_ids']);

    // Get WooCommerce products
    $products = [];
    if (!empty($product_ids)) {
        foreach ($product_ids as $product_id) {
            $product = wc_get_product(trim($product_id));
            if ($product) {
                $products[] = $product;
            }
        }
    }

    ob_start();
    ?>

    <form id="customOrderForm" class="custom-order-form">
        <!-- Product Selection -->
        <div class="product-selection">
            <h3>Select a Product</h3>
            <?php foreach ($products as $index => $product) : ?>
                <div class="product-card">
                    <label>
                    <input type="radio" name="selected_product" class="product-radio" data-product-id="<?php echo esc_attr($product->get_id()); ?>" data-product-price="<?php echo esc_attr($product->get_price()); ?>" data-product-original-price="<?php echo esc_attr($product->get_regular_price()); ?>" data-product-name="<?php echo esc_attr($product->get_name()); ?>" <?php echo $index === 0 ? 'checked' : ''; ?>>
                        <img class="custom_product_images" src="<?php echo esc_url($product->get_image_id() ? wp_get_attachment_url($product->get_image_id()) : ''); ?>" alt="<?php echo esc_attr($product->get_name()); ?>">
                        <h3><?php echo esc_html($product->get_name()); ?></h3>
                        <p class="price">Discount Price: <?php echo wc_price($product->get_sale_price()); ?></p>
                        <p class="actual-price">Original Price: <strike><?php echo wc_price($product->get_regular_price()); ?></strike></p>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="order-details">
            <div class="customer-info">
                <h3>Order Details</h3>
                <input type="text" name="customer_name" placeholder="Your Name" required>
                <input type="text" name="customer_mobile" placeholder="Mobile Number" required>
                <textarea name="customer_address" placeholder="Address" required></textarea>
            </div>
            <div class="summary">
                <div class="product-summary">
                    <h4>Selected Product:</h4>
                    <img id="selected-product-image" src="" alt="">
                    <p id="summary-product-name">Please select a product</p>
                    <p id="summary-product-price"></p>
                </div>

                <div class="shipping-options">
                    <h4>Shipping:</h4>
                    <label><input type="radio" name="shipping" value="60" class="shipping-radio" required checked> Inside Dhaka (60 TK)</label>
                    <label><input type="radio" name="shipping" value="120" class="shipping-radio"> Outside Dhaka (120 TK)</label>
                </div>

                <div class="total-amount">
                    <h4>Total Amount:</h4>
                    <p id="total-amount">0 TK</p>
                </div>

                <button type="button" id="order-now-btn" disabled>Order Now</button>
            </div>
        </div>
    </form>

    <script>
        jQuery(document).ready(function($) {
            let selectedProductPrice = 0;

            // Function to set the initial selected product
            function setInitialProductSelection() {
                const firstProductRadio = $('input[name="selected_product"]:first');
                firstProductRadio.prop('checked', true).trigger('change');
            }

            // Handle product selection
            $('input[name="selected_product"]').change(function() {
                const productName = $(this).siblings('h3').text();
                selectedProductPrice = parseFloat($(this).siblings('.price').text().replace(/[^0-9.-]+/g,""));
                $('#summary-product-name').text(productName);
                $('#summary-product-price').text('Price: ' + selectedProductPrice + ' TK');
                document.getElementById('selected-product-image').src = this.closest('.product-card').querySelector('img').src;
                updateTotal();
                $('#order-now-btn').prop('disabled', false);
            });

            // Handle shipping selection
            $('input[name="shipping"]').change(updateTotal);

            function updateTotal() {
                const shippingCost = parseFloat($('input[name="shipping"]:checked').val()) || 0;
                const total = selectedProductPrice + shippingCost;
                $('#total-amount').text(total + ' TK');
            }

            // Handle order submission
            $('#order-now-btn').on('click', function() {
                const customerName = $('input[name="customer_name"]').val();
                const customerMobile = $('input[name="customer_mobile"]').val();
                const customerAddress = $('textarea[name="customer_address"]').val();
                const selectedProductId = $('input[name="selected_product"]:checked').data('product-id');
                const selectedProductName = $('input[name="selected_product"]:checked').data('product-name');
                const selectedProductPrice = $('input[name="selected_product"]:checked').data('product-price');
                const selectedProductOriginalPrice = $('input[name="selected_product"]:checked').data('product-original-price');
                const shippingCost = $('input[name="shipping"]:checked').val();

                if (customerName && customerMobile && customerAddress && selectedProductId) {
                    const data = {
                        action: 'submit_custom_order',
                        customer_name: customerName,
                        customer_mobile: customerMobile,
                        customer_address: customerAddress,
                        product_id: selectedProductId,
                        product_name: selectedProductName,
                        product_price: selectedProductPrice,
                        product_original_price: selectedProductOriginalPrice,
                        shipping_cost: shippingCost
                    };

                    $.post('<?php echo admin_url('admin-ajax.php'); ?>', data, function(response) {
                        if (response.success) {
                            alert('Data Insrted Successfully');
                            //  window.location.href = '/';
                        } else {
                            alert('There was an error processing your order.');
                        }
                    });
                }
            });

            // Set initial product selection on page load
            setInitialProductSelection();
        });
    </script>

    <style>
        .custom-order-form { max-width: 800px; margin: auto; }
        .product-selection { display: flex; gap: 20px; margin-bottom: 20px; }
        .product-card { border: 1px solid #ddd; padding: 10px; text-align: center; flex: 1; }
        .order-details { display: flex; gap: 20px; }
        .customer-info, .summary { flex: 1; }
        .customer-info input, .customer-info textarea { width: 100%; margin-bottom: 10px; }
        .summary { border: 1px solid #ddd; padding: 10px; }
        .total-amount { font-weight: bold; margin-top: 10px; }
        button:disabled { background-color: #ccc; cursor: not-allowed; }
    </style>

    <?php
    return ob_get_clean();
}
add_shortcode('custom_product_order_form', 'custom_product_order_form_shortcode');



function submit_custom_order() {
    global $wpdb;

    // Sanitize and validate input
    $customer_name = sanitize_text_field($_POST['customer_name']);
    $customer_mobile = sanitize_text_field($_POST['customer_mobile']);
    $customer_address = sanitize_textarea_field($_POST['customer_address']);
    $product_id = intval($_POST['product_id']);
    $product_name = sanitize_text_field($_POST['product_name']);
    $product_original_price = floatval($_POST['product_original_price']);
    $product_price = floatval($_POST['product_price']);
    $shipping_cost = floatval($_POST['shipping_cost']);
    $status = 'pending'; // Default status

    // Calculate total amount (assuming you are calculating product price and shipping)
    $product = wc_get_product($product_id);
    $total_amount = $product ? $product->get_price() + $shipping_cost : 0;

    // Check if product exists
    if (!$product) {
        wp_send_json_error('Invalid product.');
    }

    // Insert the order into the custom table
    $table_name = 'custom_orders';
	$data_array = array(
		'name'                    => $customer_name,
		'mobile'                  => $customer_mobile,
		'address'                 => $customer_address,
		'product_id'              => $product_id,
		'product_name'            => $product_name,
		'product_original_price'  => $product_original_price,
		'product_price'           => $product_price,
		'shipping_cost'           => $shipping_cost,
		'total_amount'            => $total_amount,
		'status'                  => $status,
	);

	$format_array = array('%s', '%s', '%s', '%d', '%s', '%f', '%f', '%f', '%f', '%s');

	$inserted = $wpdb->insert(
		$table_name,
		$data_array,
		$format_array
	);

    if ($inserted) {
        // Success response
        print_r($data_array);
        wp_send_json_success('Order inserted successfully.');
    } else {
        // Failed insertion response
        wp_send_json_error('Failed to insert order.');
    }
}

add_action('wp_ajax_submit_custom_order', 'submit_custom_order');
add_action('wp_ajax_nopriv_submit_custom_order', 'submit_custom_order');