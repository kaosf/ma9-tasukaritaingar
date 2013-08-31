$("button#imakoko").click(function () {
  navigator.geolocation.getCurrentPosition(
    function (p) {
      var lat = p.coords.latitude;
      var lon = p.coords.longitude;
      $("div#output").text("latitude: " + lat + ", longitude: " + lon);
      var map = new ZDC.Map(document.getElementById('map'), {
        latlon: ZDC.wgsTotky(new ZDC.LatLon(lat, lon))
      });
    },
    function (e) {
      $("div#output").text("ERROR");
    }
  );
});
