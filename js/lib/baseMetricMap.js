(function(window, document, $, undefined)
{
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
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                mapTypeControl: false
            });
            that.drawPolygons(that.options.globalData);
            that.addDrawManager();
            $(window).trigger('hashchange');
        },
        drawPolygons: function(json)
        {
            var that = this;
            for (var i in json.features)
            {
                var shape = json.features[i];
                var paths = [];
                for (var j in shape.coordinates)
                {
                    var xy = shape.coordinates[j];
                    paths.push(new google.maps.LatLng(xy[0], xy[1]));
                }

                var polygon = new google.maps.Polygon({
                    id: shape.properties.id,
                    formula: shape.formula,
                    paths: paths,
                    strokeOpacity: 0.3,
                    strokeWeight: 1,
                    fillOpacity: 0.3,
                    clickable: true,
                    editable: false
                });

                that.polygons.push(polygon);

                var squareId = polygon.getProperty('square_id');
                if (that.squares[squareId] == undefined)
                {
                    that.squares[squareId] = new Square();
                    //                    that.bounds[squareId] = new google.maps.LatLngBounds();
                }
                that.squares[squareId].add(polygon);
                //                that.bounds[squareId].union(that.polygons[i].getBounds());

                google.maps.event.addListener(polygon, 'mouseout', function()
                {
                    this.setOptions({
                        editable: false,
                        zIndex: 1
                    });
                    that.infoBubble.close();
                });
                google.maps.event.addListener(polygon, 'mouseover', function()
                {
                    this.setOptions({
                        editable: true,
                        zIndex: 100
                    });
                    var content;
                    if ($.bbq.getState('type') == 'polygons')
                    {
                        content = this.bubbleText;
                    }
                    else
                    {
                        content = that.squares[polygon.getProperty('square_id')].bubbleText;
                    }
                    that.infoBubble.setContent('<div class="phoneytext">' + content + '</div>');
                    that.infoBubble.setPosition(this.getCenter());
                    that.infoBubble.open(this.map);
                });
                google.maps.event.addListener(polygon, 'click', function()
                {
                    $('#data_save_form').data('sector_id', this.id);
                    $('#data_save_form form').load('/regions/save/data?id=' + this.id + '&metric=' + that.currentMetric,
                        function()
                        {
                            $('#data_save_form').modal('show');
                        });
                });
                var polygonSave = function(polygon)
                {
                    return function(number, elem)
                    {
                        polygon.setPath(this);
                        polygon.save();
                    }
                };
                google.maps.event.addListener(polygon.getPath(), 'set_at', polygonSave(polygon));
                google.maps.event.addListener(polygon.getPath(), 'insert_at', polygonSave(polygon));
                polygon.setMap(this.map);
            }
        },
        addDrawManager: function()
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

            $('#new_sector_modal').on('hide', function()
            {
                //del polygon
                $('#new_sector_modal').data('polygon').setMap(null);
            });

            google.maps.event.addListener(this.drawingManager, 'polygoncomplete', function(polygon)
            {
                var vertices = polygon.getPath();
                var res = '';
                var id = polygon.id != undefined ? polygon.id : 0;

                for (var i = 0; i < vertices.length; i++)
                {
                    var xy = vertices.getAt(i);
                    res += '<input type="hidden" name="polygons[' + id + '][' + i + '][lat]" value="' + xy.lat() + '" />';
                    res += '<input type="hidden" name="polygons[' + id + '][' + i + '][lng]" value="' + xy.lng() + '" />';
                }

                var modal = $('#new_sector_modal').modal('show').data('polygon', polygon);
                modal.find('form').find('.additional').remove().
                    end().append($('<div class="additional"></div>').html(res));
            });

            //            $('#new_metric_modal').on('hide', function() {
            //                window.location.reload();
            //            });
        },
        _drawingManagerOn: function()
        {
            this.drawingManager.setMap(this.map);
        },
        _drawingManagerOff: function()
        {
            this.drawingManager.setMap(null);
        },
        _initPolygonObject: function()
        {
            var that = this;

            google.maps.Polygon.prototype.getProperty = function(name)
            {
                return that.options.globalData.features[this.id].properties[name];
            };

            google.maps.Polygon.prototype.getProperties = function()
            {
                return that.options.globalData.features[this.id].properties;
            };

            google.maps.Polygon.prototype.setProperty = function(key, val)
            {
                that.options.globalData.features[this.id].properties[key] = val;
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