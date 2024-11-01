<?php
if( !class_exists('SIE_Load_Assets') )  {
	class SIE_Load_Assets {
        public function run(){
            add_action('admin_enqueue_scripts',array( $this, 'admin_load_assets'),99); 
            add_action('wp_enqueue_scripts',array( $this, 'load_assets'),99); 
        }
		
		public function load_assets(){
            $style = 'bootstrap';
			if( ( ! wp_style_is( $style, 'queue' ) ) && ( ! wp_style_is( $style, 'done' ) ) ) {
				//queue up your bootstrap
				wp_enqueue_style( $style, 
					SIE_DIR_URL . 'assets/css/bootstrap.min.css', 
					array(),
                	'5.0.0',
                	'all' );
			}
            wp_enqueue_style(
                'sie-app',
                SIE_DIR_URL . 'assets/css/sie-styles.css',
                array(),
                1,
                'all'
            );

            wp_register_script('sie-app',SIE_DIR_URL . 'assets/js/sie-scripts.js',array('jquery'));
            wp_enqueue_script(
                'sie-app'
            );

            wp_localize_script( 'sie-app', 'sie_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'sie_path' => SIE_DIR_URL ) );
        }	

        public function admin_load_assets(){
            // Styles
            wp_enqueue_style(
                'sie-app-bootstap',
                SIE_DIR_URL . 'assets/css/bootstrap.min.css',
                array(),
                '5.0.0',
                'all'
            );

            wp_enqueue_style(
                'sie-app',
                SIE_DIR_URL . '_admin/assets/css/sie-styles.css',
                array(),
                1,
                'all'
            );

            // JS
            wp_enqueue_script(
                'sie-app-popper',
                SIE_DIR_URL . 'assets/js/popper.min.js',
                array('jquery'),
                '1.16.0',
                'true'
            );

            wp_enqueue_script(
                'sie-app-bootstap',
                SIE_DIR_URL . 'assets/js/bootstrap.min.js',
                array('jquery'),
                '5.0.0',
                'true'
            );

            wp_enqueue_script(
                'sie-app-jsapi',
                SIE_DIR_URL . 'assets/js/google.jsapi.js',
                array('jquery'),
                1.2,
                'true'
            );

            wp_enqueue_script(
                'sie-app',
                SIE_DIR_URL . '_admin/assets/js/sie-scripts.js',
                array('jquery'),
                1,
                'true'
            );            

            wp_localize_script( 'sie-app', 'sie_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'sie_path' => SIE_DIR_URL ) );
        }
	}
}