<?php

// Settings
$oum_disable_cluster = get_option('oum_disable_cluster') ? 'true' : 'false';
$oum_disable_fullscreen = get_option('oum_disable_fullscreen') ? 'true' : 'false';
$oum_disable_gmaps_link = get_option('oum_disable_gmaps_link');
$map_style = get_option('oum_map_style') ? get_option('oum_map_style') : 'Esri.WorldStreetMap';
$marker_icon = get_option('oum_marker_icon') ? get_option('oum_marker_icon') : 'default';
$marker_user_icon = get_option('oum_marker_user_icon');
$map_size = get_option('oum_map_size');
$map_size_mobile = get_option('oum_map_size_mobile');
$oum_map_height = get_option('oum_map_height');
$oum_map_height_mobile = get_option('oum_map_height_mobile');
$oum_action_after_submit = get_option('oum_action_after_submit');
$thankyou_headline = get_option('oum_thankyou_headline');
$thankyou_text = get_option('oum_thankyou_text');
$thankyou_redirect = get_option('oum_thankyou_redirect');
$oum_disable_add_location = get_option('oum_disable_add_location');
$oum_enable_user_notification = get_option('oum_enable_user_notification');
$text_notify_me_on_publish_label = __('notify me on publish', 'open-user-map');
$text_notify_me_on_publish_name = __('Your name', 'open-user-map');
$text_notify_me_on_publish_email = __('Your email', 'open-user-map');
$oum_enable_currentlocation = get_option('oum_enable_currentlocation') ? 'true' : 'false';
$oum_ui_color = get_option('oum_ui_color') ? get_option('oum_ui_color') : $this->oum_ui_color_default;
$oum_plus_button_label = get_option('oum_plus_button_label') ? get_option('oum_plus_button_label') : __('Add location', 'open-user-map');
$oum_marker_types_label = get_option('oum_marker_types_label') ? get_option('oum_marker_types_label') : $this->oum_marker_types_label_default;
$oum_title_label = get_option('oum_title_label') ? get_option('oum_title_label') : $this->oum_title_label_default;
$oum_map_label = get_option('oum_map_label') ? get_option('oum_map_label') : $this->oum_map_label_default;
$oum_searchaddress_label = get_option('oum_searchaddress_label') ? get_option('oum_searchaddress_label') : $this->oum_searchaddress_label_default;
$oum_address_label = get_option('oum_address_label') ? get_option('oum_address_label') : $this->oum_address_label_default;
$oum_description_label = get_option('oum_description_label') ? get_option('oum_description_label') : $this->oum_description_label_default;
$oum_addanother_label = get_option('oum_addanother_label') ? get_option('oum_addanother_label') : $this->oum_addanother_label_default;

$types = get_terms( array(
  'taxonomy' => 'oum-type',
  'hide_empty' => false
));

$query = array(
  'post_type' => 'oum-location',
  'posts_per_page' => -1,
  'fields' => 'ids',
);

// Filter for types
if(isset($block_attributes['types']) && $block_attributes['types'] != '') {
  $selected_types = explode('|', $block_attributes['types']);
  $query['tax_query'] = array(
    array(
      'taxonomy' => 'oum-type',
      'field'    => 'slug',                 
      'terms'    => $selected_types,      // provide the term slugs
    ),
  );
};

// Filter for ids
if(isset($block_attributes['ids']) && $block_attributes['ids'] != '') {
  $selected_ids = explode('|', $block_attributes['ids']);
  $query['include'] = $selected_ids;
};

$locations = get_posts($query);

