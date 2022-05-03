<div class="section geo-coordinates-wrap">
    <div class="map-wrap">
        <div id="mapGetLocation" class="leaflet-map map-style_<?php echo esc_attr($map_style); ?>"></div>
    </div>
    <div class="input-wrap">
        <div class="geo-coordinates-hint">
            <div class="hint"><?php echo __('Click on the map to set a location marker or <a href="#" id="showLatLngInputs">edit GPS coordinates manually</a>.', 'open-user-map'); ?></div>

            <div class="latlng-wrap" id="latLngInputs" style="display: none;">
                <div class="hint"><?php echo __('Edit GPS coordinates manually:', 'open-user-map'); ?></div>
                <div>
                    <div>
                        <label class="meta-label" for="oum_location_lat">
                            <?php echo __('Lat', 'open-user-map'); ?>
                        </label>
                        <input type="text" class="widefat" id="oum_location_lat" name="oum_location_lat" value="<?php echo esc_attr($lat); ?>"></input>
                    </div>
                    <div>
                        <label class="meta-label" for="oum_location_lng">
                            <?php echo __('Lng', 'open-user-map'); ?>
                        </label>
                        <input type="text" class="widefat" id="oum_location_lng" name="oum_location_lng" value="<?php echo esc_attr($lng); ?>"></input>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    const lat = '<?php echo esc_attr($lat); ?>';
    const lng = '<?php echo esc_attr($lng); ?>';
    const zoom = '13';
    const mapStyle = '<?php echo esc_attr($map_style); ?>';
    const oum_enable_currentlocation = '<?php echo get_option('oum_enable_currentlocation') ? true : false; ?>';
    const enableCurrentLocation = oum_enable_currentlocation ? true : false;
    

    <?php if($marker_icon == 'user1' && $marker_user_icon): ?>
        const marker_icon_url = `<?php echo esc_url($marker_user_icon); ?>`;
    <?php else: ?>
        const marker_icon_url = `<?php echo esc_url($this->plugin_url); ?>src/leaflet/images/marker-icon_<?php echo esc_attr($marker_icon); ?>-2x.png`;
    <?php endif; ?>

    const marker_shadow_url = '<?php echo esc_url($this->plugin_url); ?>src/leaflet/images/marker-shadow.png';
    </script>

    <?php wp_enqueue_script('oum_backend_location_js', esc_url($this->plugin_url) . 'src/js/backend-location.js', array('wp-polyfill', 'oum_leaflet_geosearch_js'), esc_attr($this->plugin_version));?>
</div>

<div class="section">
    <label class="meta-label" for="oum_location_address">
        <?php echo __('Address', 'open-user-map'); ?>
    </label>
    <input type="text" class="widefat" id="oum_location_address" name="oum_location_address" value="<?php echo esc_attr($address); ?>"></input>
</div>

<div class="section">
  <label class="meta-label" for="oum_location_image"><?php echo __('Image', 'open-user-map'); ?></label>
  <table>
    <tr>
      <td><a href="#" class="oum_upload_image_button button button-secondary"><?php echo __('Upload Image', 'open-user-map'); ?></a></td>
      <td><input type="hidden" class="widefat" id="oum_location_image" name="oum_location_image" value="<?php echo esc_attr($image); ?>"></input></td>
    </tr>
  </table>
  <div id="oum_location_image_preview" class="<?php echo $has_image; ?>"><?php echo $image_tag; ?><div onclick="oumRemoveImageUpload()" class="remove-upload">&times;</div></div>
</div>

<div class="section">
  <label class="meta-label" for="oum_location_audio"><?php echo __('Audio', 'open-user-map'); ?></label>
  <table>
    <tr>
      <td><a href="#" class="oum_upload_audio_button button button-secondary"><?php echo __('Upload Audio', 'open-user-map'); ?></a></td>
      <td><input type="hidden" class="widefat" id="oum_location_audio" name="oum_location_audio" value="<?php echo esc_attr($audio); ?>"></input></td>
    </tr>
  </table>
  <div id="oum_location_audio_preview" class="<?php echo $has_audio; ?>">
    <?php echo $audio_tag; ?>
    <div onclick="oumRemoveAudioUpload()" class="remove-upload">&times;</div>
  </div>
</div>

<div class="section">
    <label class="meta-label" for="oum_location_text">
        <?php echo __('Text', 'open-user-map'); ?>
    </label>
    <?php wp_editor($text, 'oum_location_text');?>
</div>

<?php if (oum_fs()->is__premium_only()): ?>
    <?php if (oum_fs()->can_use_premium_code()): ?>

        <div class="section">
            <input type="checkbox" id="oum_location_notification" name="oum_location_notification" <?php echo ($notification) ? 'checked' : ''; ?>>
            <label for="oum_location_notification"><?php echo $text_notify_me_on_publish_label; ?></label>

            <label class="meta-label" for="oum_location_author_name">
                <?php echo $text_notify_me_on_publish_name; ?>
            </label>
            <input type="text" class="widefat" id="oum_location_author_name" name="oum_location_author_name" value="<?php echo esc_attr($author_name); ?>"></input>

            <label class="meta-label" for="oum_location_author_email">
                <?php echo $text_notify_me_on_publish_email; ?>
            </label>
            <input type="email" class="widefat" id="oum_location_author_email" name="oum_location_author_email" value="<?php echo esc_attr($author_email); ?>"></input>

            <?php echo $notified_tag; ?>
        </div>

    <?php endif;?>
