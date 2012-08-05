(function(window, document, $, undefined)
{

    function Composite()
    {
        this.polygons = [];
        var that = this;

        this.add = function(polygon)
        {
            that.polygons[polygon.id] = polygon;
        };

        this.getProperty = function(name)
        {
            var res = 0;
            for (var i in this.polygons)
            {
                res += that.polygons[i].getProperty(name);
            }
            return res;
        };

        this.setColor = function(color)
        {
            for (var i in that.polygons)
            {
                that.polygons[i].setColor(color)
            }
        };

        this.setProperty = function(key, val)
        {

            for (var i in this.polygons)
            {
                that.polygons[i].setProperty(key, val)
            }
        };

        this.getProperties = function()
        {
            var leaf = that.polygons.pop();
            var props = leaf.getProperties();
            that.polygons.push(leaf);

            var res = {};
            for (var j in props)
            {
                res[j] = 0;
            }

            for (var i in that.polygons)
            {
                for (var j in props)
                {
                    var prop = that.polygons[i].getProperty(j);
                    res[j] += (prop == null) ? undefined : prop;
                }
            }
            //        res.area = that.getProperty('area');
            return res;
        };
    }

    $.widget("geo.baseMetricMap", {
        bounds: new Array(),
        map: {},
        polygons: new Array(),
        squares: new Array(),
        currentMetric: 'peoples',
        drawingManager: {},
        options: {
            globalData: {},
            greetings: "Hello"
        },
        _create: function()
        {
            var that = this;

            that._initPolygonObject();

            // Create the Google Map…
            that.map = new google.maps.Map(this.element[0], {
                zoom: 15,
                center: new google.maps.LatLng(51.149633, 71.466837),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            that.drawPolygons(that.options.globalData);
            that.addDrawManager();
            $(window).trigger('hashchange');
        },
        addDrawManager:function()
        {
            this.drawingManager = new google.maps.drawing.DrawingManager({
                drawingControl: true,
                drawingControlOptions: {
                    drawingModes: [google.maps.drawing.OverlayType.POLYGON]
                },
                drawingMode: null,
                polygonOptions: {
                    fillColor: '#ffffff',
                    fillOpacity: 1,
                    strokeWeight: 5,
                    clickable: true,
                    editable: true,
                    icon: '/img/polygon.png'
                }
            });

            $('#new_sector_modal').on('hide', function() {
                //del polygon
            });

            google.maps.event.addListener(this.drawingManager, 'polygoncomplete', function (polygon) {
                $('#new_sector_modal').modal('show');
                $('#new_sector_modal form').submit(function() {
                    polygon.save();
                });
//                $('#new_sector_save').off('click').click(function () {
//                    polygon.save(function () {
//                        $('#new_sector_modal').modal('hide');
//                    });
//                    return false;
//                });
            });


//            $('#new_metric_modal').on('hide', function() {
//                window.location.reload();
//            });
        },
        _drawingManagerOn:function()
        {
            this.drawingManager.setMap(this.map);
        },
        _drawingManagerOff:function()
        {
            this.drawingManager.setMap(null);
        },
        _initPolygonObject: function()
        {
            var that = this;
            google.maps.Polygon.prototype.getBounds = function() {
                var bounds = new google.maps.LatLngBounds();

                this.getPaths().forEach(function(path) {
                    path.forEach(function(point) {
                        bounds.extend(point);
                    });
                });

                return bounds;
            };

            google.maps.Polygon.prototype.__defineGetter__('area', function()
            {
                return google.maps.geometry.spherical.computeArea(this.getPaths());
            });

            google.maps.Polygon.prototype.__defineGetter__('density', function()
            {
                return this.getProperty('peoples') / this.area;
            });

            google.maps.Polygon.prototype.getProperty = function(name)
            {
                return that.options.globalData.features[this.id].properties[name];
            };

            google.maps.Polygon.prototype.setColor = function(color)
            {
                this.setOptions({
                    strokeColor: '#'+color,
                    fillColor: '#'+color
                });
            };

            google.maps.Polygon.prototype.getProperties = function()
            {
                return that.options.globalData.features[this.id].properties;
            };

            google.maps.Polygon.prototype.setProperty = function(key, val)
            {
                that.options.globalData.features[this.id].properties[key] = val;
            };
            google.maps.Polygon.prototype.getCenter = function()
            {
                var bounds = new google.maps.LatLngBounds();
                var coordinates = this.getPath();
                for (i = 0; i < coordinates.length; i++)
                {
                    bounds.extend(coordinates.getAt(i));
                }
                return bounds.getCenter();
            };

            google.maps.Polygon.prototype.save = function(callback)
            {
                var vertices = this.getPath();
                var res = {};
                var id = this.id != undefined ? this.id : 0;

                for (var i = 0; i < vertices.length; i++)
                {
                    var xy = vertices.getAt(i);
                    res['polygons[' + id + '][' + i + '][lat]'] = xy.lat();
                    res['polygons[' + id + '][' + i + '][lng]'] = xy.lng();
                }
                if (this.id == undefined)
                {
                    res.title = $('#new_sector_title').val();
                    res.square_id = $('#new_sector_square_id').val();
                }
                $.post('/regions/save/polygons', res, callback);
            };

        },
        _hexFromRGB: function(r, g, b)
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
    })
}(window, document, jQuery));