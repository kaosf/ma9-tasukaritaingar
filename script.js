var map;

$(function () {
  map = new ZDC.Map(document.getElementById('map'), {
    zoom: 9
  });

  ZDC.addListener(map, ZDC.MAP_CHG_LATLON, function () {
    var latlon = map.getLatLon();
    var lat = latlon.lat;
    var lon = latlon.lon;
    $("div#output").text("latitude: " + lat + ", longitude: " + lon);
  });
});

$("button#imakoko").click(function () {
  navigator.geolocation.getCurrentPosition(
    function (p) {
      var lat = p.coords.latitude;
      var lon = p.coords.longitude;
      $("div#output").text("latitude: " + lat + ", longitude: " + lon);
      map.moveLatLon(ZDC.wgsTotky(new ZDC.LatLon(lat, lon)));
    },
    function (e) {
      $("div#output").text("ERROR");
    }
  );
});
