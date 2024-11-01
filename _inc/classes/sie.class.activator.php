<?php
if( !class_exists('SIE_App_Activator') )  {
	class SIE_App_Activator {
		
		public static function sie_activate() {					
			update_option( 'woocommerce_enable_coupons', 'yes' );
		}	
	}
	SIE_App_Activator::sie_activate();
}