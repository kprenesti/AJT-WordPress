<?php


add_action('init', 'ajt_register_promos');

function ajt_register_promos() {
  $singular = 'Promo';
  $plural = 'Promos';
  $labels = array(
    'name'               => $plural,   
    'singular'           => $singular,
    'add_name'           => 'Add New',
    'add_new_item'       => 'Add New '.$singular,
    'new_item'           => 'New '.$singular,
    'edit'               => 'Edit',
    'edit_item'          => 'Edit '.$singular,
    'new_item'           => 'New '.$singular,
    'view'               => 'View',
    'view_item'          => 'View '.$singular,
    'search_term'        => 'Search '.$plural,
    'parent'             => 'Parent '.$singular,
    'not_found'          => 'No '.$plural.' found',
    'not_found_in_trash' => 'No '.$plural.' found in trash'
  );
  $args = array (
    'labels'             => $labels,
    'public'             => true,
    'capability_type'    => 'post',
    'show_in_nav_menus'  => true,
    'show_in_menu'       => true,
    'show_in_admin_bar'  => true,
    'menu_position'      => 2,
    'menu_icon'          => 'dashicons-admin-site',
    'can_export'         => true,
    'delete_with_user'   => false,
    'hierarchical'       => false,
    'has_archive'        => true,
    'map_meta_cap'       => true,
    'rewrite'            => array(
              'slug' => 'promos',
              'pages' => true,
              'feeds' => true,
            ),
    'supports'           => array (
              'title', 'thumbnail', 'excerpt' ),
    'taxonomies'         => array(
              'locations', 'styles', 'duration', 'post_tag')
        );
  
register_post_type('promos', $args);
  
}

add_action('init', 'ajt_custom_tax');

register_taxonomy_for_object_type( 'locations', 'promos' );
register_taxonomy_for_object_type( 'duration', 'promos' );
register_taxonomy_for_object_type( 'styles', 'promos' );

function ajt_custom_tax(){
$labels = array(
		'name'              => _x( 'Locations', 'taxonomy general name' ),
		'singular_name'     => _x( 'Location', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Locations' ),
		'all_items'         => __( 'All Locations' ),
		'parent_item'       => __( 'Parent Location' ),
		'parent_item_colon' => __( 'Parent Location:' ),
		'edit_item'         => __( 'Edit Location' ),
		'update_item'       => __( 'Update Location' ),
		'add_new_item'      => __( 'Add New Location' ),
		'new_item_name'     => __( 'New Location Name' ),
		'menu_name'         => __( 'Locations' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'locations' ),
	);
  
  register_taxonomy('locations', array('promos', 'posts', 'pages'), $args);
  
  $labels = array(
    'name'              => _x( 'Travel Styles', 'taxonomy general name' ),
		'singular_name'     => _x( 'Travel Style', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Travel Styles' ),
		'all_items'         => __( 'All Travel Styles' ),
		'edit_item'         => __( 'Edit Travel Style' ),
		'update_item'       => __( 'Update Travel Style' ),
		'add_new_item'      => __( 'Add New Travel Style' ),
		'new_item_name'     => __( 'New Travel Style' ),
		'menu_name'         => __( 'Travel Styles' ),
  );
  
  $args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'styles' ),
  );

  register_taxonomy('styles', array('promos', 'posts', 'pages'), $args);

$labels = array(
    'name'              => _x( 'Trip Duration', 'taxonomy general name' ),
		'singular_name'     => _x( 'Trip Duration', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Durations' ),
		'all_items'         => __( 'All Durations' ),
		'edit_item'         => __( 'Edit Duration' ),
		'update_item'       => __( 'Update Duration' ),
		'add_new_item'      => __( 'Add New Duration' ),
		'new_item_name'     => __( 'New Duration' ),
		'menu_name'         => __( 'Trip Duration' ),
  );
  
  $args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'duration' ),
  );

  register_taxonomy('duration', array('promos', 'posts', 'pages'), $args);
}

add_filter('pre_get_posts', 'ajt_query_post_type');
function ajt_query_post_type($query) {
  if(is_category() || is_tag()) {
    $post_type = get_query_var('post_type');
	   if($post_type)
	    $post_type = $post_type;
	   else
	    $post_type = array('post','promos');
    $query->set('post_type',$post_type);
	return $query;
    }
}
?>
