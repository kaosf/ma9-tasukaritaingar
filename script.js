$("button#imakoko").click(function () {
  navigator.geolocation.getCurrentPosition(
    function (p) {
      $("div#output").text("latitude: " + p.coords.latitude + ", longitude: " + p.coords.longitude);
      var map = new ZDC.Map(document.getElementById('map'));
    },
    function (e) {
      $("div#output").text("ERROR");
    }
  );
});
