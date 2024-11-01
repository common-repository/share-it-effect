<?php
if( !class_exists('SIE_Page_Content_Loader') )  {
	class SIE_Page_Content_Loader {
		
		public function get_content( $page ) {					
			require SIE_PAGE_CONTENT . $page . '-content.php';
		}	
	}
}