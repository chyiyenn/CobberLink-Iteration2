document.addEventListener('DOMContentLoaded', function(e) {

  function iOS() {
    return [
        'iPad Simulator',
        'iPhone Simulator',
        'iPod Simulator',
        'iPad',
        'iPhone',
        'iPod'
      ].includes(navigator.platform)
      // iPad on iOS 13 detection
      ||
      (navigator.userAgent.includes("Mac") && "ontouchend" in document)
  }

  const enableFullscreen = (!iOS() && !oum_disable_fullscreen) ? true : false;
  const enableCurrentLocation = oum_enable_currentlocation ? true : false;

  const map = L.map(map_el, {
    gestureHandling: true,
    fullscreenControl: enableFullscreen,
    fullscreenControlOptions: {
      position: 'topleft',
      fullscreenElement: document.getElementById('add-location-overlay').parentNode
    }
  });
  const mapWidth = document.getElementById(map_el).offsetWidth;
  const zoomOffset = 1.5;

  // Render map
  (function() {
    //adjust zoom relative to map width 570
    let mapZoom = mapWidth / 570 + start_zoom - zoomOffset;
    mapZoom = mapZoom > 20 ? 20 : mapZoom < 0 ? 0 : mapZoom

    // Center map
    map.setView([start_lat, start_lng], start_zoom);

    // Set map style
    if (mapStyle == 'Custom1') {
      L.tileLayer('http://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}.png').addTo(map);
      L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_only_labels/{z}/{x}/{y}{r}.png', {
        tileSize: 512,
        zoomOffset: -1
      }).addTo(map);
    } else if (mapStyle == 'Custom2') {
      L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_nolabels/{z}/{x}/{y}.png').addTo(map);
      L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_only_labels/{z}/{x}/{y}{r}.png', {
        tileSize: 512,
        zoomOffset: -1
      }).addTo(map);
    } else if (mapStyle == 'Custom3') {
      L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_nolabels/{z}/{x}/{y}.png').addTo(map);
      L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_only_labels/{z}/{x}/{y}{r}.png', {
        tileSize: 512,
        zoomOffset: -1
      }).addTo(map);
    } else {
      // Default
      L.tileLayer.provider(mapStyle).addTo(map);
    }

    // Render locations

    // Parent Layer (has subgroups of markers)
    let markers;
    if (oum_disable_cluster) {
      markers = L.layerGroup();
    } else {
      markers = L.markerClusterGroup({
        showCoverageOnHover: false,
        removeOutsideVisibleBounds: false,
        maxClusterRadius: 40
      });
    }

    markers.addTo(map);

    // Control: Legend (toggle marker subgroups)
    const legendControl = L.control.layers(null, null, {
      collapsed: false,
      position: 'bottomright'
    });

    // Control: get current location
    if (enableCurrentLocation) {
      L.control.locate({
        flyTo: true,
        initialZoomLevel: 12,
        drawCircle: false,
        drawMarker: false
      }).addTo(map);
    }

    // Handle locations grouped by types
    if(locations_by_type.length > 0) {

      let markerGroups = [];

      //add legend
      legendControl.addTo(map);
      
      //create marker groups (empty)
      locations_by_type.forEach(function(typeGroup, index) {
        markerGroups[index] = L.featureGroup.subGroup(markers); //group1, group2, ...
        legendControl.addOverlay(markerGroups[index], `<img src="${typeGroup.icon}">${typeGroup.name}`);
      });

      locations_by_type.forEach(function(typeGroup, index){
        
        //add locations to each marker group
        for (let i = 0; i < typeGroup.locations.length; i++) {
          let marker = L.marker(
            [
              typeGroup.locations[i].lat,
              typeGroup.locations[i].lng
            ], {
              icon: L.icon({
                iconUrl: typeGroup.locations[i].icon,
                iconSize: [26, 41],
                iconAnchor: [13, 41],
                popupAnchor: [0, -25],
                shadowUrl: marker_shadow_url,
                shadowSize: [41, 41],
                shadowAnchor: [13, 41]
              })
            }
          );
          marker.bindPopup(typeGroup.locations[i].content);
          marker.addTo(markerGroups[index]);
        }

        //add marker group to map
        markerGroups[index].addTo(map);
      });

    }

    // Handle locations without types
    if(locations_without_type.length > 0) {
      let markerGroup = L.featureGroup.subGroup(markers);

      for (let i = 0; i < locations_without_type.length; i++) {
        let marker = L.marker(
          [
            locations_without_type[i].lat,
            locations_without_type[i].lng
          ], {
            icon: L.icon({
              iconUrl: locations_without_type[i].icon,
              iconSize: [26, 41],
              iconAnchor: [13, 41],
              popupAnchor: [0, -25],
              shadowUrl: marker_shadow_url,
              shadowSize: [41, 41],
              shadowAnchor: [13, 41]
            })
          }
        );
        marker.bindPopup(locations_without_type[i].content);
        marker.addTo(markerGroup);
      }

      //add marker group to map
      markerGroup.addTo(map);
    }


  })();

  // Event: "Add location" Button click
  if (document.getElementById('open-add-location-overlay') != null) {
    //init map
    const map2 = L.map('mapGetLocation', {
      gestureHandling: true
    });

    // Activate Map inside overlay
    (function() {

      let markerIsVisible = false;

      // Set map style
      if (mapStyle == 'Custom1') {
        L.tileLayer('http://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}.png').addTo(map2);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_only_labels/{z}/{x}/{y}{r}.png', {
          tileSize: 512,
          zoomOffset: -1
        }).addTo(map2);
      } else if (mapStyle == 'Custom2') {
        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_nolabels/{z}/{x}/{y}.png').addTo(map2);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_only_labels/{z}/{x}/{y}{r}.png', {
          tileSize: 512,
          zoomOffset: -1
        }).addTo(map2);
      } else if (mapStyle == 'Custom3') {
        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_nolabels/{z}/{x}/{y}.png').addTo(map2);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_only_labels/{z}/{x}/{y}{r}.png', {
          tileSize: 512,
          zoomOffset: -1
        }).addTo(map2);
      } else {
        // Default
        L.tileLayer.provider(mapStyle).addTo(map2);
      }

      const search = new GeoSearch.GeoSearchControl({
        style: 'bar',
        showMarker: false,
        provider: new GeoSearch.OpenStreetMapProvider(),
        searchLabel: oum_searchaddress_label
      });
      map2.addControl(search);

      // Add control: get current location
      if (enableCurrentLocation) {
        L.control.locate({
          flyTo: true,
          initialZoomLevel: 12,
          drawCircle: false,
          drawMarker: false
        }).addTo(map2);
      }

      //define marker

      // Marker Icon
      let markerIcon = L.icon({
        iconUrl: marker_icon_url,
        iconSize: [26, 41],
        iconAnchor: [13, 41],
        popupAnchor: [0, -25],
        shadowUrl: marker_shadow_url,
        shadowSize: [41, 41],
        shadowAnchor: [13, 41]
      });

      let locationMarker = L.marker([0, 0], {
        icon: markerIcon
      }, {
        'draggable': true
      });

      //initial map view
      map2.setView([start_lat, start_lng], start_zoom);

      //Event: click on map to set marker OR location found
      map2.on('click locationfound', function(e) {
        let coords = e.latlng;

        locationMarker.setLatLng(coords);

        if (!markerIsVisible) {
          locationMarker.addTo(map2);
          markerIsVisible = true;
        }

        setLocationLatLng(coords);
      });

      //Event: geosearch success
      map2.on('geosearch/showlocation', function(e) {
        let coords = e.marker._latlng;
        let label = e.location.label;

        locationMarker.setLatLng(coords);

        if (!markerIsVisible) {
          locationMarker.addTo(map2);
          markerIsVisible = true;
        }

        setLocationLatLng(coords);
        setAddress(label);
      });

      //Event: drag marker
      locationMarker.on('dragend', function(e) {
        setLocationLatLng(e.target.getLatLng());
      });

      //Validation for required checkbox groups
      jQuery('#oum_add_location input[type="submit"]').on('click', function() {
        let required_fieldsets = jQuery('#oum_add_location fieldset.is-required');

        required_fieldsets.each(function() {
          $cbx_group = jQuery(this).find('input:checkbox');
          $cbx_group.prop('required', true);
          if($cbx_group.is(":checked")){
            $cbx_group.prop('required', false);
          }
        });
      });

      //set lat & lng input fields
      function setLocationLatLng(markerLatLng) {
        console.log(markerLatLng);

        jQuery('#oum_location_lat').val(markerLatLng.lat);
        jQuery('#oum_location_lng').val(markerLatLng.lng);
      }

      //set address field
      function setAddress(label) {
        console.log(label);

        jQuery('#oum_location_address').val(label);
      }

    })();

    document.getElementById('open-add-location-overlay').addEventListener('click', function(event) {

      // show overlay
      document.getElementById('add-location-overlay').classList.add('active');

      //reposition map
      setTimeout(function() {
        map2.invalidateSize();
        map2.setView([start_lat, start_lng], start_zoom);
      }, 0);
    });

    // Event: click on "notify on publish"
    if (document.getElementById('oum_location_notification') != null) {
      document.getElementById('oum_location_notification').addEventListener('change', function(event) {
        if (this.checked) {
          document.getElementById('oum_author').classList.add('active');
        } else {
          document.getElementById('oum_author').classList.remove('active');
        }
      });
    }

    // Event: close "Add location" overlay
    if (document.getElementById('close-add-location-overlay') != null) {
      document.getElementById('close-add-location-overlay').addEventListener('click', function(event) {
        document.getElementById('add-location-overlay').classList.remove('active');
      });
    }

    // Event: Remove uploaded image
    document.getElementById('oum_remove_image').addEventListener('click', function() {
      document.getElementById('oum_location_image').value = '';
      document.getElementById('oum_location_image').nextElementSibling.classList.remove('active');
      document.getElementById('oum_location_image').nextElementSibling.querySelector('span').textContent = '';
    });

    // Event: Remove uploaded audio
    document.getElementById('oum_remove_audio').addEventListener('click', function() {
      document.getElementById('oum_location_audio').value = '';
      document.getElementById('oum_location_audio').nextElementSibling.classList.remove('active');
      document.getElementById('oum_location_audio').nextElementSibling.querySelector('span').textContent = '';
    });

    // Event: add another location
    document.getElementById('oum_add_another_location').addEventListener('click', function() {
      document.getElementById('oum_add_location').style.display = 'block';
      document.getElementById('oum_add_location_error').style.display = 'none';
      document.getElementById('oum_add_location_thankyou').style.display = 'none';

      //reposition map
      setTimeout(function() {
        map2.invalidateSize();
        map2.setView([start_lat, start_lng], start_zoom);
      }, 0);

      //reset media previews
      if(document.getElementById('oum_location_image')) {
        document.getElementById('oum_location_image').value = '';
        document.getElementById('oum_location_image').nextElementSibling.classList.remove('active');
        document.getElementById('oum_location_image').nextElementSibling.querySelector('span').textContent = '';
      }

      if(document.getElementById('oum_location_audio')) {
        document.getElementById('oum_location_audio').value = '';
        document.getElementById('oum_location_audio').nextElementSibling.classList.remove('active');
        document.getElementById('oum_location_audio').nextElementSibling.querySelector('span').textContent = '';
      }
    });

    if(document.getElementById('oum_location_image')) {
      document.getElementById('oum_location_image').addEventListener('change', updatePreview);
    }

    if(document.getElementById('oum_location_audio')) {
      document.getElementById('oum_location_audio').addEventListener('change', updatePreview)
    }

    function updatePreview() {
      this.nextElementSibling.classList.add('active');
      this.nextElementSibling.querySelector('span').textContent = this.files[0].name;
    }
  }

});
