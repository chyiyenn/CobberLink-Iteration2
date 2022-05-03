(function(){

  let markerIsVisible = false;

  const map = L.map('mapGetLocation', {
      scrollWheelZoom: false
  });

  const latLngInputs = jQuery('#latLngInputs');
  const showLatLngInputs = jQuery('#showLatLngInputs');

  // Set map style
  if(mapStyle == 'Custom1') {
    L.tileLayer('http://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}.png').addTo(map);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_only_labels/{z}/{x}/{y}{r}.png', {
      tileSize: 512,
      zoomOffset: -1
    }).addTo(map);
  }else if(mapStyle == 'Custom2') {
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_nolabels/{z}/{x}/{y}.png').addTo(map);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_only_labels/{z}/{x}/{y}{r}.png', {
      tileSize: 512,
      zoomOffset: -1
    }).addTo(map);
  }else if(mapStyle == 'Custom3') {
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_nolabels/{z}/{x}/{y}.png').addTo(map);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_only_labels/{z}/{x}/{y}{r}.png', {
      tileSize: 512,
      zoomOffset: -1
    }).addTo(map);
  }else {
    // Default
    L.tileLayer.provider(mapStyle).addTo(map);
  }

  const search = new GeoSearch.GeoSearchControl({
      style: 'bar',
      showMarker: false,
      provider: new GeoSearch.OpenStreetMapProvider(),
  });
  map.addControl(search);

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

  let locationMarker = L.marker([lat, lng], {icon: markerIcon}, {
      'draggable': true
  });
  
  if(lat && lng) {
      //location has coordinates
      map.setView([lat, lng], zoom);
      locationMarker.addTo(map);
      markerIsVisible = true;
  }else{
      //location has NO coordinates yet
      map.setView([0, 0], 1);
  }

  // Add control: get current location
  if(enableCurrentLocation) {
    L.control.locate({
      flyTo: true,
      initialZoomLevel: 12,
      drawCircle: false,
      drawMarker: false
    }).addTo(map);
  }

  //Event: click on map to set marker
  map.on('click locationfound', function(e) {
    let coords = e.latlng;

    locationMarker.setLatLng(coords);

    if(!markerIsVisible) {
        locationMarker.addTo(map);
        markerIsVisible = true;
    }

    setLocationLatLng(coords);
  });

  //Event: geosearch success
  map.on('geosearch/showlocation', function(e) {
    let coords = e.marker._latlng;
    let label = e.location.label;

    locationMarker.setLatLng(coords);

    if (!markerIsVisible) {
      locationMarker.addTo(map);
      markerIsVisible = true;
    }

    setLocationLatLng(coords);
    setAddress(label);
  });

  //Event: drag marker
  locationMarker.on('dragend', function(e) {
      setLocationLatLng(e.target.getLatLng());
  });

  showLatLngInputs.on('click', function(e) {
      e.preventDefault();
      jQuery(this).parent('.hint').hide();
      latLngInputs.fadeIn();
  })

  
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