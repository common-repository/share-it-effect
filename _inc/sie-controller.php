<?php
if( !function_exists('ajax_sie_get_popup_content') ){
    function ajax_sie_get_popup_content() {
        global $wpdb;
        
        $discount = get_option('_sie_discount_amt');
        $type = get_option('_sie_discount_type');
        $hashtag = get_option('_sie_hashtag');
        $m_content = get_option('_sie_marketing_content');
        $product = wc_get_product( $_POST['prod_id'] );
        $permalink = $product->get_permalink();

        $year = date('Y');
        $month_numeric = date('m'); // 01-12        
        $shared = $wpdb->get_results("SELECT ID, post_title FROM $wpdb->posts WHERE post_status = 'private' AND post_type = 'sie_shared_product' AND MONTH(post_date)= '".$month_numeric."' AND YEAR(post_date) = '".$year."' ORDER BY post_date ASC");

        $response = array(
            'action'        => 'set details',
            'discount'      => intval( $discount ),
            'type'          => esc_html( $type ),
            'hashtag'       => esc_html( $hashtag ),
            'm_content'     => esc_html( $m_content),
            'pid'           => intval( $_POST['prod_id'] ),
            'url'           => esc_url( $permalink ),
            'domain'        => esc_url( get_site_url() ),
            'product'       => esc_html( $product ),
            'count'         => intval( count($shared) )
        );
        
       echo json_encode($response);
       
       die();
    }
    add_action('wp_ajax_sie_get_popup_content', 'ajax_sie_get_popup_content');
    add_action('wp_ajax_nopriv_sie_get_popup_content', 'ajax_sie_get_popup_content');
}

if( !function_exists('ajax_sie_save_settings') ){
    function ajax_sie_save_settings() {
        if( get_option('_sie_discount_amt') || get_option('_sie_discount_type') || get_option('_sie_hashtag') || get_option('_sie_marketing_content')   )
        {
            update_option( '_sie_discount_amt' , sanitize_text_field(  $_POST['discount_amt'] ) );
            update_option( '_sie_discount_type' , sanitize_text_field( $_POST['discount_type'] ) );
            update_option( '_sie_hashtag' , sanitize_text_field(  $_POST['hashtag'] ) );
            update_option( '_sie_marketing_content' , sanitize_textarea_field( $_POST['marketing_content'] ) );
            //update_option( '_sie_append_to' , sanitize_text_field(  $_POST['append_to'] ) );
            //update_option( '_sie_field_element' , sanitize_textarea_field( $_POST['field_element'] ) );
            //add_option( '_sie_append_to' , sanitize_text_field(  $_POST['append_to'] ) );
            //add_option( '_sie_field_element' , sanitize_textarea_field( $_POST['field_element'] ) );
        }
        else
        {   
            add_option( '_sie_discount_amt' , sanitize_text_field( $_POST['discount_amt'] ) );
            add_option( '_sie_discount_type' , sanitize_text_field( $_POST['discount_type'] ) );
            add_option( '_sie_hashtag' , sanitize_text_field( $_POST['hashtag'] ) );
            add_option( '_sie_marketing_content' , sanitize_textarea_field( $_POST['marketing_content'] ) );
            //add_option( '_sie_append_to' , sanitize_text_field(  $_POST['append_to'] ) );
            //add_option( '_sie_field_element' , sanitize_textarea_field( $_POST['field_element'] ) );
        }

       die();
    }
    add_action('wp_ajax_sie_save_settings', 'ajax_sie_save_settings');
    add_action('wp_ajax_nopriv_sie_save_settings', 'ajax_sie_save_settings');
}

if( !function_exists('ajax_sie_get_badge_content') ){
    function ajax_sie_get_badge_content() {
        $year = date('Y');
        $month_numeric = date('m'); // 01-12        
        $shared = $wpdb->get_results("SELECT ID, post_title FROM $wpdb->posts WHERE post_status = 'private' AND post_type = 'sie_shared_product' AND MONTH(post_date)= '".$month_numeric."' AND YEAR(post_date) = '".$year."' ORDER BY post_date ASC");

        $discount_type = get_option('_sie_discount_type');
        $append_to = get_option('_sie_discount_type');
        if( $discount_type == "%"){
            $discount = get_option('_sie_discount_amt') . "%";
        }else{
            $discount = "$" . get_option('_sie_discount_amt');
        }

        if( $append_to == 'id'){
            $element = "#" . get_option('_sie_field_element');;
        }else{
            $element = str_replace("  ",".",get_option('_sie_field_element'));
            $element = str_replace(" ",".", $element);

        }

        $response = array(            
            'discount'      => esc_html( $discount ),
            'field'         => '.' . esc_html($element),
            'count'         => intval( count($shared) )
        );

        echo json_encode($response);

        die();
    }
    add_action('wp_ajax_sie_get_badge_content', 'ajax_sie_get_badge_content');
    add_action('wp_ajax_nopriv_sie_get_badge_content', 'ajax_sie_get_badge_content');
}

