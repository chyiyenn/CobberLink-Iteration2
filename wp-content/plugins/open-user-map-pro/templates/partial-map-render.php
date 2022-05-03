<div class="box-wrap">
    <div class="map-wrap map-size-<?php echo esc_attr($map_size); ?> map-size-mobile-<?php echo esc_attr($map_size_mobile); ?>">
      <div id="map-<?php echo $unique_id; ?>" class="leaflet-map map-style_<?php echo esc_attr($map_style); ?>"></div>
      
      <?php if($oum_disable_add_location != 'on'): ?>
      
        <?php if ( oum_fs()->is__premium_only() ): ?>
          <?php if ( oum_fs()->can_use_premium_code() ): ?>

            <?php if(get_option('oum_enable_user_restriction')): ?>

              <?php if(current_user_can('edit_posts') || current_user_can('edit_oum-locations')): ?>

                <div id="open-add-location-overlay" class="open-add-location-overlay" style="background-color: <?php echo $oum_ui_color; ?>"><span class="btn_icon">+</span><span class="btn_text"><?php echo esc_attr($oum_plus_button_label); ?></span></div>

              <?php elseif(!is_user_logged_in() && get_option('oum_enable_redirect_to_registration')): ?>

                <a href="<?php echo wp_registration_url(); ?>" class="open-add-location-overlay" style="background-color: <?php echo $oum_ui_color; ?>"><span class="btn_icon">+</span><span class="btn_text"><?php echo esc_attr($oum_plus_button_label); ?></span></a>

              <?php endif; ?>

            <?php else: ?>

                <div id="open-add-location-overlay" class="open-add-location-overlay" style="background-color: <?php echo $oum_ui_color; ?>"><span class="btn_icon">+</span><span class="btn_text"><?php echo esc_attr($oum_plus_button_label); ?></span></div>

            <?php endif; ?>

          <?php endif; ?>
        <?php endif; ?>

        <?php if ( !oum_fs()->can_use_premium_code() ) : ?>

          <div id="open-add-location-overlay" class="open-add-location-overlay" style="background-color: <?php echo $oum_ui_color; ?>"><span class="btn_icon">+</span><span class="btn_text"><?php echo esc_attr($oum_plus_button_label); ?></span></div>

        <?php endif; ?>

      <?php endif; ?>

      <script>
        // INFO: The following JS code does not work with IE11 because of template literals

        var map_el = `map-<?php echo $unique_id; ?>`;

        if(document.getElementById(map_el)) {

          var mapStyle = `<?php echo esc_attr($map_style); ?>`;
          var oum_searchaddress_label = `<?php echo esc_attr($oum_searchaddress_label); ?>`;
          var marker_icon_url = `<?php echo ($marker_icon == 'user1' && $marker_user_icon) ? esc_url($marker_user_icon) : esc_url($this->plugin_url).'src/leaflet/images/marker-icon_'.esc_attr($marker_icon).'-2x.png'; ?>`;
          var marker_shadow_url = `<?php echo esc_url($this->plugin_url); ?>src/leaflet/images/marker-shadow.png`;
          var oum_disable_cluster = <?php echo $oum_disable_cluster; ?>;
          var oum_disable_fullscreen = <?php echo $oum_disable_fullscreen; ?>;
          var oum_enable_currentlocation = <?php echo $oum_enable_currentlocation; ?>;
          var oum_action_after_submit = `<?php echo $oum_action_after_submit; ?>`;
          var thankyou_redirect = `<?php echo $thankyou_redirect; ?>`;
          var oum_location = {};
          var locations_without_type = [];
          var locations_by_type = [];
          var custom_css = '';
          
          
          <?php if($oum_ui_color): ?>

            //custom color
            custom_css += `
              .open-user-map .add-location #close-add-location-overlay:hover {color: <?php echo $oum_ui_color; ?> !important}
              .open-user-map input.oum-switch[type="checkbox"]:checked + label::before {background-color: <?php echo $oum_ui_color; ?> !important}
              .open-user-map .add-location .location-overlay-content #oum_add_location_thankyou h3 {color: <?php echo $oum_ui_color; ?> !important}`;

          <?php endif; ?>

          <?php if($oum_map_height): ?>

            //custom map height
            custom_css += `
              .open-user-map .box-wrap .map-wrap {padding: 0 !important; height: <?php echo esc_attr($oum_map_height); ?> !important}`;

          <?php endif; ?>

          <?php if($oum_map_height_mobile): ?>

            //custom map height
            custom_css += `
              @media screen and (max-width: 768px) {.open-user-map .box-wrap .map-wrap {padding: 0 !important; height: <?php echo esc_attr($oum_map_height_mobile); ?> !important}}`;

          <?php endif; ?>

          var custom_style = document.createElement('style');

          if (custom_style.styleSheet) {
            custom_style.styleSheet.cssText = custom_css;
          } else {
            custom_style.appendChild(document.createTextNode(custom_css));
          }

          document.getElementsByTagName('head')[0].appendChild(custom_style);


          <?php foreach ($locations_list as $location): ?>
            <?php
            $name_tag = (!get_option('oum_disable_title')) ? '<h3 class="oum_location_name">' . esc_attr($location['name']) . '</h3>' : '';

            if($location['image']) {
              //try to get image height to preset height of image container (depends on SSL)
              $img_size = @getimagesize($location['image']);

              if($img_size) {
                $img_height = $img_size[1] / $img_size[0] * 250;
                $height = 'style="min-height: ' . $img_height . 'px;"';
              }else{
                $height = '';
              }
              
              $img_tag = '<div class="oum_location_image" ' . $height . '><img src="'. esc_url_raw($location['image']) .'"></div>';
            }else{
              $img_tag = '';
            }

            $audio_tag = $location['audio']? do_shortcode('[audio mp3="' . esc_attr($location['audio']) . '"][/audio]') : '';
            
            if(!get_option('oum_disable_address')) {
              $address_tag = ($location['address'] && !get_option('oum_hide_address'))? esc_attr($location['address']) : '';
            
              if(!$oum_disable_gmaps_link && $address_tag) {
                $address_tag = '<a title="' . __('go to Google Maps', 'open-user-map') . '" href="https://www.google.com/maps/search/?api=1&amp;query=' . esc_attr($location['lat']) . '%2C' . esc_attr($location['lng']) . '" target="_blank">' . $address_tag . '</a>';
              }
            }
            
            $address_tag = isset($address_tag)? '<div class="oum_location_address">'. $address_tag .'</div>' : '';

            if(!get_option('oum_disable_description')) {
              $description_tag = '<div>' . wp_kses_post($location['text']) . '</div>';
            }else{
              $description_tag = '';
            }

            $custom_fields = '';
            if(isset($location['custom_fields']) && is_array($location['custom_fields'])) {
              $custom_fields .= '<div class="oum_location_custom_fields">';
              foreach($location['custom_fields'] as $custom_field) {

                if (!$custom_field['val'] || $custom_field['val'] == '') continue;
                
                if(is_array($custom_field['val'])) {
                  $custom_fields .= '<div class="oum_custom_field"><strong>' . $custom_field['label'] . ':</strong> ' . implode(', ', $custom_field['val']) . '</div>';
                }else{
                  if(stristr($custom_field['val'], '|')){
                    
                    //multiple entries separated with | symbol
                    
                    $custom_fields .= '<div class="oum_custom_field"><strong>' . $custom_field['label'] . ':</strong> ';
                    
                    foreach(explode('|', $custom_field['val']) as $entry) {
                      $entry = trim($entry);

                      if(wp_http_validate_url($entry)) {
                        //URL
                        $custom_fields .= '<a href="' . $entry . '">' . $entry . '</a> ';
                      }else{
                        //Text
                        $custom_fields .= $entry . ' ';
                      }
                    }

                    $custom_fields .= '</div>';
                  }else{

                    //single entry

                    if(wp_http_validate_url($custom_field['val'])) {
                      //URL
                      $custom_fields .= '<div class="oum_custom_field"><strong>' . $custom_field['label'] . ':</strong> <a href="' . $custom_field['val'] . '">' . $custom_field['val'] . '</a></div>';
                    }else{
                      //Text
                      $custom_fields .= '<div class="oum_custom_field"><strong>' . $custom_field['label'] . ':</strong> ' . $custom_field['val'] . '</div>';
                    }
                  }
                }

              }
              $custom_fields .= '</div>';
            }

            if(get_option('oum_enable_single_page')) {
              $link_tag = '<div><a href="'. get_the_permalink($location['post_id']) .'">' . __('Read more', 'open-user-map') . '</a></div>';
            }else{
              $link_tag = '';
            }
            
            // building bubble block
            $content = $img_tag;
            $content .= '<div class="oum_location_text">';
              $content .= $address_tag;
              $content .= $name_tag;
              $content .= $custom_fields;
              $content .= $description_tag;
              $content .= $audio_tag;
              $content .= $link_tag;
            $content .= '</div>';
            
            ?>

            oum_location = {
              lat: `<?php echo esc_attr($location["lat"]); ?>`,
              lng: `<?php echo esc_attr($location["lng"]); ?>`,
              content: `<?php echo $content; ?>`,
              icon: `<?php echo esc_attr($location["icon"]); ?>`,
              type: `<?php echo isset($location["type_term_id"]) ? esc_attr($location["type_term_id"]) : ''; ?>`,
            };

            <?php if(isset($location["type_term_id"])): ?>

              if(oum_location.type) {
                if(!locations_by_type.hasOwnProperty(oum_location.type)) {
                  locations_by_type[oum_location.type] = {
                    name: `<?php echo esc_attr($location["type_name"]); ?>`,
                    icon: `<?php echo esc_attr($location["icon"]); ?>`,
                    locations : []
                  };
                }
                locations_by_type[oum_location.type].locations.push(oum_location);
              }

            <?php else: ?>

              locations_without_type.push(oum_location);

            <?php endif; ?>

          <?php endforeach; ?>

          //console.log(locations_by_type);

          var start_lat = `<?php echo esc_attr($start_lat); ?>`;
          var start_lng = `<?php echo esc_attr($start_lng); ?>`;
          var start_zoom = `<?php echo esc_attr($start_zoom); ?>`;
        }

      </script>
    </div>

  </div>