<?php endif;?>

<?php if (oum_fs()->is__premium_only()): ?>
    <?php if (oum_fs()->can_use_premium_code()): ?>
        <?php if (get_option('oum_enable_add_user_location')): ?>

            <div class="section">
                <label class="meta-label" for="oum_location_user_id">
                    <?php echo __('User ID', 'open-user-map'); ?>
                </label>
                <input type="text" class="regular-text" id="oum_location_user_id" name="oum_location_user_id" value="<?php echo esc_attr($user_id); ?>"></input>
            </div>

        <?php endif;?>
    <?php endif;?>
<?php endif;?>

<?php if (is_array($active_custom_fields)): ?>
    <?php foreach($active_custom_fields as $index => $custom_field): ?>

        <?php
        $custom_field['fieldtype'] = isset($custom_field['fieldtype']) ? $custom_field['fieldtype'] : 'text';
        $custom_field['description'] = isset($custom_field['description']) ? $custom_field['description'] : '';

        $label = esc_attr($custom_field['label']) . ((isset($custom_field['required']))? '*' : '');
        $description = ($custom_field['description']) ? '<div class="oum_custom_field_description">' . $custom_field['description'] . '</div>' : '';
        ?>
        
        <?php if($custom_field['fieldtype'] == 'text'): ?>
            <div class="section">
                <label class="meta-label"><?php echo $label; ?></label>
                <input type="text" class="regular-text" name="oum_location_custom_fields[<?php echo $index; ?>]" value="<?php echo isset($meta_custom_fields[$index]) ? esc_attr($meta_custom_fields[$index]) : ''; ?>"></input>
                <?php echo $description; ?>
            </div>
        <?php endif; ?>

        <?php if($custom_field['fieldtype'] == 'link'): ?>
            <div class="section">
                <label class="meta-label"><?php echo $label; ?></label>
                <input type="text" class="regular-text" name="oum_location_custom_fields[<?php echo $index; ?>]" value="<?php echo isset($meta_custom_fields[$index]) ? esc_attr($meta_custom_fields[$index]) : ''; ?>"></input>
                <?php echo $description; ?>
            </div>
        <?php endif; ?>

        <?php if($custom_field['fieldtype'] == 'checkbox'): ?>
            <div class="section">
                <fieldset>
                    <legend><?php echo $label; ?></legend>
                    <?php 
                    $options = isset($custom_field['options']) ? explode('|', $custom_field['options']) : array();
                    ?>
                    <?php foreach($options as $option): ?>
                        <div>
                            <label>
                                <input type="checkbox" name="oum_location_custom_fields[<?php echo $index; ?>][]" value="<?php echo esc_attr($option); ?>" <?php echo (isset($meta_custom_fields[$index]) && in_array(esc_attr($option), $meta_custom_fields[$index])) ? 'checked' : ''; ?>>
                                <span><?php echo $option; ?></span>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </fieldset>
                <?php echo $description; ?>
            </div>
        <?php endif; ?>

        <?php if($custom_field['fieldtype'] == 'radio'): ?>
            <div class="section">
                <fieldset>
                    <legend><?php echo $label; ?></legend>
                    <?php 
                    $options = isset($custom_field['options']) ? explode('|', $custom_field['options']) : array();
                    ?>
                    <?php foreach($options as $option): ?>
                        <div>
                            <label>
                                <input type="radio" name="oum_location_custom_fields[<?php echo $index; ?>]" value="<?php echo esc_attr($option); ?>" <?php echo (isset($meta_custom_fields[$index]) && esc_attr($option) == $meta_custom_fields[$index]) ? 'checked' : ''; ?>>
                                <span><?php echo $option; ?></span>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </fieldset>
                <?php echo $description; ?>
            </div>
        <?php endif; ?>

        <?php if($custom_field['fieldtype'] == 'select'): ?>
            <div class="section">
                <label class="meta-label"><?php echo esc_attr($label); ?></label>
                <select name="oum_location_custom_fields[<?php echo $index; ?>]" <?php echo (isset($custom_field['required']))? 'required' : ''; ?>>
                    <?php 
                    $options = isset($custom_field['options']) ? explode('|', $custom_field['options']) : array();
                    ?>
                    <?php foreach($options as $option): ?>
                        <option value="<?php echo esc_attr($option); ?>" <?php echo (isset($meta_custom_fields[$index]) && esc_attr($option) == $meta_custom_fields[$index]) ? 'selected' : ''; ?>><?php echo $option; ?></option>
                    <?php endforeach; ?>
                </select>
                <?php echo $description; ?>
            </div>
        <?php endif; ?>

    <?php endforeach; ?>
<?php endif;?>
