/*MAPA */
var map = new L.Map("map", {
  fullscreenControl: true,
  fullscreenControlOptions: {
    position: "topleft",
  },
}).setView([5.65, -67.6], 13);
map.attributionControl.setPrefix("Leaflet");

var baseLayers = {
  Satelite: L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
    minZoom: 2,
    maxZoom: 28,
    attribution: '',
    subdomains: ["mt0", "mt1", "mt2", "mt3"]
}),
  Calles: L.tileLayer("http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}", {
    minZoom: 2,
    maxZoom: 28,
    attribution: "",
    subdomains: ["mt0", "mt1", "mt2", "mt3"],
  }),
};
map.addLayer(baseLayers.Satelite);

var overlayers = {};

var controlRight1 = L.control
  .layers(baseLayers, overlayers, {
    position: "topright", // 'topleft', 'bottomleft', 'bottomright'
    collapsed: true, // true
  })
  .addTo(map); // Primer Control Derecha



  function cargarContenidoMapa(contenido) {
   map.removeLayer(baseLayers.Satelite);
   map.addLayer(baseLayers.Calles);
   let = json = JSON.parse(contenido)
   let geoJson = L.geoJSON(json).addTo(map);
   map.fitBounds(geoJson.getBounds());
   map.setZoom(13);
  }

  


/*===================================================
                        DRAW ITEM            
    ===================================================*/
var drawnItems = new L.FeatureGroup();

var drawControl = new L.Control.Draw({
  draw: {
    polygon: false,
    polyline: false,
    circle: false,
    rectangle: false,
  },
  edit: {
    featureGroup: drawnItems,
  },
});

map.addLayer(drawnItems);
drawControl.addTo(map);

map.on("draw:created", function (event) {
  var layer = event.layer,
    feature = (layer.feature = layer.feature || {});

  feature.type = feature.type || "Feature";
  var props = (feature.properties = feature.properties || {});
  drawnItems.addLayer(layer);
  var drawJson = JSON.stringify(drawnItems.toGeoJSON());

  if (sessionStorage.getItem("modoRegistro") == "areaDeInteres") {
    $("#guardarArea").show(500, "swing");
    $("#boxRefer").hide(500, "swing");
    $("#boxReferPoligono").hide(500, "swing");
  } else {
    if (drawJson.indexOf("Polygon") > 0) {
      $("#boxReferPoligono").show(500, "swing");
      $("#guardarArea").hide(500, "swing");
    } else {
      $("#boxRefer").show(500, "swing");
      $("#guardarArea").hide(500, "swing");
    }
  }
});
map.invalidateSize()

/*===================================================
                        DRAW ITEM            
    ================================================
    /*MAPA */

