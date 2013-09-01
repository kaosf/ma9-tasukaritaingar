var map;

function judgeDanger(altitude, cb) {
  if (altitude < 1) {
    cb(0);
  }
  else if (altitude < 3) {
    cb(1);
  }
  else {
    cb(2);
  }
}

$(function () {
  map = new ZDC.Map(document.getElementById('map'), {
    zoom: 9
  });

  ZDC.addListener(map, ZDC.MAP_CHG_LATLON, function () {
    var latlon = map.getLatLon();
    var lat = latlon.lat;
    var lon = latlon.lon;
    $("div#output").text("latitude: " + lat + ", longitude: " + lon);
    $.get("getelevation.php", {lat: lat, lon: lon}, function (data) {
      var alt = JSON.parse(data).elevation;
      $("div#altitude").text("altitude: " + alt + " (m)");
      judgeDanger(function (danger) {
        $("span#danger").text(danger);
      });
    });
  });
});

$("button#imakoko").click(function () {
  navigator.geolocation.getCurrentPosition(
    function (p) {
      var lat = p.coords.latitude;
      var lon = p.coords.longitude;
      $("div#output").text("latitude: " + lat + ", longitude: " + lon);
      map.moveLatLon(ZDC.wgsTotky(new ZDC.LatLon(lat, lon)));
      $.get("getelevation.php", {lat: lat, lon: lon}, function (data) {
        var alt = JSON.parse(data).elevation;
        $("div#altitude").text("altitude: " + alt + " (m)");
        judgeDanger(function (danger) {
          $("span#danger").text(danger);
        });
      });
    },
    function (e) {
      $("div#output").text("ERROR");
    }
  );
});
