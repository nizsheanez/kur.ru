<div id="map"></div>
<div id="tip"></div>
<style>
    .phoneytext{
        text-shadow: 0 -1px 0 #000;
        color:       #fff;
        font-family: Helvetica Neue, Helvetica, arial;
        font-size:   12px;
        line-height: 14px;
        padding:     4px 45px 4px 15px;
        font-weight: bold;
    }
    .phoney{
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0, rgb(112, 112, 112)), color-stop(0.51, rgb(94, 94, 94)), color-stop(0.52, rgb(57, 57, 57)));
        background: -moz-linear-gradient(center top, rgb(112, 112, 112) 0%, rgb(94, 94, 94) 51%, rgb(57, 57, 57) 52%);
    }
</style>
<script type="text/javascript">
    // Create the Google Map…
    var map = new google.maps.Map(d3.select("#map").node(), {
        zoom: 15,
        center: new google.maps.LatLng(51.149633, 71.466837),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infoBubble = new InfoBubble({
        map: map,
        shadowStyle: 1,
        disableAnimation: true,
        padding: 0,
        backgroundColor: 'rgb(57,57,57)',
        borderRadius: 4,
        borderWidth: 1,
        borderColor: '#2c2c2c',
        disableAutoPan: true,
        hideCloseButton: true,
        backgroundClassName: 'phoney',
        maxWidth: 210
    });

    function hexFromRGB(r, g, b)
    {
        var hex = [
            Math.ceil(r).toString(16),
            Math.ceil(g).toString(16),
            Math.ceil(b).toString(16)
        ];
        $.each(hex, function(nr, val)
        {
            if (val.length === 1)
            {
                hex[ nr ] = "0" + val;
            }
        });
        return hex.join("").toUpperCase();
    }
    d3.json("/region/get", function(json)
    {
        for (var i in json.features)
        {
            var shape = json.features[i];
            var paths = [];
            for (var j in shape.coordinates)
            {
                var xy = shape.coordinates[j];
                paths.push(new google.maps.LatLng(xy[0], xy[1]));
            }
            var norma = 10;
            var max = 40;
            n = shape.properties.unemploye - norma;
            n = 100 / (max - norma) * n;
            if (n < 0)
            {
                n = 1;
            }
            if (n > 100)
            {
                n = 100;
            }
            var color = hexFromRGB((255 * n) / 100, (200 * (100 - n)) / 100, 0);
            var polygon = new google.maps.Polygon({
                properties: shape.properties,
                paths: paths,
                strokeColor: color,
                strokeOpacity: 0.4,
                strokeWeight: 1,
                fillColor: color,
                fillOpacity: 0.4,
                clickable: true,
                editable: false
            });
            google.maps.event.addListener(polygon, 'mouseout', function()
            {
                this.setOptions({
                    editable: false
                });
                infoBubble.close();
            });
            google.maps.event.addListener(polygon, 'mouseover', function()
            {
                this.setOptions({
                    editable: true
                });
                infoBubble.setContent('<div class="phoneytext">' + this.properties.unemploye + '%</div>');
                infoBubble.setPosition(getCenter(this));
                infoBubble.open(map);
            });
            google.maps.event.addListener(polygon.getPath(), 'set_at', (function(polygon)
            {
                return function(number, elem)
                {
                    polygon.setPath(this);
                    savePolygon(polygon);
                };
            })(polygon));
            polygon.setMap(map);
        }
    });


</script>