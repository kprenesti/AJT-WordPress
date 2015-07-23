<?php 

add_action( 'load-post.php', 'ajt_custom_meta_box' );
add_action( 'load-post-new.php', 'ajt_custom_meta_box' );
add_action( 'add_meta_boxes','ajt_custom_meta_box');


function ajt_custom_meta_box(){
  add_meta_box (
    'ajt-promo-duration',
    'Promotion Details',
    'ajt_promo_callback',
    'promos',
    'normal',
    'core'
    
  ); //end add_meta_box
  
  add_meta_box (
    'ajt-promo-description',
    'Promotion Description',
    'ajt_promo_desc_callback',
    'promos',
    'normal',
    'core'
    
  ); //end add_meta_box
  
  add_meta_box (
    'ajt-promo-itin',
    'Promotion Itinerary',
    'ajt_promo_itin_callback',
    'promos',
    'normal',
    'core'
    
  ); //end add_meta_box
}



function ajt_promo_callback( $post ){

wp_nonce_field(basename( __FILE__ ), 'ajt_promos_nonce');
$ajt_stored_meta = get_post_meta($post -> ID);

?>
  <div class="meta-container">
    <div class="meta-row">
      <div class="meta-th">
        <label for="ajt_promo_dur" class="ajt-row-title">How Long is the Trip?</label>
      </div>
      <div class="meta-td">
        <input type="text" name="ajt_promo_dur" class="ajt-text-input" id="ajt_promo_dur" placeholder="Ex: 7-Days, 6-Nights" value="<?php if(!empty($ajt_stored_meta['ajt_promo_dur'])) echo esc_attr($ajt_stored_meta['ajt_promo_dur'][0]); ?>">
      </div>
    </div><!--end row--> 
    <div class="meta-row">
      <div class="meta-th sub">
        <label for="ajt-promo-start" class="ajt-row-title">Start Date</label>
      </div>
      <div class="meta-td sub">
        <input type="text" name="ajt-promo-start" class="ajt-text-input" id="ajt-promo-start" value="">
      </div>
      <div class="meta-th sub">
        <label for="ajt-promo-end" class="ajt-row-title">End Date</label>
      </div>
      <div class="meta-td sub">
        <input type="text" name="ajt-promo-end" class="ajt-text-input" id="ajt-promo-end" value="">
      </div>
    </div><!--end row--> 
    <div class="meta-row">
      <div class="meta-th">
        <span>Description</span>
      </div>
    </div><!--end row-->
    
  </div><!--end container div -->

<?php
} //End dates callback

function ajt_promo_desc_callback( $post ){
wp_nonce_field(basename( __FILE__ ), 'ajt_promos_nonce');
$ajt_stored_meta = get_post_meta($post -> ID);
?>
  <div class="meta-container">
    <div class="meta-description">
      <h2>Trip Description</h2>
      <p>Please write the trip description below.  Do not include the itinerary; that will go in the form below.  The first few sentences will be shown as the post snippet on the homepage.</p>
    </div>
    <div class="ajt-wp-editor">
    <?php 
        $content = get_post_meta($post -> ID, 'promo_desc', true);
        $editor_id = 'promo_desc';
        $settings = array(
          'textarea_row' => 5,
          'media_buttons' => false,
          'drag_drop_upload' => true
        );
          wp_editor( $content, $editor_id, $settings);
      ?>
    </div>
</div>
    
<?php
} //end descriptions callback

function ajt_promo_itin_callback( $post ){
wp_nonce_field(basename( __FILE__ ), 'ajt_promos_nonce');
$ajt_stored_meta = get_post_meta($post -> ID);
?>
  <div class="meta-container">
    <div class="meta-description">
      <h2>Trip Itinerary</h2>
      <p>Please write the trip itinerary below. Suggested format:</p>
      <p><strong>Day 1:</strong> Lorem ipsum doleassa</p>
    </div>
    <div class="ajt-wp-editor">
    <?php 
        $content = get_post_meta($post -> ID, 'promo_itin', true);
        $editor_id = 'promo_itin';
        $settings = array(
          'textarea_row' => 5,
          'media_buttons' => true,
          'drag_drop_upload' => true

        );
          wp_editor( $content, $editor_id, $settings);
      ?>
    </div>
</div>
    
<?php
} //end descriptions callback

function ajt_save_data( $post_id ) {
	// Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'ajt_promos_nonce' ] ) && wp_verify_nonce( $_POST[ 'ajt_promos_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
    if ( isset( $_POST[ 'ajt_promo_dur' ] ) ) {
    	update_post_meta( $post_id, 'ajt_promo_dur', sanitize_text_field( $_POST[ 'ajt_promo_dur' ] ) );
    }
    if ( isset( $_POST[ 'ajt-promo-start' ] ) ) {
    	update_post_meta( $post_id, 'ajt-promo-start', sanitize_text_field( $_POST[ 'ajt-promo-start' ] ) );
    }
    if ( isset( $_POST[ 'ajt-promo-end' ] ) ) {
    	update_post_meta( $post_id, 'ajt-promo-end', sanitize_text_field( $_POST[ 'ajt-promo-end' ] ) );
    }
    if ( isset( $_POST[ 'promo_desc' ] ) ) {
    	update_post_meta( $post_id, 'promo_desc', sanitize_text_field( $_POST[ 'promo_desc' ] ) );
    }
    if ( isset( $_POST[ 'promo_itin' ] ) ) {
    	update_post_meta( $post_id, 'promo_itin', sanitize_text_field( $_POST[ 'promo_itin' ] ) );
    }
}
add_action( 'save_post', 'ajt_save_data' );
