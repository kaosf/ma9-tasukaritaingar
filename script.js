var map;

$(function () {
  map = new ZDC.Map(document.getElementById('map'), {
    zoom: 9
  });
});

$("button#imakoko").click(function () {
  navigator.geolocation.getCurrentPosition(
    function (p) {
      var lat = p.coords.latitude;
      var lon = p.coords.longitude;
      $("div#output").text("latitude: " + lat + ", longitude: " + lon);
      // TODO: set map's center with lat and lon
      // ZDC.wgsTotky(new ZDC.LatLon(lat, lon))
    },
    function (e) {
      $("div#output").text("ERROR");
    }
  );
});
