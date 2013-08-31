$("button#imakoko").click(function () {
  navigator.geolocation.getCurrentPosition(
    function (p) {
      var lat = p.coords.latitude;
      var lon = p.coords.longitude;
      var alt = p.coords.altitude;
      var altAccuracy = p.coords.altitudeAccuracy;
      $("div#output").text("latitude: " + lat + ", longitude: " + lon + ", altitude: " + alt + ", altitudeAccuracy: " + altAccuracy);
      var map = new ZDC.Map(document.getElementById('map'), {
        latlon: ZDC.wgsTotky(new ZDC.LatLon(lat, lon)),
        zoom: 9
      });
    },
    function (e) {
      $("div#output").text("ERROR");
    }
  );
});
