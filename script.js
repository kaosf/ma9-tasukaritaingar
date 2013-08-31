$("button#imakoko").click(function () {
  navigator.geolocation.getCurrentPosition(
    function (p) {
      $("div#output").text("latitude: " + p.coords.latitude + ", longitude: " + p.coords.longitude);
    },
    function (e) {
      $("div#output").text("ERROR");
    }
  );
});
