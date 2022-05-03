<div class="wrap">
<h1>Open User Map</h1>

<form method="post" action="options.php">
    <?php settings_fields('open-user-map-settings-group');?>
    <?php do_settings_sections('open-user-map-settings-group');?>

    <!-- NAV -->
    <nav class="nav-tab-wrapper">
      <a href="#tab-1" class="nav-tab nav-tab-active"><?php echo __('Design', 'open-user-map'); ?></a>
      <a href="#tab-2" class="nav-tab"><?php echo __('General', 'open-user-map'); ?></a>
      <a href="#tab-3" class="nav-tab"><?php echo __('Form Settings', 'open-user-map'); ?></a>
      <a href="#tab-4" class="nav-tab"><?php echo __('Help', 'open-user-map'); ?></a>
    </nav>


    <!-- TABS -->
    <div class="tab-content">
      
      <div id="tab-1" class="tab-pane active">
        <table class="form-table">

          <tr valign="top">
            <th scope="row">
              <?php echo __('Map Style', 'open-user-map'); ?>
            </th>
            <td>
              <div class="map_styles">
              <?php
              $map_style = get_option('oum_map_style') ? get_option('oum_map_style') : 'Esri.WorldStreetMap';
              $items = $this->map_styles;

              //pro map styles
              $pro_items = $this->pro_map_styles;

              foreach($items as $val => $label) {
                $selected = ($map_style==$val) ? 'checked' : '';
                echo "<label class='$selected'><div class='map_style_preview' data-style='$val'></div><input type='radio' name='oum_map_style' $selected value='$val'></label>";
              }

              ?>

              <?php
              foreach($pro_items as $val => $label) {
                $selected = ($map_style==$val) ? 'checked' : '';
                echo "<label class='$selected'><div class='map_style_preview' data-style='$val'></div><input type='radio' name='oum_map_style' $selected value='$val'></label>";
              }
              ?>
              </div>

            </td>
          </tr>

          <tr valign="top">
            <th scope="row">
              <?php echo __('Marker Icon', 'open-user-map'); ?>
            </th>
            <td>
              <div class="marker_icons">
                <?php
                $marker_icon = get_option('oum_marker_icon') ? get_option('oum_marker_icon') : 'default';
                $items = $this->marker_icons;

                foreach($items as $val) {
                  $selected = ($marker_icon==$val) ? 'checked' : '';
                  echo "<label class='$selected'><div class='marker_icon_preview' data-style='$val'></div><input type='radio' name='oum_marker_icon' $selected value='$val'></label>";
                }

                ?>

                <?php if ( oum_fs()->is__premium_only() ): ?>
                  <?php if ( oum_fs()->can_use_premium_code() ): ?>

                    <?php
                    //pro marker icons
                    $marker_user_icon = get_option('oum_marker_user_icon');
                    $pro_items = $this->pro_marker_icons;

                    foreach($pro_items as $val) {
                      $selected = ($marker_icon==$val) ? 'checked' : '';
                      $user_icon_style = ($marker_user_icon) ? "style='background-image: url($marker_user_icon)'" : "";
                      echo "<label class='$selected pro label_marker_user_icon'><div id='oum_marker_user_icon_preview' class='marker_icon_preview' data-style='$val' " . $user_icon_style . "></div><input type='radio' name='oum_marker_icon' $selected value='$val'>";

                      echo "
                        <div class='icon_upload'>
                          <a href='#' class='oum_upload_icon_button button button-secondary'>" . __('Upload Icon', 'open-user-map') . "</a>
                          <p class='description'>PNG, 50 x 82 Pixel</p>
                          <input type='hidden' id='oum_marker_user_icon' name='oum_marker_user_icon' value='" . esc_attr($marker_user_icon) . "'></input>
                        </div>
                      ";

                      echo "</label>";
                    }
                    ?>

                  <?php endif; ?>
                <?php endif; ?>

                <?php if ( !oum_fs()->can_use_premium_code() ) : ?>

                  <?php
                  //pro marker icons
                  $pro_items = $this->pro_marker_icons;

                  foreach($pro_items as $val) {
                    echo "<label class='pro-only label_marker_user_icon'><div class='marker_icon_preview' data-style='$val'></div>";

                    echo "
                      <div class='icon_upload'>
                        <button disabled class='button button-secondary'>" . __('Upload Icon', 'open-user-map') . "</button>
                        <p class='description'>PNG, 50 x 82 Pixel</p>
                      </div>
                    ";

                    echo "<a class='oum-gopro-text' href='" . oum_fs()->get_upgrade_url() . "'>" . __('Upgrade to PRO to use custom icons.', 'open-user-map') . "</a>";

                    echo "</label>";
                  }
                  ?>

                <?php endif; ?>

              </div>
            </td>
          </tr>

          <tr valign="top">
            <th scope="row">
              <?php echo __('Map size', 'open-user-map'); ?>
            </th>
            <td>
              <select name="oum_map_size" id="oum_map_size">
                <?php
                $map_size = get_option('oum_map_size') ? get_option('oum_map_size') : 'default';
                $oum_map_height = get_option('oum_map_height');
                $items = $this->oum_map_sizes;

                foreach($items as $val => $label) {
                  $selected = ($map_size==$val) ? 'selected' : '';
                  echo "<option value='$val' $selected>$label</option>";
                }
                ?>
              </select>
              <br><br>
              <strong><?php echo __('Custom Height:', 'open-user-map'); ?></strong><br>
              <input class="regular-text" type="text" name="oum_map_height" id="oum_map_height" placeholder="e.g. 400px" value="<?php echo esc_attr($oum_map_height); ?>">
            </td>
          </tr>

          <tr valign="top">
            <th scope="row">
              <?php echo __('Map size (mobile)', 'open-user-map'); ?>
            </th>
            <td>
              <select name="oum_map_size_mobile" id="oum_map_size_mobile">
                <?php
                $map_size = get_option('oum_map_size_mobile') ? get_option('oum_map_size_mobile') : 'default';
                $oum_map_height_mobile = get_option('oum_map_height_mobile');
                $items = $this->oum_map_sizes_mobile;

                foreach($items as $val => $label) {
                  $selected = ($map_size==$val) ? 'selected' : '';
                  echo "<option value='$val' $selected>$label</option>";
                }
                ?>
              </select>
              <br><br>
              <strong><?php echo __('Custom Height:', 'open-user-map'); ?></strong><br>
              <input class="regular-text" type="text" name="oum_map_height_mobile" id="oum_map_height_mobile" placeholder="e.g. 400px" value="<?php echo esc_attr($oum_map_height_mobile); ?>">
            </td>
          </tr>

          <tr valign="top">
            <?php
            $oum_disable_cluster = get_option('oum_disable_cluster');
            ?>
            <th scope="row"><?php echo __('Don\'t group markers that are close to each other (Clustering). ', 'open-user-map'); ?></th>
            <td>
              <input class="oum-switch" type="checkbox" name="oum_disable_cluster" id="oum_disable_cluster" <?php echo ($oum_disable_cluster)? 'checked' : ''; ?>>
              <label for="oum_disable_cluster"></label><br><br>
            </td>
          </tr>

          <?php if ( oum_fs()->is__premium_only() ): ?>
            <?php if ( oum_fs()->can_use_premium_code() ): ?>

              <tr valign="top">
                <?php
                $oum_ui_color = get_option('oum_ui_color') ? get_option('oum_ui_color') : $this->oum_ui_color_default;
                ?>
                <th scope="row">
                  <?php echo __('UI Elements color', 'open-user-map'); ?>
                  <br><span class="oum-pro">PRO</span><br>
                </th>
                <td>
                  <div id="oum_ui_color_wrap">
                    <input type="text" class="oum_colorpicker" name="oum_ui_color" value="<?php echo esc_attr($oum_ui_color); ?>" placeholder="<?php echo esc_attr($oum_ui_color); ?>"></input>
                  </div>
                </td>
              </tr>

            <?php endif; ?>
          <?php endif; ?>

          <?php if ( !oum_fs()->can_use_premium_code() ) : ?>

            <tr valign="top" class="oum-gopro-tr">
              <?php
                $oum_ui_color = $this->oum_ui_color_default;
              ?>
              <th scope="row">
                <?php echo __('UI Elements color', 'open-user-map'); ?>
                <br><span class="oum-pro">PRO</span><br>
                <a class="oum-gopro-text" href="<?php echo oum_fs()->get_upgrade_url(); ?>"><?php echo __('Upgrade to PRO to set a custom color for buttons and icons.', 'open-user-map'); ?></a>
              </th>
              <td>
                <div id="oum_ui_color_wrap">
                  <input disabled type="text" class="oum_colorpicker" value="<?php echo esc_attr($oum_ui_color); ?>" placeholder="<?php echo esc_attr($oum_ui_color); ?>"></input>
                </div>
              </td>
            </tr>

          <?php endif; ?>

          <tr valign="top">
            <?php
            $oum_disable_fullscreen = get_option('oum_disable_fullscreen');
            ?>
            <th scope="row"><?php echo __('Disable fullscreen control', 'open-user-map'); ?></th>
            <td>
              <input class="oum-switch" type="checkbox" name="oum_disable_fullscreen" id="oum_disable_fullscreen" <?php echo ($oum_disable_fullscreen)? 'checked' : ''; ?>>
              <label for="oum_disable_fullscreen"></label><br><br>
            </td>
          </tr>

          <?php if ( oum_fs()->is__premium_only() ): ?>
            <?php if ( oum_fs()->can_use_premium_code() ): ?>

              <tr valign="top">
                <?php
                $oum_enable_currentlocation = get_option('oum_enable_currentlocation');
                ?>
                <th scope="row">
                  <?php echo __('Enable current user location control', 'open-user-map'); ?>
                  <br><span class="oum-pro">PRO</span><br>
                </th>
                <td>
                  <input class="oum-switch" type="checkbox" name="oum_enable_currentlocation" id="oum_enable_currentlocation" <?php echo ($oum_enable_currentlocation)? 'checked' : ''; ?>>
                  <label for="oum_enable_currentlocation"></label><br><br>
                </td>
              </tr>

            <?php endif; ?>
          <?php endif; ?>

          <?php if ( !oum_fs()->can_use_premium_code() ) : ?>

            <tr valign="top" class="oum-gopro-tr">
              <th scope="row">
                <?php echo __('Enable current user location control', 'open-user-map'); ?>
                <br><span class="oum-pro">PRO</span><br>
                <a class="oum-gopro-text" href="<?php echo oum_fs()->get_upgrade_url(); ?>"><?php echo __('Upgrade to PRO and display a button to get the users current location.', 'open-user-map'); ?></a>
              </th>
              <td>
                <input class="oum-switch" type="checkbox" disabled>
                <label></label>
              </td>
            </tr>

          <?php endif; ?>

        </table>
      </div>
      
      <div id="tab-2" class="tab-pane">

        <table class="form-table">

          <tr class="top">
            <th scope="row">
              <label for="lat"><?php echo __('Initial Map Focus', 'open-user-map'); ?></label>
            </th>
            <td>
              <?php
              $start_lat = get_option('oum_start_lat');
              $start_lng = get_option('oum_start_lng');
              $start_zoom = get_option('oum_start_zoom');
              ?>
              <div class="form-field geo-coordinates-wrap">
                  <div class="map-wrap">
                      <div id="mapGetInitial" class="leaflet-map map-style_<?php echo esc_attr($map_style); ?>"></div>
                  </div>
                  <div class="input-wrap">
                      <div class="latlng-wrap" style="display: none">
                          <div class="form-field lat-wrap">
                              <label class="meta-label" for="lat">
                                  <?php echo __('Lat', 'open-user-map'); ?>
                              </label>
                              <input type="text" readonly class="widefat" id="oum_start_lat" name="oum_start_lat" value="<?php echo esc_attr($start_lat) ? esc_attr($start_lat) : ''; ?>"></input>
                          </div>
                          <div class="form-field lng-wrap">
                              <label class="meta-label" for="lng">
                                  <?php echo __('Lng', 'open-user-map'); ?>
                              </label>
                              <input type="text" readonly class="widefat" id="oum_start_lng" name="oum_start_lng" value="<?php echo esc_attr($start_lng) ? esc_attr($start_lng) : ''; ?>"></input>
                          </div>
                          <div class="form-field zoom-wrap">
                              <label class="meta-label" for="zoom">
                                  <?php echo __('Zoom', 'open-user-map'); ?>
                              </label>
                              <input type="number" readonly min="0" max="19" class="widefat" id="oum_start_zoom" name="oum_start_zoom" value="<?php echo esc_attr($start_zoom) ? esc_attr($start_zoom) : ''; ?>"></input>
                          </div>
                      </div>

                      <div class="geo-coordinates-hint">
                          <strong><?php echo __('How to adjust the initial view:', 'open-user-map'); ?></strong>
                          <ol>
                              <li><?php echo __('Use the map on the left to find your spot', 'open-user-map'); ?></li>
                              <li><?php echo __('Zoom and move the map to find the perfect view', 'open-user-map'); ?></li>
                          </ol>
                      </div>
                  </div>

                  <script>
                  const lat = '<?php echo esc_attr($start_lat) ? esc_attr($start_lat) : '0'; ?>';
                  const lng = '<?php echo esc_attr($start_lng) ? esc_attr($start_lng) : '0'; ?>';
                  const zoom = '<?php echo esc_attr($start_zoom) ? esc_attr($start_zoom) : '1'; ?>';
                  const mapStyle = '<?php echo $map_style; ?>';
                  </script>

                  <?php wp_enqueue_script('oum_backend_settings_js', $this->plugin_url . 'src/js/backend-settings.js', array('wp-polyfill', 'oum_leaflet_geosearch_js'), $this->plugin_version); ?>
                  
              </div>
            </td>
          </tr>

          <tr valign="top">
            <?php
            $oum_disable_add_location = get_option('oum_disable_add_location');
            ?>
            <th scope="row">
              <?php echo __('Disable „Add location“ in the frontend', 'open-user-map'); ?>
            </th>
            <td>
              <input class="oum-switch" type="checkbox" id="oum_disable_add_location" name="oum_disable_add_location" <?php echo ($oum_disable_add_location == 'on') ? 'checked' : ''; ?>>
              <label for="oum_disable_add_location"></label><br><br>
            </td>
          </tr>

          <tr valign="top">
            <?php
            $oum_plus_button_label = get_option('oum_plus_button_label');
            ?>
            <th scope="row"><?php echo __('„Add location“-Button text"', 'open-user-map'); ?></th>
            <td>
              <input class="regular-text" type="text" name="oum_plus_button_label" id="oum_plus_button_label" placeholder="<?php echo __('Add location', 'open-user-map'); ?>" value="<?php echo $oum_plus_button_label; ?>"></input><br>
            </td>
          </tr>

          <?php if ( oum_fs()->is__premium_only() ): ?>
            <?php if ( oum_fs()->can_use_premium_code() ): ?>

              <tr valign="top">
                <?php
                $oum_enable_user_restriction = get_option('oum_enable_user_restriction');
                $oum_enable_redirect_to_registration = get_option('oum_enable_redirect_to_registration');
                ?>
                <th scope="row">
                  <?php echo __('Restrict „Add location“ to registered users only', 'open-user-map'); ?>
                  <br><span class="oum-pro">PRO</span><br>
                </th>
                <td>
                  <input class="oum-switch" type="checkbox" id="oum_enable_user_restriction" name="oum_enable_user_restriction" <?php echo ($oum_enable_user_restriction == 'on') ? 'checked' : ''; ?>>
                  <label for="oum_enable_user_restriction"></label><br><br>
                  <div id="redirect_to_registration">
                    <input class="oum-switch" type="checkbox" id="oum_enable_redirect_to_registration" name="oum_enable_redirect_to_registration" <?php echo ($oum_enable_redirect_to_registration == 'on') ? 'checked' : ''; ?>>
                    <label for="oum_enable_redirect_to_registration"><?php echo __('Redirect „Add location“-Button to registration page'); ?></label><br><br>
                  </div>
                </td>
              </tr>

            <?php endif; ?>
          <?php endif; ?>

          <?php if ( !oum_fs()->can_use_premium_code() ) : ?>
            
            <tr valign="top" class="oum-gopro-tr">
              <th scope="row">
                <?php echo __('Restrict „Add location“ to registered users only', 'open-user-map'); ?>
                <br><span class="oum-pro">PRO</span><br>
                <a class="oum-gopro-text" href="<?php echo oum_fs()->get_upgrade_url(); ?>"><?php echo __('Upgrade to PRO to enable the „Add location“ feature only to logged in users!', 'open-user-map'); ?></a>
              </th>
              <td>
                <input class="oum-switch" type="checkbox" disabled>
                <label></label><br><br>
                <input class="oum-switch" type="checkbox" disabled>
                <label><?php echo __('Redirect „Add location“-Button to registration page'); ?></label><br><br>
              </td>
            </tr>

          <?php endif; ?>

          <?php if ( oum_fs()->is__premium_only() ): ?>
            <?php if ( oum_fs()->can_use_premium_code() ): ?>

              <tr valign="top">
                <?php
                $oum_enable_auto_publish = get_option('oum_enable_auto_publish');
                ?>
                <th scope="row">
                  <?php echo __('Auto-Publish for registered users', 'open-user-map'); ?>
                  <br><span class="oum-pro">PRO</span><br>
                </th>
                <td>
                  <input class="oum-switch" type="checkbox" id="oum_enable_auto_publish" name="oum_enable_auto_publish" <?php echo ($oum_enable_auto_publish == 'on') ? 'checked' : ''; ?>>
                  <label for="oum_enable_auto_publish"></label><br><br>
                  <span class="description"><?php echo __('This works only for users with "edit posts" capabilities.', 'open-user-map'); ?></span><br><br>
                </td>
              </tr>

            <?php endif; ?>
          <?php endif; ?>

          <?php if ( !oum_fs()->can_use_premium_code() ) : ?>
            
            <tr valign="top" class="oum-gopro-tr">
              <th scope="row">
                <?php echo __('Auto-publish for registered users', 'open-user-map'); ?>
                <br><span class="oum-pro">PRO</span><br>
                <a class="oum-gopro-text" href="<?php echo oum_fs()->get_upgrade_url(); ?>"><?php echo __('Upgrade to PRO to auto-publish location proposals from registered users without your approval!', 'open-user-map'); ?></a>
              </th>
              <td>
                <input class="oum-switch" type="checkbox" disabled>
                <label></label><br><br>
                <span class="description"><?php echo __('This works only for users with "edit posts" capabilities.', 'open-user-map'); ?></span><br><br>
              </td>
            </tr>

          <?php endif; ?>

          <?php if ( oum_fs()->is__premium_only() ): ?>
            <?php if ( oum_fs()->can_use_premium_code() ): ?>

              <tr valign="top">
                <?php
                $oum_enable_auto_publish_for_everyone = get_option('oum_enable_auto_publish_for_everyone');
                ?>
                <th scope="row">
                  <?php echo __('Auto-Publish for unregistered users', 'open-user-map'); ?>
                  <br><span class="oum-pro">PRO</span><br>
                </th>
                <td>
                  <input class="oum-switch" type="checkbox" id="oum_enable_auto_publish_for_everyone" name="oum_enable_auto_publish_for_everyone" <?php echo ($oum_enable_auto_publish_for_everyone == 'on') ? 'checked' : ''; ?>>
                  <label for="oum_enable_auto_publish_for_everyone"></label><br><br>
                  <span class="description"><strong><?php echo __('USE WITH CAUTION!', 'open-user-map'); ?></strong> <?php echo __('Every location proposal will be published directly without your verification. No user registration is necessary.', 'open-user-map'); ?></span><br><br>
                </td>
              </tr>

            <?php endif; ?>
          <?php endif; ?>

          <?php if ( !oum_fs()->can_use_premium_code() ) : ?>
            
            <tr valign="top" class="oum-gopro-tr">
              <th scope="row">
                <?php echo __('Auto-publish for registered users', 'open-user-map'); ?>
                <br><span class="oum-pro">PRO</span><br>
                <a class="oum-gopro-text" href="<?php echo oum_fs()->get_upgrade_url(); ?>"><?php echo __('Upgrade to PRO to auto-publish location proposals from unregistered users without your approval!', 'open-user-map'); ?></a>
              </th>
              <td>
                <input class="oum-switch" type="checkbox" disabled>
                <label></label><br><br>
                <span class="description"><strong><?php echo __('USE WITH CAUTION!', 'open-user-map'); ?></strong> <?php echo __('Every location proposal will be published directly without your verification. No user registration is necessary.', 'open-user-map'); ?></span><br><br>
              </td>
            </tr>

          <?php endif; ?>

          <?php if ( oum_fs()->is__premium_only() ): ?>
            <?php if ( oum_fs()->can_use_premium_code() ): ?>

              <tr valign="top">
                <?php
                $oum_enable_add_user_location = get_option('oum_enable_add_user_location');
                ?>
                <th scope="row">
                  <?php echo __('Extend WordPress user registration form with „Add location“ map', 'open-user-map'); ?>
                  <br><span class="oum-pro">PRO</span><br>
                </th>
                <td>
                  <input class="oum-switch" type="checkbox" id="oum_enable_add_user_location" name="oum_enable_add_user_location" <?php echo ($oum_enable_add_user_location == 'on') ? 'checked' : ''; ?>>
                  <label for="oum_enable_add_user_location"></label><br><br>
                </td>
              </tr>

            <?php endif; ?>
          <?php endif; ?>

          <?php if ( !oum_fs()->can_use_premium_code() ) : ?>
            
            <tr valign="top" class="oum-gopro-tr">
              <th scope="row">
                <?php echo __('Extend WordPress user registration form with „Add location“ map', 'open-user-map'); ?>
                <br><span class="oum-pro">PRO</span><br>
                <a class="oum-gopro-text" href="<?php echo oum_fs()->get_upgrade_url(); ?>"><?php echo __('Upgrade to PRO to allow users to add their location within registration. Create a map of your registered users!', 'open-user-map'); ?></a>
              </th>
              <td>
                <input class="oum-switch" type="checkbox" disabled>
                <label></label>
              </td>
            </tr>

          <?php endif; ?>

          <?php if ( oum_fs()->is__premium_only() ): ?>
            <?php if ( oum_fs()->can_use_premium_code() ): ?>

              <tr valign="top">
                <?php
                $oum_enable_single_page = get_option('oum_enable_single_page');
                ?>
                <th scope="row">
                  <?php echo __('Public pages for locations', 'open-user-map'); ?>
                  <br><span class="oum-pro">PRO</span><br>
                </th>
                <td>
                  <input class="oum-switch" type="checkbox" id="oum_enable_single_page" name="oum_enable_single_page" <?php echo ($oum_enable_single_page == 'on') ? 'checked' : ''; ?>>
                  <label for="oum_enable_single_page"></label><br><br>
                  <span class="description"><?php echo __('This will add a "Read more"-Button to the location bubble. It will link to the location\'s single page. A content editor will become available.', 'open-user-map'); ?></span><br><br>
                </td>
              </tr>

            <?php endif; ?>
          <?php endif; ?>

          <?php if ( !oum_fs()->can_use_premium_code() ) : ?>
            
            <tr valign="top" class="oum-gopro-tr">
              <th scope="row">
                <?php echo __('Public pages for locations', 'open-user-map'); ?>
                <br><span class="oum-pro">PRO</span><br>
                <a class="oum-gopro-text" href="<?php echo oum_fs()->get_upgrade_url(); ?>"><?php echo __('Upgrade to PRO to enable single pages.', 'open-user-map'); ?></a>
              </th>
              <td>
                <input class="oum-switch" type="checkbox" disabled>
                <label></label><br><br>
                <span class="description"><?php echo __('This will add a "Read more"-Button to the location bubble. It will link to the location\'s single page. A content editor will become available.', 'open-user-map'); ?></span><br><br>
              </td>
            </tr>

          <?php endif; ?>

          <?php if ( oum_fs()->is__premium_only() ): ?>
            <?php if ( oum_fs()->can_use_premium_code() ): ?>

              <tr valign="top">
                <?php
                $oum_enable_admin_notification = get_option('oum_enable_admin_notification');
                $oum_admin_notification_email = get_option('oum_admin_notification_email') ? get_option('oum_admin_notification_email') : get_option('admin_email');
                $oum_admin_notification_subject = get_option('oum_admin_notification_subject') ? get_option('oum_admin_notification_subject') : __('New Open User Map location', 'open-user-map');
                $oum_admin_notification_message = get_option('oum_admin_notification_message') ? get_option('oum_admin_notification_message') : __('A new location with the title "%title%" on %website_url% has been added! Please verify and publish or use the "auto-publish" feature.', 'open-user-map');
                ?>
                <th scope="row">
                  <?php echo __('Admin email notification', 'open-user-map'); ?>
                  <br><span class="oum-pro">PRO</span><br>
                </th>
                <td>
                  <input class="oum-switch" type="checkbox" id="oum_enable_admin_notification" name="oum_enable_admin_notification" <?php echo ($oum_enable_admin_notification == 'on') ? 'checked' : ''; ?>>
                  <label for="oum_enable_admin_notification"><?php echo __('Enable'); ?></label><br><br>
                  
                  <strong><?php echo __('Email address'); ?>:</strong><br>
                  <input class="regular-text" type="text" name="oum_admin_notification_email" id="oum_admin_notification_email" value="<?php echo $oum_admin_notification_email; ?>"></input><br><br>

                  <strong><?php echo __('Subject'); ?>:</strong><br>
                  <input class="regular-text" type="text" name="oum_admin_notification_subject" id="oum_admin_notification_subject" value="<?php echo $oum_admin_notification_subject; ?>"></input><br><br>

                  <strong><?php echo __('Message'); ?>:</strong><br>
                  <textarea class="regular-text" name="oum_admin_notification_message" id="oum_admin_notification_message" rows="8" cols="50"><?php echo $oum_admin_notification_message; ?></textarea><br>
                  <span class="description"><?php echo __('Available tags'); ?>: %title%, %website_url%, %website_name%</span>
                  <br><br>
                </td>
              </tr>

            <?php endif; ?>
          <?php endif; ?>

          <?php if ( !oum_fs()->can_use_premium_code() ) : ?>
            
            <tr valign="top" class="oum-gopro-tr">
              <th scope="row">
                <?php echo __('Admin email notification', 'open-user-map'); ?>
                <br><span class="oum-pro">PRO</span><br>
                <a class="oum-gopro-text" href="<?php echo oum_fs()->get_upgrade_url(); ?>"><?php echo __('Upgrade to PRO to get notified instantly when a new location proposal has been added!', 'open-user-map'); ?></a>
              </th>
              <td>
                <input class="oum-switch" type="checkbox" disabled>
                <label></label><br><br>
                
                <strong><?php echo __('Email address'); ?>:</strong><br>
                <input disabled class="regular-text" type="text" placeholder="<?php echo __('john@doe.com', 'open-user-map'); ?>"></input><br><br>
                
                <strong><?php echo __('Subject'); ?>:</strong><br>
                <input disabled class="regular-text" type="text" placeholder="<?php echo __('New Open User Map location', 'open-user-map'); ?>"></input><br><br>

                <strong><?php echo __('Message'); ?>:</strong><br>
                <textarea disabled class="regular-text" rows="8" cols="50" placeholder="<?php echo __('A new location with the title "%title%" on %website_url% has been added! Please verify and publish or use the "auto-publish" feature.', 'open-user-map'); ?>"></textarea><br><br>
                <span class="description"><?php echo __('Available tags'); ?>: %title%, %website_url%, %website_name%</span>
                <br><br>
              </td>
            </tr>

          <?php endif; ?>

        </table>

      </div>

      <div id="tab-3" class="tab-pane">

        <table class="form-table">

          <tr valign="top">
            <?php
            $oum_form_headline = get_option('oum_form_headline');
            ?>
            <th scope="row"><?php echo __('Headline', 'open-user-map'); ?></th>
            <td>
              <input class="regular-text" type="text" name="oum_form_headline" id="oum_form_headline" placeholder="<?php echo __('Add a new location', 'open-user-map'); ?>" value="<?php echo $oum_form_headline; ?>"></input><br>
            </td>
          </tr>

          <tr valign="top">
            <?php
            $oum_disable_title = get_option('oum_disable_title');
            $oum_title_required = get_option('oum_title_required', 'on');
            $oum_title_label = get_option('oum_title_label');
            ?>
            <th scope="row"><?php echo __('"Title" field', 'open-user-map'); ?></th>
            <td>
              <div class="oum_2cols">
                <div>
                  <input class="oum-switch" type="checkbox" name="oum_disable_title" id="oum_disable_title" <?php echo ($oum_disable_title)? 'checked' : ''; ?>>
                  <label for="oum_disable_title"><?php echo __('Disable', 'open-user-map'); ?></label>
                </div>
                <div>
                  <input class="oum-switch" type="checkbox" name="oum_title_required" id="oum_title_required" <?php echo ($oum_title_required)? 'checked' : ''; ?>>
                  <label for="oum_title_required"><?php echo __('Required', 'open-user-map'); ?></label>
                </div>
                <div>
                  <input class="small-text oum_title_maxlength" type="number" min="0" name="oum_title_maxlength" value="<?php echo isset($oum_title_maxlength) ? esc_attr($oum_title_maxlength) : ''; ?>" />
                  <label for="oum_title_maxlength"><?php echo __('Max. length', 'open-user-map'); ?></label>
                </div>
              </div>
              <br>
              <strong><?php echo __('Custom Label:', 'open-user-map'); ?></strong><br>
              <input class="regular-text" type="text" name="oum_title_label" id="oum_title_label" placeholder="<?php echo esc_attr($this->oum_title_label_default); ?>" value="<?php echo esc_attr($oum_title_label); ?>">
              <br><br>
            </td>
          </tr>

          <tr valign="top">
            <?php
            $oum_map_label = get_option('oum_map_label');
            $oum_searchaddress_label = get_option('oum_searchaddress_label');
            ?>
            <th scope="row"><?php echo __('"Map" field', 'open-user-map'); ?></th>
            <td>
              <strong><?php echo __('Custom Label:', 'open-user-map'); ?></strong><br>
              <input class="regular-text" type="text" name="oum_map_label" id="oum_map_label" placeholder="<?php echo esc_attr($this->oum_map_label_default); ?>" value="<?php echo esc_attr($oum_map_label); ?>">
              <br><br>
              <strong><?php echo __('Custom Label for Search field:', 'open-user-map'); ?></strong><br>
              <input class="regular-text" type="text" name="oum_searchaddress_label" id="oum_searchaddress_label" placeholder="<?php echo esc_attr($this->oum_searchaddress_label_default); ?>" value="<?php echo esc_attr($oum_searchaddress_label); ?>">
              <br><br>
            </td>
          </tr>

          <?php if ( oum_fs()->is__premium_only() ): ?>
            <?php if ( oum_fs()->can_use_premium_code() ): ?>

              <tr valign="top">
                <?php
                $oum_enable_marker_types = get_option('oum_enable_marker_types');
                $oum_marker_types_label = get_option('oum_marker_types_label') ? get_option('oum_marker_types_label') : $this->oum_marker_types_label_default;
                ?>
                <th scope="row">
                  <?php echo __('"Types" field (marker categories with individual marker icons)', 'open-user-map'); ?>
                  <br><span class="oum-pro">PRO</span><br>
                </th>
                <td>
                  <input class="oum-switch" type="checkbox" name="oum_enable_marker_types" id="oum_enable_marker_types" <?php echo ($oum_enable_marker_types)? 'checked' : ''; ?>>
                  <label for="oum_enable_marker_types"><?php echo __('Enable', 'open-user-map'); ?></label><br><br>
                  <div class="description"><?php echo __('You can manage types <a href="edit-tags.php?taxonomy=oum-type&post_type=oum-location">here</a>', 'open-user-map'); ?></div>
                  <br>
                  <strong><?php echo __('Custom Label:', 'open-user-map'); ?></strong><br>
                  <input class="regular-text" type="text" name="oum_marker_types_label" id="oum_marker_types_label" placeholder="<?php echo esc_attr($this->oum_marker_types_label_default); ?>" value="<?php echo esc_attr($oum_marker_types_label); ?>">
                  <br><br>
                </td>
              </tr>

            <?php endif; ?>
          <?php endif; ?>

          <?php if ( !oum_fs()->can_use_premium_code() ) : ?>

            <tr valign="top" class="oum-gopro-tr">
              <th scope="row">
                <?php echo __('"Types" field (marker categories with individual marker icons)', 'open-user-map'); ?>
                <br><span class="oum-pro">PRO</span><br>
                <a class="oum-gopro-text" href="<?php echo oum_fs()->get_upgrade_url(); ?>"><?php echo __('Upgrade to PRO and use marker categories. Each category can have a custom marker icon.', 'open-user-map'); ?></a>
              </th>
              <td>
                <input class="oum-switch" type="checkbox" disabled>
                <label><?php echo __('Enable', 'open-user-map'); ?></label>
                <br>
                <br>
                <strong><?php echo __('Custom Label:', 'open-user-map'); ?></strong><br>
                <input disabled class="regular-text" type="text" value="" placeholder="<?php echo esc_attr($this->oum_marker_types_label_default); ?>">
                <br><br>
              </td>
            </tr>

          <?php endif; ?>

          <tr valign="top">
            <th scope="row">
              <?php echo __('Custom fields', 'open-user-map'); ?>
              <?php if ( !oum_fs()->can_use_premium_code() ) : ?>

                <br><span class="oum-pro">PRO</span><br>
                <a class="oum-gopro-text" href="<?php echo oum_fs()->get_upgrade_url(); ?>"><?php echo __('Upgrade to PRO to use various field types like links, checkboxes, radio buttons and dropdowns', 'open-user-map'); ?></a>

              <?php endif; ?>
            </th>
            <td>
              <div class="oum_custom_fields_wrapper">
                <?php
                  $oum_custom_fields = get_option('oum_custom_fields');
                ?>
                <table>
                  <thead>
                    <tr>
                      <th><?php echo __('Label', 'open-user-map'); ?></th>
                      <th><?php echo __('Required', 'open-user-map'); ?></th>
                      <th><?php echo __('Max. length', 'open-user-map'); ?></th>
                      <th><?php echo __('Field type', 'open-user-map'); ?> <span class="oum-pro">PRO</span></th>
                      <th><?php echo __('Options', 'open-user-map'); ?></th>
                      <th><?php echo __('Description', 'open-user-map'); ?></th>
                      <th></th>
                    </tr>
                  </thead>

                  <tbody>
                  <?php if(is_array($oum_custom_fields)): ?>
                    <?php foreach($oum_custom_fields as $index => $custom_field): ?>
                      <tr>
                        <td>
                          <input type="text" class="field-type-text field-type-link field-type-checkbox field-type-radio field-type-select" name="oum_custom_fields[<?php echo $index; ?>][label]" placeholder="<?php echo __('Enter label', 'open-user-map'); ?>" value="<?php echo esc_attr($custom_field['label']); ?>" />
                        </td>
                        <td>
                          <input class="oum-switch field-type-text field-type-link field-type-checkbox field-type-radio field-type-select" id="oum_custom_fields_<?php echo $index; ?>" type="checkbox" name="oum_custom_fields[<?php echo $index; ?>][required]" <?php echo (isset($custom_field['required']))? 'checked' : '';?> /><label class="field-type-text field-type-link field-type-checkbox field-type-radio field-type-select" for="oum_custom_fields_<?php echo $index; ?>"></label>
                        </td>
                        <td>
                          <input class="small-text field-type-text field-type-link" type="number" min="0" name="oum_custom_fields[<?php echo $index; ?>][maxlength]" value="<?php echo isset($custom_field['maxlength']) ? esc_attr($custom_field['maxlength']) : ''; ?>" />
                        </td>
                        <td>
                          <select class="oum-custom-field-fieldtype" name="oum_custom_fields[<?php echo $index; ?>][fieldtype]">
                            <?php
                            $available_field_types = $this->oum_custom_field_fieldtypes;
                            ?>

                            <?php if ( oum_fs()->is__premium_only() ): ?>
                              <?php if ( oum_fs()->can_use_premium_code() ): ?>

                                <?php 
                                $available_field_types = array_merge($available_field_types, $this->pro_oum_custom_field_fieldtypes);
                                ?>

                              <?php endif; ?>
                            <?php endif; ?>

                            <?php foreach($available_field_types as $value => $label): ?>
                              <?php $selected = (isset($custom_field['fieldtype']) && $custom_field['fieldtype'] == $value) ? 'selected' : ''; ?>

                              <option value="<?php echo $value; ?>" <?php echo $selected; ?>><?php echo $label; ?></option>

                            <?php endforeach; ?>
                          </select>
                        </td>
                        <td>
                          <input type="text" class="regular-text field-type-checkbox field-type-radio field-type-select" name="oum_custom_fields[<?php echo $index; ?>][options]" placeholder="Red|Blue|Green" value="<?php echo isset($custom_field['options']) ? esc_attr($custom_field['options']) : ''; ?>" />
                          <label class="field-type-select oum-custom-field-allow-empty"><input class="field-type-select" type="checkbox" name="oum_custom_fields[<?php echo $index; ?>][emptyoption]" <?php echo isset($custom_field['emptyoption']) ? 'checked' : ''; ?> ><?php echo __('add empty option', 'open-user-map'); ?></label>
                          <textarea class="regular-text field-type-html" name="oum_custom_fields[<?php echo $index; ?>][html]" placeholder="Enter HTML here"><?php echo isset($custom_field['html']) ? esc_attr($custom_field['html']) : ''; ?></textarea>
                        </td>
                        <td>
                          <input type="text" class="field-type-text field-type-link field-type-checkbox field-type-radio field-type-select" name="oum_custom_fields[<?php echo $index; ?>][description]" placeholder="<?php echo __('Enter description (optional)', 'open-user-map'); ?>" value="<?php echo isset($custom_field['description']) ? esc_attr($custom_field['description']) : ''; ?>" />
                        </td>
                        <td class="actions">
                          <a class="up" href="#"><span class="dashicons dashicons-arrow-up"></span></a>
                          <a class="down" href="#"><span class="dashicons dashicons-arrow-down"></span></a>
                          <a class="remove_button" href="#"><span class="dashicons dashicons-trash"></span></a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                  </tbody>

                </table>

              </div>
              <div>
                <a href="#" class="oum_add_button button" title="Add field">Add field</a>
              </div>
              <br><br>
            </td>
          </tr>

          <tr valign="top">
            <?php
            $oum_disable_address = get_option('oum_disable_address');
            $oum_hide_address = get_option('oum_hide_address');
            $oum_disable_gmaps_link = get_option('oum_disable_gmaps_link');
            $oum_address_label = get_option('oum_address_label');
            ?>
            <th scope="row"><?php echo __('"Address" field', 'open-user-map'); ?></th>
            <td>
              <input class="oum-switch" type="checkbox" name="oum_disable_address" id="oum_disable_address" <?php echo ($oum_disable_address)? 'checked' : ''; ?>>
              <label for="oum_disable_address"><?php echo __('Disable', 'open-user-map'); ?></label><br>

              <input class="oum-switch" type="checkbox" name="oum_hide_address" id="oum_hide_address" <?php echo ($oum_hide_address)? 'checked' : ''; ?>>
              <label for="oum_hide_address"><?php echo __('Don\'t show address inside location info', 'open-user-map'); ?></label><br>
              
              <input class="oum-switch" type="checkbox" name="oum_disable_gmaps_link" id="oum_disable_gmaps_link" <?php echo ($oum_disable_gmaps_link)? 'checked' : ''; ?>>
              <label for="oum_disable_gmaps_link"><?php echo __('Don\'t link address to Google Maps', 'open-user-map'); ?></label><br>

              <strong><?php echo __('Custom Label:', 'open-user-map'); ?></strong><br>
              <input class="regular-text" type="text" name="oum_address_label" id="oum_address_label" placeholder="<?php echo esc_attr($this->oum_address_label_default); ?>" value="<?php echo esc_attr($oum_address_label); ?>">
              <br><br>
            </td>
          </tr>

          <tr valign="top">
            <?php
            $oum_disable_description = get_option('oum_disable_description');
            $oum_description_required = get_option('oum_description_required');
            $oum_description_label = get_option('oum_description_label');
            ?>
            <th scope="row"><?php echo __('"Description" field', 'open-user-map'); ?></th>
            <td>
              <div class="oum_2cols">
                <div>
                  <input class="oum-switch" type="checkbox" name="oum_disable_description" id="oum_disable_description" <?php echo ($oum_disable_description)? 'checked' : ''; ?>>
                  <label for="oum_disable_description"><?php echo __('Disable', 'open-user-map'); ?></label>
                </div>
                <div>
                  <input class="oum-switch" type="checkbox" name="oum_description_required" id="oum_description_required" <?php echo ($oum_description_required)? 'checked' : ''; ?>>
                  <label for="oum_description_required"><?php echo __('Required', 'open-user-map'); ?></label>
                </div>
              </div>
              <br>
              <strong><?php echo __('Custom Label:', 'open-user-map'); ?></strong><br>
              <input class="regular-text" type="text" name="oum_description_label" id="oum_description_label" placeholder="<?php echo esc_attr($this->oum_description_label_default); ?>" value="<?php echo esc_attr($oum_description_label); ?>">
              <br><br>
            </td>
          </tr>

          <tr valign="top">
            <?php
            $oum_disable_image = get_option('oum_disable_image');
            $oum_image_required = get_option('oum_image_required');
            ?>
            <th scope="row"><?php echo __('Image upload', 'open-user-map'); ?></th>
            <td>
              <div class="oum_2cols">
                <div>
                  <input class="oum-switch" type="checkbox" name="oum_disable_image" id="oum_disable_image" <?php echo ($oum_disable_image)? 'checked' : ''; ?>>
                  <label for="oum_disable_image"><?php echo __('Disable', 'open-user-map'); ?></label>
                </div>
                <div>
                  <input class="oum-switch" type="checkbox" name="oum_image_required" id="oum_image_required" <?php echo ($oum_image_required)? 'checked' : ''; ?>>
                  <label for="oum_image_required"><?php echo __('Required', 'open-user-map'); ?></label>
                </div>
              </div>
              <br><br>
            </td>
          </tr>

          <tr valign="top">
            <?php
            $oum_disable_audio = get_option('oum_disable_audio');
            $oum_audio_required = get_option('oum_audio_required');
            ?>
            <th scope="row"><?php echo __('Audio upload', 'open-user-map'); ?></th>
            <td>
              <div class="oum_2cols">
                <div>
                  <input class="oum-switch" type="checkbox" name="oum_disable_audio" id="oum_disable_audio" <?php echo ($oum_disable_audio)? 'checked' : ''; ?>>
                  <label for="oum_disable_audio"><?php echo __('Disable', 'open-user-map'); ?></label>
                </div>
                <div>
                  <input class="oum-switch" type="checkbox" name="oum_audio_required" id="oum_audio_required" <?php echo ($oum_audio_required)? 'checked' : ''; ?>>
                  <label for="oum_audio_required"><?php echo __('Required', 'open-user-map'); ?></label>
                </div>
              </div>
              <br><br>
            </td>
          </tr>

          <?php if ( oum_fs()->is__premium_only() ): ?>
            <?php if ( oum_fs()->can_use_premium_code() ): ?>

              <tr valign="top">
                <?php
                $oum_max_image_filesize = get_option('oum_max_image_filesize') ? get_option('oum_max_image_filesize') : 10;
                $oum_max_audio_filesize = get_option('oum_max_audio_filesize') ? get_option('oum_max_audio_filesize') : 10;
                ?>
                <th scope="row">
                  <?php echo __('Max upload size', 'open-user-map'); ?>
                  <br><span class="oum-pro">PRO</span><br>
                </th>
                <td>
                  <div class="oum_2cols">
                    <div>
                      <strong><?php echo __('Image'); ?>:</strong><br>
                      <input class="small-text" type="number" min="1" name="oum_max_image_filesize" id="oum_max_image_filesize" value="<?php echo $oum_max_image_filesize; ?>"></input>MB
                    </div>
                    <div>
                      <strong><?php echo __('Audio'); ?>:</strong><br>
                      <input class="small-text" type="number" min="1" name="oum_max_audio_filesize" id="oum_max_audio_filesize" value="<?php echo $oum_max_audio_filesize; ?>"></input>MB
                    </div>
                  </div>
                  <br><br>
                </td>
              </tr>

            <?php endif; ?>
          <?php endif; ?>

          <?php if ( !oum_fs()->can_use_premium_code() ) : ?>
            
            <tr valign="top" class="oum-gopro-tr">
              <th scope="row">
                <?php echo __('Max upload size', 'open-user-map'); ?>
                <br><span class="oum-pro">PRO</span><br>
                <a class="oum-gopro-text" href="<?php echo oum_fs()->get_upgrade_url(); ?>"><?php echo __('Upgrade to PRO to set the maximum file size for image and audio uploads.', 'open-user-map'); ?></a>
              </th>
              <td>
                <div class="oum_2cols">
                  <div>
                    <strong><?php echo __('Image'); ?>:</strong><br>
                    <input disabled class="small-text" type="number" min="1" value="10"></input>MB
                  </div>
                  <div>
                    <strong><?php echo __('Audio'); ?>:</strong><br>
                    <input disabled class="small-text" type="number" min="1" value="10"></input>MB
                  </div>
                </div>
                <br><br>
              </td>
            </tr>

          <?php endif; ?>

          <?php if ( oum_fs()->is__premium_only() ): ?>
            <?php if ( oum_fs()->can_use_premium_code() ): ?>

              <tr valign="top">
                <?php
                $oum_enable_user_notification = get_option('oum_enable_user_notification');
                $oum_user_notification_subject = get_option('oum_user_notification_subject') ? get_option('oum_user_notification_subject') : __('Your location has been approved', 'open-user-map');
                $oum_user_notification_message = get_option('oum_user_notification_message') ? get_option('oum_user_notification_message') : __('Hey %name%! Your location proposal on %website_url% has been published!', 'open-user-map');
                ?>
                <th scope="row">
                  <?php echo __('User email notification', 'open-user-map'); ?>
                  <br><span class="oum-pro">PRO</span><br>
                </th>
                <td>
                  <input class="oum-switch" type="checkbox" id="oum_enable_user_notification" name="oum_enable_user_notification" <?php echo ($oum_enable_user_notification == 'on') ? 'checked' : ''; ?>>
                  <label for="oum_enable_user_notification"><?php echo __('Enable'); ?></label><br><br>
                  
                  <strong><?php echo __('Subject'); ?>:</strong><br>
                  <input class="regular-text" type="text" name="oum_user_notification_subject" id="oum_user_notification_subject" value="<?php echo $oum_user_notification_subject; ?>"></input><br><br>

                  <strong><?php echo __('Message'); ?>:</strong><br>
                  <textarea class="regular-text" name="oum_user_notification_message" id="oum_user_notification_message" rows="8" cols="50"><?php echo $oum_user_notification_message; ?></textarea><br>
                  <span class="description"><?php echo __('Available tags'); ?>: %name%, %website_url%, %website_name%</span>
                  <br><br>
                </td>
              </tr>

            <?php endif; ?>
          <?php endif; ?>

          <?php if ( !oum_fs()->can_use_premium_code() ) : ?>
            
            <tr valign="top" class="oum-gopro-tr">
              <th scope="row">
                <?php echo __('User email notification', 'open-user-map'); ?>
                <br><span class="oum-pro">PRO</span><br>
                <a class="oum-gopro-text" href="<?php echo oum_fs()->get_upgrade_url(); ?>"><?php echo __('Upgrade to PRO to notify your users after their location proposal has been approved!', 'open-user-map'); ?></a>
              </th>
              <td>
                <input class="oum-switch" type="checkbox" disabled>
                <label></label><br><br>
                
                <strong><?php echo __('Subject'); ?>:</strong><br>
                <input disabled class="regular-text" type="text" placeholder="<?php echo __('Your location has been approved', 'open-user-map'); ?>"></input><br><br>

                <strong><?php echo __('Message'); ?>:</strong><br>
                <textarea disabled class="regular-text" rows="8" cols="50" placeholder="<?php echo __('Hey %name%! Your location proposal on %website_url% has been published!', 'open-user-map'); ?>"></textarea><br><br>
                <span class="description"><?php echo __('Available tags'); ?>: %name%, %website_url%, %website_name%</span>
                <br><br>
              </td>
            </tr>

          <?php endif; ?>

          <tr valign="top">
            <?php
            $oum_submit_button_label = get_option('oum_submit_button_label');
            ?>
            <th scope="row"><?php echo __('Submit-Button text', 'open-user-map'); ?></th>
            <td>
              <input class="regular-text" type="text" name="oum_submit_button_label" id="oum_submit_button_label" placeholder="<?php echo __('Submit location for review', 'open-user-map'); ?>" value="<?php echo $oum_submit_button_label; ?>"></input><br>
            </td>
          </tr>

          <tr valign="top">
            <th scope="row"><?php echo __('Action after submit', 'open-user-map'); ?></th>
            <td>
              <select name="oum_action_after_submit" id="oum_action_after_submit">
                <?php
                $oum_action_after_submit = get_option('oum_action_after_submit') ? get_option('oum_action_after_submit') : 'text';
                $items = array(
                  'text' => __('Display message', 'open-user-map'),
                  'refresh' => __('Refresh', 'open-user-map'),
                  'redirect' => __('Redirect', 'open-user-map')
                );

                foreach($items as $val => $label) {
                  $selected = ($oum_action_after_submit==$val) ? 'selected' : '';
                  echo "<option value='$val' $selected>$label</option>";
                }
                ?>
              </select>
              <br><br>
              <div id="oum_action_after_submit_text">
                <?php
                $oum_thankyou_headline = get_option('oum_thankyou_headline');
                $oum_thankyou_text = get_option('oum_thankyou_text');
                $oum_addanother_label = get_option('oum_addanother_label');
                ?>
                <input class="regular-text" type="text" name="oum_thankyou_headline" id="oum_thankyou_headline" placeholder="<?php echo __('Thank you!', 'open-user-map'); ?>" value="<?php echo $oum_thankyou_headline; ?>"></input><br><br>
                <textarea class="regular-text" name="oum_thankyou_text" id="oum_thankyou_text" rows="4" cols="50" placeholder="<?php echo __('We will check your location suggestion and release it as soon as possible.', 'open-user-map'); ?>"><?php echo $oum_thankyou_text; ?></textarea><br><br>
                <input class="regular-text" type="text" name="oum_addanother_label" id="oum_addanother_label" placeholder="<?php echo esc_attr($this->oum_addanother_label_default); ?>" value="<?php echo esc_attr($oum_addanother_label); ?>">
              </div>
              <div id="oum_action_after_submit_redirect">
                <?php
                $oum_thankyou_redirect = get_option('oum_thankyou_redirect');
                ?>
                <input class="regular-text" type="text" name="oum_thankyou_redirect" id="oum_thankyou_redirect" placeholder="<?php echo 'https://loremipsum.com'; ?>" value="<?php echo $oum_thankyou_redirect; ?>"></input>
              </div>
            </td>
          </tr>

        </table>

      </div>
      
      <div id="tab-4" class="tab-pane">

        <table class="form-table">

          <!-- <tr valign="top">
            <th scope="row"><?php // echo __('Export all locations', 'open-user-map'); ?></th>
            <td>
              <?php
              // $all_oum_locations = get_posts(array(
              //   'post_type' => 'oum-location',
              //   'posts_per_page' => -1,
              //   'fields' => 'ids',
              // ));

              // $locations_list = array();

              // foreach ($all_oum_locations as $post_id) {
              //   // Prepare data
              //   $location_meta = get_post_meta($post_id, '_oum_location_key', true);
            
              //   $name = str_replace("'", "\'", htmlentities(get_the_title($post_id)));
              //   $address = isset($location_meta['address'])? str_replace("'", "\'", (preg_replace('/\r|\n/', '', $location_meta['address']))) : '';
              //   $text = isset($location_meta["text"])? str_replace("'", "\'", str_replace(array("\r\n", "\r", "\n"),"<br>",$location_meta["text"])) : '';
            
              //   $image = get_post_meta($post_id, '_oum_location_image', true);
              //   $audio = get_post_meta($post_id, '_oum_location_audio', true);
            
              //   if (!isset($location_meta['lat']) && !isset($location_meta['lng'])) {
              //       continue;
              //   }
            
              //   $geolocation = array(
              //       'lat' => $location_meta['lat'],
              //       'lng' => $location_meta['lng'],
              //   );
            
              //   // collect locations for JS use
              //   $locations_list[] = array(
              //       'post_id' => $post_id,
              //       'name' => $name,
              //       'address' => $address,
              //       'lat' => $geolocation['lat'],
              //       'lng' => $geolocation['lng'],
              //       'text' => $text,
              //       'image' => $image,
              //       'audio' => $audio,
              //   );
              // }

              // error_log(print_r($locations_list, true));
              ?>

            </td>
          </tr> -->

          <tr valign="top">
            <th scope="row"><?php echo __('Place the shortcode anywhere in your content or integrate it within your theme template with PHP', 'open-user-map'); ?></th>
            <td>
              <strong>Shortcode:</strong><br><br>
              <code>[open-user-map]</code><br><br>
              <strong><?php echo __('you can also override the initial map focus with shortcode attributes:', 'open-user-map'); ?></strong><br><br>
              <code>[open-user-map lat="51.50665732176545" long="-0.12752251529432854" zoom="13" types="food|drinks" ids="123"]</code><br><br>
              <p class="hint"><?php echo __('Set an individual map position with lat, long and zoom. Filter locations by Type or <a href="https://gigapress.net/how-to-find-a-page-id-or-post-id-in-wordpress/" target="_blank">Post ID</a>. Separate multiple Types or Post IDs with a | symbol.', 'open-user-map'); ?></p><br><br>
              <strong>PHP:</strong><br><br>
              <code>&lt;?php echo do_shortcode('[open-user-map]'); ?&gt;</code>
            </td>
          </tr>

        </table>

      </div>

    </div>

    <?php submit_button();?>

</form>
</div>