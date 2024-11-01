<div class="row">
    <div class="col-md-12 pb-4">
        <h3>ShareitEffect Popup Discount Settings</h3>
    </div>
    <!-- new form -->
    <div class="col-sm-12 col-xl-8 pb-3 px-2 pl-lg-2 pr-lg-3 pr-xl-0">
        <div class="alert alert-secondary" role="alert">
            * This section is required to begin your FREE ShareitEffect Services and to start getting your customers to recommend your products to hundred of their followers.
        </div>
            
        <form class="px-3 pb-5">
            <div class="form-group row">
                <label for="sie-discount-amt" class="col-sm-5 col-form-label">Discount Amount</label>
                <div class="col-sm-7">
                    <div class="input-group">
                    <input type="number" placeholder="0" class="form-control py-1 px-3" id="sie-discount-amt" value="<?php esc_html_e( get_option('_sie_discount_amt'), 'sie_app' ); ?>">
                    <div class="input-group-append">
                        <label style="padding-top: 10px!Important;" class="btn btn-secondary mb-0 px-3 <?php if( get_option('_sie_discount_type') == '%' ) esc_html_e( 'active', 'sie_app' ); ?> ">
                            <input type="radio" name="options" id="sie-discount-type1" autocomplete="off" <?php if( get_option('_sie_discount_type') == '%' ) esc_html_e(  'checked', 'sie_app' ); if( !get_option('_sie_discount_type') ) esc_html_e(  'checked', 'sie_app' );  ?> > %
                        </label>
                        <label style="padding-top: 10px!Important;" class="btn btn-secondary mb-0 px-3 <?php if( get_option('_sie_discount_type') == '$' ) esc_html_e(  'active', 'sie_app' ); ?>">
                            <input type="radio" name="options" id="sie-discount-type2" autocomplete="off" <?php if( get_option('_sie_discount_type') == '$' ) esc_html_e(  'checked', 'sie_app' ); ?>> $
                        </label>
                    </div>
                    </div>
                </div>
            </div>
            <!--<div class="form-group row">
                <label for="sie-discount-type1" class="col-sm-5 col-form-label">Discount Type</label>
                <div class="col-sm-7">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        
                    </div>
                </div>
            </div>-->
            <div class="form-group row my-2">
                <label for="sie-hashtag" class="col-sm-5 col-form-label">Hashtag: <em class="font-weight-light">Only One #Hashtag Allowed (Example:#MyCompanyRocks or #SaveMore)</em></label>
                <div class="col-sm-7">
                    <input type="text" placeholder="#yourHashTag" class="form-control py-1 px-3" id="sie-hashtag"  value="<?php esc_html_e(  get_option('_sie_hashtag'), 'sie_app' ); ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="sie-marketing-content"  class="col-sm-5 col-form-label">Marketing Content: <em class="font-weight-light">Example: "Save 20% when you click on the image below."</em></label>
                <div class="col-sm-7">
                    <textarea class="form-control py-1 px-3" placeholder="Enter content here..." style="border:1px solid #7e8993;" id="sie-marketing-content" rows="5"><?php esc_html_e(  get_option('_sie_marketing_content'), 'sie_app' ); ?></textarea>
                </div>
            </div>

            <!--<div class="form-group row mt-2">
                <label for="sie-marketing-content"  class="col-sm-5 col-form-label">Insert After </label>
                <div class="col-sm-7">
                    <select class="form-control" id="sie-append-to" name="append_to">
                        <option value="id" <?php if( get_option('_sie_append_to') ){ esc_html_e('selected'); } ?>>ID</option>
                        <option value="class" <?php if( get_option('_sie_append_to') ){ esc_html_e('selected'); } ?>>Class</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="sie-marketing-content"  class="col-sm-5 col-form-label">Field Element</label>
                <div class="col-sm-7">
                    <input type="text" id="sie-field-element" class="form-control" name="field_element" value="<?php esc_html_e(  get_option('_sie_field_element'), 'sie_app' ); ?>">
                </div>
            </div>-->
            <button type="button" id="sie-save-settings" class="btn btn-danger btn-lg float-right px-5 mt-5"><?php _e( 'Save Settings' ); ?></button>
            <div class="form-group row sie-alert d-none">
                <div class="alert alert-success  mt-2 ml-3" role="alert">
                    You have saved successfully
                </div>
            </div>
        </form>            
        

        <div class="alert alert-secondary mt-5" role="alert">
            * This section is just an example of how our services work and what will happen when your customers click "Add to Cart" from your product page.
        </div>

    	<div class="row mx-0 px-0"> 
            <div class="col-12 col-lg-7">
                <span class="badge badge-info float-right text-dark">🔍 Preview</span>
                <!-- form preview -->
                <div style="border: 3px dashed #ccc;padding:20px; margin:auto;">
                    <div id="SIE-Badge" class="sie-badge">
                        <div class="sie-sharer sie-body">
                            <div class="sie-icon">
                                <img src="<?php echo esc_url(SIE_DIR_URL . 'assets/images/logo6.svg') ?>" alt="sie-logo" width="23">
                            </div>
                            <div class="sie-discount-content">Special Offer 10% Off Today!</div>
                        </div>
                    </div>
                    <div class="sie-ex-modal text-center d-none" id="template-four-simple" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header pb-0 border-bottom-0 d-block position-relative text-end">
                                    <button type="button" class="close bg-transparent border-0 close-modal" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body pt-0">
                                    <h2 class="font-weight-bold pb-2 blink-1 text-primary">Get 10% OFF</h2>
                                    <h5 class="border-top border-bottom pt-2 pb-2 mb-4">Share on Facebook and get a <br />10% OFF on your order right now!</h5>
                                    <button type="button" class="btn btn-outline-primary btn-lg btn-block font-weight-bold shake" data-bs-toggle="collapse" data-bs-target="#kuyapanUY" aria-expanded="true" aria-controls="kuyapanUY">Share It!</button>
                                </div>
                                <div class="modal-footer bg-light text-dark justify-content-center d-none">
                                    <img src="<?php echo esc_url(SIE_DIR_URL . '/assets/images/poweredby.svg'); ?>" width="80" alt="Powered by ShareitEffect" title="Powered by ShareitEffect">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 

            <div class="col-12 col-lg-5 pl-2">
                <div id="accordion">
                    
                    <div id="kuyapanUY" class="collapse" aria-labelledby="sharefb" data-bs-parent="#accordion">
                        <div class="card-body text-center">
                            <img class="img-fluid" src="https://app.shareiteffect.com/assets/images/pop_component.png" alt="sie-fb-popup" title="Powered by ShareitEffect">
                        </div>
                    </div>
                </div>
            </div>

        </div>    
    </div>
    <?php require_once SIE_DIR_PATH . '/partials/side-upgrade-content.php'; ?>
</div>
<style>
    .active {
        background-color: #0062cc !important;
        border-color: #005cbf  !important;
    }
</style>