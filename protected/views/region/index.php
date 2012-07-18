<div id="map"></div>
<div id="btn" style="border:1px solid #333; position: fixed; top: 0; height: 10px; width: 100%">Send</div>
<script type="text/javascript">

    // Create the Google Map…
    var map = new google.maps.Map(d3.select("#map").node(), {
        zoom: 15,
        center: new google.maps.LatLng(51.149633, 71.466837),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var drawingManager = new google.maps.drawing.DrawingManager({
        drawingControl: true,
        drawingControlOptions: {
            drawingModes: [google.maps.drawing.OverlayType.MARKER, google.maps.drawing.OverlayType.POLYGON]
        },
        drawingMode: google.maps.drawing.OverlayType.MARKER,
        polygonOptions: {
            fillColor: '#ffffff',
            fillOpacity: 1,
            strokeWeight: 5,
            clickable: true,
            editable: true
        }
    });
    drawingManager.setMap(map);

    google.maps.event.addListener(drawingManager, 'polygoncomplete', savePolygon);

    google.maps.event.addListener(drawingManager, 'markercomplete', function(marker)
    {
        console.log(marker.getPosition().toString())
    });

    // Load the station data. When the data comes back, create an overlay.
    var overlay = new google.maps.OverlayView();

    // Add the container when the overlay is added to the map.
    overlay.onAdd = function()
    {
        var layer = d3.select(this.getPanes().overlayLayer).append("div")
            .attr("class", "stations");

        // We could use a single SVG, but what size would it have?
        overlay.draw = function()
        {
            var projection = this.getProjection();

            var regions = layer.append("svg:g").attr("id", "regions");
            var sectors = layer.append("svg:g").attr("id", "sectors");

            //        d3.json("unemployment.json", function(data) {
            //          var pad = d3.format("05d"),
            //              quantize = d3.scale.quantile().domain([0, 15]).range(d3.range(9));
            <!---->
            //          d3.json("us-counties.json", function(json) {
            //            counties.selectAll("path")
            //                .data(json.features)
            //              .enter().append("svg:path")
            //                .attr("class", function(d) { return "q" + quantize(data[pad(d.id)]) + "-9"; })
            //                .attr("d", path)
            //              .append("svg:title")
            //                .text(function(d) { return d.properties.name + ": " + data[pad(d.id)] + "%"; });
            //          });
            //        });
            var polygon = new google.maps.Polygon({
                paths: [],
                strokeColor: "#FF0000",
                strokeOpacity: 0.8,
                strokeWeight: 3,
                fillColor: "#FF0000",
                fillOpacity: 0.35
            });
            google.maps.event.addListener(map, 'click', function(e)
            {
                polygon.paths.push(e.latLng);
            });

            $('#btn').click(function()
            {
                $.post('/region/save', polygon.paths);
            });



        };

    };


    // Bind our overlay to the map…
    overlay.setMap(map);

</script>