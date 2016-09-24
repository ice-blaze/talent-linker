<div id="map" class="{{$class}}"></div>

<script src="{{URL::asset('assets/js/googlemaps_style.js')}}" charset="utf-8"></script>
<script>
function addMarker(map, latLng, title){
    return new google.maps.Marker({
      map: map,
      position: latLng,
      title: title
    });
}
function initMap() {
  // Create a map object and specify the DOM element for display.
  var myLatLng = {lat: {{$lat}}, lng: {{$lng}}};
  map = new google.maps.Map(document.getElementById('map'), {
    center: myLatLng,
    zoom: 10,
    scrollwheel: true,
    disableDefaultUI: true,
    keyboardShortcuts: false,
    disableDoubleClickZoom: true,
  });

  var marker = new google.maps.Marker({
    map: map,
    position: myLatLng,
    title: 'Your location'
  });

  var findArea = new google.maps.Circle({
    strokeColor: '#FF0000',
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: '#FF0000',
    fillOpacity: 0.35,
    map: map,
    center: myLatLng,
    radius: {{$find_distance}}*1000,
    clickable: false,
    title: "Search area",
  });

  if({{$edit}}){
    map.addListener('click', function(event) {
      marker.position = event.latLng
      marker.setMap(map)
      findArea.setCenter(new google.maps.LatLng(event.latLng.lat(),event.latLng.lng()))
      document.getElementById("lat").value = event.latLng.lat();
      document.getElementById("lng").value = event.latLng.lng();
    });

    document.getElementById("find_distance").addEventListener("change", function(){
      findArea.setRadius(Number(document.getElementById("find_distance").value)*1000);
    });
  }

  map.setOptions(gmStyle);
}

</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAr7nXL2Ga2yxm5x0mU6fwe0k48n7BJNLY&callback=initMap"
    async defer></script>
