function savePolygon(polygon) {
    var vertices = polygon.getPath();
    var res = {};
    for (var i = 0; i < vertices.length; i++) {
        var xy = vertices.getAt(i);
        res['polygons[' + polygon.properties.id + '][' + i + '][lat]'] = xy.lat();
        res['polygons[' + polygon.properties.id + '][' + i + '][lng]'] = xy.lng();
    }

    $.post('/region/save', res);
}

function getCenter(polygon) {
    var bounds = new google.maps.LatLngBounds();
    var coordinates = polygon.getPath();
    for (i = 0; i < coordinates.length; i++) {
        bounds.extend(coordinates.getAt(i));
    }
    return bounds.getCenter();
}

$.widget("geo.metricMap", {
    infoBubble: new InfoBubble({
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
    }),
    map: {},
    polygons: [],
    currentMetric: 'peoples',
    options: {
        greetings: "Hello"
    },
    _create: function () {
        var that = this;
        // Create the Google Map…
        that.map = new google.maps.Map(this.element[0], {
            zoom: 15,
            center: new google.maps.LatLng(51.149633, 71.466837),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        that.drawPolygons(that.options.globalData);
        that.colorize(that.polygons, that.options.globalData);

        $('#navigation a').click(function () {
            var state = {},
                url = $(this).attr('href').replace(/^#/, '');
            state['metric'] = url;
            $.bbq.pushState(state);
            return false;
        });

        $(window).bind('hashchange', function (e) {
            var url = $.param.fragment();
            that.currentMetric = $.bbq.getState('metric', true) || 'people';
            that.colorize(that.polygons, that.options.globalData);
        });

        $(window).trigger('hashchange');
    },
    _hexFromRGB: function (r, g, b) {
        var hex = [
            Math.ceil(r).toString(16),
            Math.ceil(g).toString(16),
            Math.ceil(b).toString(16)
        ];
        $.each(hex, function (nr, val) {
            if (val.length === 1) {
                hex[ nr ] = "0" + val;
            }
        });
        return hex.join("").toUpperCase();
    },
    colorize: function (polygons, json) {
        var metric = json.metrics[this.currentMetric];
        var color;
        for (var i in polygons) {
            var polygon = polygons[i];
            var squareMetric = polygon.properties[this.currentMetric];
            if (squareMetric != undefined) {
                n = polygon.properties[this.currentMetric] / polygon.density - metric.norma;
                n = 100 / (metric.critical - metric.norma) * n;

                if (n < 0) {
                    n = 1;
                }
                if (n > 100) {
                    n = 100;
                }

                color = this._hexFromRGB((255 * n) / 100, (200 * (100 - n)) / 100, 0);
            } else {
                color = this._hexFromRGB(0, 0, 0);
            }
            polygon.setOptions({
                strokeColor: color,
                fillColor: color
            });
        }
    },
    drawPolygons: function (json) {
        var that = this;
        for (var i in json.features) {
            var shape = json.features[i];
            var paths = [];
            for (var j in shape.coordinates) {
                var xy = shape.coordinates[j];
                paths.push(new google.maps.LatLng(xy[0], xy[1]));
            }

            var area = google.maps.geometry.spherical.computeArea(paths);
            var density = shape.properties.peoples / area;

            var polygon = new google.maps.Polygon({
                properties: shape.properties,
                area: area,
                density: density,
                paths: paths,
                strokeOpacity: 0.4,
                strokeWeight: 1,
                fillOpacity: 0.4,
                clickable: true,
                editable: false
            });
            this.polygons.push(polygon);
            google.maps.event.addListener(polygon, 'mouseout', function () {
                this.setOptions({
                    editable: false
                });
                that.infoBubble.close();
            });
            google.maps.event.addListener(polygon, 'mouseover', function () {
                this.setOptions({
                    editable: true
                });
                that.infoBubble.setContent('<div class="phoneytext">' + (this.properties[that.currentMetric] != undefined ? this.properties[that.currentMetric] + '%' : 'Нет данных') + '</div>');
                that.infoBubble.setPosition(getCenter(this));
                that.infoBubble.open(this.map);
            });
            google.maps.event.addListener(polygon.getPath(), 'set_at', (function (polygon) {
                return function (number, elem) {
                    polygon.setPath(this);
                    savePolygon(polygon);
                };
            })(polygon));
            polygon.setMap(this.map);
        }
    }


});