if( !function_exists('ajax_sie_send_coupon') ){
    function ajax_sie_send_coupon() {
        /**
        * Create a coupon programatically
        */
        if( get_option( '_sie_number_of_shares' ) )
            update_option( '_sie_number_of_shares',  get_option('_sie_number_of_shares') + 1 );
        else
            add_option( '_sie_number_of_shares', 1 );

        $amt = get_option('_sie_discount_amt');
        $type = get_option('_sie_discount_type');

        $coupon_code = strtolower( generateCode(11) ); // Code
        $amount = $amt; // Amount
        if( $type == '%' ){
            $discount = $amt . $type;
            $discount_type = 'percent'; // Type: fixed_cart, percent, fixed_product, percent_product
        }
        else{
            $discount = $type . $amt;
            $discount_type = 'fixed_cart'; // Type: fixed_cart, percent, fixed_product, percent_product
        }

        $coupon = array(
            'post_title' => $coupon_code,
            'post_content' => '',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type' => 'shop_coupon');

        $new_coupon_id = wp_insert_post( $coupon );

        // Add meta
        update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
        update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
        update_post_meta( $new_coupon_id, 'individual_use', 'no' );
        update_post_meta( $new_coupon_id, 'product_ids', '' );
        update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
        update_post_meta( $new_coupon_id, 'usage_limit', '1' );
        update_post_meta( $new_coupon_id, 'expiry_date', '' );
        update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
        update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
        
        $product = wc_get_product( $_POST['prod_id'] );

        $sharer = array(
            'post_title' => $product->get_title(),
            'post_content' => '',
            'post_status' => 'private',
            'post_author' => 1,
            'post_parent' => intval( $_POST['prod_id'] ),
            'post_type' => 'sie_shared_product');
    
        $new_sharer_id = wp_insert_post( $sharer );

        $response = array(
            'discount' => esc_html( $discount ),
            'ccode' => esc_html( $coupon_code ),
        );
        echo json_encode($response);
        die();
    }
    add_action('wp_ajax_sie_send_coupon', 'ajax_sie_send_coupon');
    add_action('wp_ajax_nopriv_sie_send_coupon', 'ajax_sie_send_coupon');
}

if( !function_exists('sie_get_fb_clicked') ){
    function sie_get_fb_clicked(){
        if( is_product() ){    
            if( $_GET['sieclid'] == 'dekcilc' &&  isset( $_GET['fbclid'] ) ){
                if( get_option('_sie_fb_clicks') ){
                    update_option( '_sie_fb_clicks', get_option('_sie_fb_clicks') + 1 );
                }else{
                    add_option( '_sie_fb_clicks', 1 );
                }

                $product = wc_get_product( intval( $_GET['pid'] ) );
                $clicked = array(
                    'post_title' => $product->get_title(),
                    'post_content' => '',
                    'post_status' => 'private',
                    'post_author' => 1,
                    'post_parent' => intval( $_GET['pid'] ),
                    'post_type' => 'sie_clicked_product');
            
                $new_clicked_id = wp_insert_post( $clicked );
            }    
        }
    }
    add_action('wp_head','sie_get_fb_clicked');
}


if( !function_exists('generateCode') ){
    function generateCode($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if( !function_exists('sie_add_badge') ){
    function sie_add_badge(){        
        if( get_option('_sie_discount_amt') && get_option('_sie_discount_type') && get_option('_sie_hashtag') && get_option('_sie_marketing_content')   )
        {
            global $product;
            $pid = $product->id;

            if( get_option('_sie_discount_type') == '%' ){
                $content = "Special Offer " . get_option('_sie_discount_amt') . "% Off Today!";
            }
            else{
                $content = "Special Offer " . get_option('_sie_discount_amt') . "% Off Today!";
            }
    ?>
            <div id="SIE-Badge">
                <div class="sie-sharer sie-body">                   
                    <div class="sie-discount-content"><img src="<?php echo SIE_DIR_URL; ?>/assets/images/logo6.svg" alt="sie-logo" width="23"> <span><?php echo esc_html( $content ); ?></span></div>
                </div>
                <input type="hidden" class="sie-product-id" value="<?php echo esc_html($pid); ?>">            
            </div>
    <?php
        }
    }
    add_action( 'woocommerce_after_add_to_cart_button','sie_add_badge');
}

