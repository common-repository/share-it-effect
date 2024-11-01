<?php
if ( !class_exists( 'SIE_APP' ) ) {
    class SIE_APP{
        protected $sie_assets;
        protected $sie_page;

        public function __construct() { 
            require_once SIE_DIR_PATH . '_inc/classes/sie.class.assets.php';
            $this->assets = new SIE_Load_Assets; 
            $this->assets->run();     
            
            $this->load_dependencies();
        }

        public function init_hooks() {             
            $this->sie_page = new SIE_Page_Content_Loader();

            add_filter( 'plugin_action_links_' . SIE_BASE_NAME, array($this,'sie_plugin_action_links') ); 
            add_action( 'admin_menu', array( $this, 'create_sie_menu') );
        }

        private function load_dependencies(){      
            require_once SIE_DIR_PATH . '_inc/sie-controller.php';                   
            require_once SIE_DIR_PATH . '_inc/classes/sie.class.content.loader.php';
        }
        
        public function sie_plugin_action_links( $links ) {               
                $settings_url = add_query_arg('page','sie-app',get_admin_url() . 'admin.php');

                $links = array_merge( array(
                    '<a href="' . esc_url( $settings_url ) . '&tab=settings">' . __( 'Settings', 'textdomain' ) . '</a>',
                    '<a href="' . esc_url( "https://www.shareiteffect.com/woocommerce/register" ) . '" style="color:green;">' . __( 'Premium Upgrade', 'textdomain' ) . '</a>'
                ), $links );

                return $links;
        }        
        
        /** 
          * This function responsible for pages menus    
          */
        public function create_sie_menu() {            
            add_menu_page( __( 'ShareitEffect', 'SIEapp' ), 'ShareitEffect', 'manage_options', 'sie-app',array($this,'sie_show_page'),'',25);  
            add_submenu_page('sie-app', 'Report', 'Report', 'manage_options', 'sie-app-reports',array($this,'sie_show_page'));
            add_submenu_page('sie-app', 'Help', 'Help', 'manage_options', 'sie-app-help',array($this,'sie_show_page'));
            add_submenu_page('sie-app', 'Free vs PRO', 'Free vs PRO', 'manage_options', 'sie-app-upgrade',array($this,'sie_show_page'));  
            add_submenu_page('sie-app', 'Videos', 'Videos', 'manage_options', 'sie-app-videos',array($this,'sie_show_page'));
        }

        /** 
          * This function responsible for showing the pages  
          */
        public function sie_show_page() {  
            $default_tab = 'settings';
            $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;

            $this->sie_before_content($tab);
            
            $this->sie_page->get_content($tab);     

            $this->sie_after_content();
        }        

        public function sie_before_content($tab) {  
            ?>                     
            <div class="container-fluid">
                <img src="<?php echo esc_url( SIE_DIR_URL . '/assets/images/logo3.png') ?>" alt="shareiteffect logo" class="py-2" style="max-width:220px;">

                <!-- Tabs with static right column -->
                <div class="row">
                    <div class="col">
                        <!-- Here are our tabs -->
                        <nav class="nav-tab-wrapper">
                            <a href="?page=sie-app&tab=settings" class="nav-tab <?php if($tab==='settings'):?>nav-tab-active<?php endif; ?>">Settings</a>
                            <a href="?page=sie-app-reports&tab=reports" class="nav-tab <?php if($tab==='reports'):?>nav-tab-active<?php endif; ?>">Reports</a>
                            <a href="?page=sie-app-help&tab=help" class="nav-tab <?php if($tab==='help'):?>nav-tab-active<?php endif; ?>">Help</a>
                            <a href="?page=sie-app-upgrade&tab=upgrade" class="nav-tab bg-success text-white <?php if($tab==='upgrade'):?>nav-tab-active <?php endif; ?>">Free vs Pro</a>
                            <a href="?page=sie-app-videos&tab=videos" class="nav-tab <?php if($tab==='videos'):?>nav-tab-active <?php endif; ?>">Videos</a>
                        </nav>
                        <div class="tab-content">
                        
                        <br/>
                            <?php
        }

        public function sie_after_content() {
            ?>
                        </div>
                    </div>                
                </div>
            </div>
            
            <?php
        }       

        public function sie_script_loader_tag($tag, $handle, $src) {
            // echo '<script>alert("' . $handle . '");</script>';
            if ($handle === 'sie-app') {   
                if (false === stripos($tag, 'async')) {
                    $tag = str_replace(' src', ' async="async" src', $tag);
                }
                
                if (false === stripos($tag, 'defer')) {
                    $tag = str_replace('<script ', '<script defer ', $tag);
                }
            }
            
            return $tag;
        }        
    }

    $app = new SIE_APP;    
    $app->init_hooks();
       
}