$locations_list = array();
foreach ($locations as $post_id) {
    // Prepare data
    $location_meta = get_post_meta($post_id, '_oum_location_key', true);

    $name = str_replace("'", "\'", htmlentities(get_the_title($post_id)));
    $address = isset($location_meta['address'])? str_replace("'", "\'", (preg_replace('/\r|\n/', '', $location_meta['address']))) : '';
    $text = isset($location_meta["text"])? str_replace("'", "\'", str_replace(array("\r\n", "\r", "\n"),"<br>",$location_meta["text"])) : '';

    $image = get_post_meta($post_id, '_oum_location_image', true);

    if(stristr($image, 'oum-useruploads')) {
      //image uploaded from frontend
      $image_thumb = get_post_meta($post_id, '_oum_location_image_thumb', true);
    }else{
      //image uploaded from backend
      $image_id = attachment_url_to_postid($image);

      if($image_id > 0) {
        $image_thumb = wp_get_attachment_image_url($image_id, 'medium');
      }
    }

    if(isset($image_thumb)) {
      //use thumbnail if available
      $image = $image_thumb;
    }

    $audio = get_post_meta($post_id, '_oum_location_audio', true);

    // custom fields
    $custom_fields = [];
    $meta_custom_fields = isset($location_meta['custom_fields'])? $location_meta['custom_fields'] : false;
    $active_custom_fields = get_option('oum_custom_fields');
    if (is_array($meta_custom_fields) && is_array($active_custom_fields)) {
      
      foreach($active_custom_fields as $index => $active_custom_field) {
        if(isset($meta_custom_fields[$index])) {
          array_push($custom_fields, array(
            'label' => $active_custom_field['label'],
            'val' => $meta_custom_fields[$index],
          ));
        }
      }

    }

    if (!isset($location_meta['lat']) && !isset($location_meta['lng'])) {
        continue;
    }

    $geolocation = array(
        'lat' => $location_meta['lat'],
        'lng' => $location_meta['lng'],
    );

    if ( oum_fs()->is__premium_only() ):
      if ( oum_fs()->can_use_premium_code() ):

        //PRO Feature: use types
        $type = (get_the_terms($post_id, 'oum-type') && !is_wp_error(get_the_terms($post_id, 'oum-type')))? get_the_terms($post_id, 'oum-type')[0] : false;

      endif;
    endif;
    
    if(isset($type) && $type) {
      //get icon from oum-type taxonomy
      $marker_icon = get_term_meta($type->term_id, 'oum_marker_icon', true);
      $marker_user_icon = get_term_meta($type->term_id, 'oum_marker_user_icon', true);
    }else{
      //get icon from settings
      $marker_icon = get_option('oum_marker_icon');
      $marker_user_icon = get_option('oum_marker_user_icon');
    }

    if($marker_icon == 'user1' && $marker_user_icon) {
      $icon = esc_url($marker_user_icon);
    }else{
      $icon = esc_url($this->plugin_url) . 'src/leaflet/images/marker-icon_' . esc_attr($marker_icon) .'-2x.png';
    }

    // collect locations for JS use
    $location = array(
      'post_id' => $post_id,
      'name' => $name,
      'address' => $address,
      'lat' => $geolocation['lat'],
      'lng' => $geolocation['lng'],
      'text' => $text,
      'image' => $image,
      'audio' => $audio,
      'icon' => $icon,
      'custom_fields' => $custom_fields,
    );
    
    if(isset($type) && $type) {
      $location['type_term_id'] = $type->term_id;
      $location['type_name'] = $type->name;
    }

    $locations_list[] = $location;
}

// Set focus for map init
if(isset($block_attributes['lat']) && $block_attributes['lat'] != '' && isset($block_attributes['long']) && $block_attributes['long'] != '' && isset($block_attributes['zoom']) && $block_attributes['zoom'] != '') {
  //get from shortcode attributes
  $start_lat = str_replace(',', '.', $block_attributes['lat']);
  $start_lng = str_replace(',', '.', $block_attributes['long']);
  $start_zoom = str_replace(',', '.', $block_attributes['zoom']);
}elseif(get_option('oum_start_lat') && get_option('oum_start_lng') && get_option('oum_start_zoom')) {
  //get from settings
  $use_settings_start_location = true;
  $start_lat = get_option('oum_start_lat');
  $start_lng = get_option('oum_start_lng');
  $start_zoom = get_option('oum_start_zoom');
}elseif(count($locations_list) > 0){
  //get from first location
  $start_lat = $locations_list[0]['lat'];
  $start_lng = $locations_list[0]['lng'];
  $start_zoom = '5';
}else{
  //default
  $start_lat = '0';
  $start_lng = '0';
  $start_zoom = '1';
}

$i = 0;

// BUGFIX: resolves issue with non-unique ids when caching inline js with 3rd party plugins
// todo: allow multiple maps/shortcodes on same site

//$unique_id = uniqid();
$unique_id = 20210929; 

?>