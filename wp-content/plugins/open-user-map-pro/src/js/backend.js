//Dismiss
jQuery(document).on('click', '.oum-getting-started-notice .notice-dismiss', function() {
    jQuery.ajax({
        url: ajaxurl,
        data: {
            action: 'oum_dismiss_getting_started_notice'
        }
    });
});

//Map Style Preview
jQuery(document).on('change', '#oum_map_style', function() {
  jQuery('#oum_map_style_preview').attr('data-style', this.value);
});

//Media Uploader
jQuery(function($){
  $('body').on('click', '.oum_upload_image_button', function(e){
      e.preventDefault();

      var button = $(this),
      image_uploader = wp.media({
          title: 'Custom image',
          library : {
              type : 'image'
          },
          button: {
              text: 'Use this image'
          },
          multiple: false
      }).on('select', function() {
          var attachment = image_uploader.state().get('selection').first().toJSON();
          var url = attachment.sizes.large ? attachment.sizes.large.url : attachment.sizes.full.url;
          $('#oum_location_image').val(url);
          $('#oum_location_image_preview').addClass('has-image');
          $('#oum_location_image_preview').html('<img src="' +  url + '"><div onclick="oumRemoveImageUpload()" class="remove-upload">&times;</div>');
      })
      .open();
  });

  $('body').on('click', '.oum_upload_audio_button', function(e){
    e.preventDefault();

    var button = $(this),
    audio_uploader = wp.media({
        title: 'Custom audio',
        library : {
            type : 'audio'
        },
        button: {
            text: 'Use this audio'
        },
        multiple: false
    }).on('select', function() {
        var attachment = audio_uploader.state().get('selection').first().toJSON();
        var url = attachment.url;
        $('#oum_location_audio').val(url);
        $('#oum_location_audio_preview').addClass('has-audio');
        $('#oum_location_audio_preview').html(url + '<div onclick="oumRemoveAudioUpload()" class="remove-upload">&times;</div>');
    })
    .open();
  });

  $('body').on('click', '.oum_upload_icon_button', function(e){
    e.preventDefault();

    var button = $(this),
    icon_uploader = wp.media({
        title: 'Custom icon',
        library : {
            type : 'image'
        },
        button: {
            text: 'Use this image'
        },
        multiple: false
    }).on('select', function() {
        var attachment = icon_uploader.state().get('selection').first().toJSON();
        var url = attachment.url;
        $('#oum_marker_user_icon').val(url);
        $('#oum_marker_user_icon_preview').addClass('has-icon');
        $('#oum_marker_user_icon_preview').css("background-image", "url(" + url + ")");
        $('#oum_marker_user_icon_preview').next('input[type=radio]').prop('checked', true);
        $('#oum_marker_user_icon_preview').next('input[type=radio]').trigger('change');
    })
    .open();
  });
});

function oumRemoveImageUpload() {
    document.getElementById('oum_location_image').value = '';
    document.getElementById('oum_location_image_preview').classList.remove('has-image');
    document.getElementById('oum_location_image_preview').textContent = '';
}

function oumRemoveAudioUpload() {
    document.getElementById('oum_location_audio').value = '';
    document.getElementById('oum_location_audio_preview').classList.remove('has-audio');
    document.getElementById('oum_location_audio_preview').textContent = '';
}