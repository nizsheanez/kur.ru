function savePolygon(polygon) {
    var vertices = polygon.getPath();
    var res = {};
    for (var i = 0; i < vertices.length; i++) {
        var xy = vertices.getAt(i);
        res['polygons[' + polygon.id + '][' + i + '][lat]'] = xy.lat();
        res['polygons[' + polygon.id + '][' + i + '][lng]'] = xy.lng();
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

function Composite() {
    this.polygons = [];
    var that = this;

    this.add = function (polygon) {
        that.polygons[polygon.id] = polygon;
    };

    this.getProperty = function (name) {
        var res = 0;
        for (var i in this.polygons) {
            res += that.polygons[i].getProperty(name);
        }
        return res;
    };

    this.setColor = function (color) {
        for (var i in that.polygons) {
            that.polygons[i].setColor(color)
        }
    };

    this.setProperty = function (key, val) {

        for (var i in this.polygons) {
            that.polygons[i].setProperty(key, val)
        }
    };

    this.getProperties = function() {
        var leaf = that.polygons.pop();
        var res = leaf.getProperties();
        that.polygons.push(leaf);
        return res;
    };
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
    squares: [],
    currentMetric: 'peoples',
    options: {
        globalData: {},
        greetings: "Hello"
    },
    _create: function () {

        var that = this;

        google.maps.Polygon.prototype.getProperty = function (name) {
            return that.options.globalData.features[this.id].properties[name];
        };

        google.maps.Polygon.prototype.setColor = function (color) {
            this.setOptions({
                strokeColor: color,
                fillColor: color
            });
        };

        google.maps.Polygon.prototype.getProperties = function () {
            return that.options.globalData.features[this.id].properties;
        };

        google.maps.Polygon.prototype.setProperty = function (key, val) {
            that.options.globalData.features[this.id].properties[key] = val;
        };

        // Create the Google Map…
        that.map = new google.maps.Map(this.element[0], {
            zoom: 15,
            center: new google.maps.LatLng(51.149633, 71.466837),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        that.drawPolygons(that.options.globalData);
        that.squares[1] = new Composite();

        for (var i in that.polygons) {
            that.squares[that.polygons[i].getProperty('square_id')].add(that.polygons[i]);
        }

        $('#navigation ul a').click(function () {
            var state = {},
                url = $(this).attr('href').replace(/^#/, '');
            state['metric'] = url;
            state['type'] = $(this).closest('ul').data('type');
            $.bbq.pushState(state);
            return false;
        });

        $('#formula_save').click(function () {
            var btn = $(this);
            btn.text('......');
            $.post('/region/saveFormula', {
                metric: that.currentMetric,
                formula: $('#formula').val()
            }, function () {
                that.colorize();
                btn.text('Сохранить');
            });
            $('#metric_form').modal('hide');
            return false;
        });
        $('#form').submit(function () {
            return false;
        });
        $('#data_save').click(function () {
            var btn = $(this);
            btn.text('......');
            $.post('/region/saveData', $('#data_save_form form').serialize(), function (globalData) {

                for (var i in globalData.features) {
                    that.polygons[i].setProperties(globalData.features[i]);
                }
                that.colorize();
                btn.text('Сохранить');
            }, 'json');
            $('#data_save_form').modal('hide');
            return false;
        });
        $('.dropdown-toggle').dropdown();
        $(window).bind('hashchange', function (e) {
            var url = $.param.fragment();
            that.currentMetric = $.bbq.getState('metric', true) || 'peoples';
            $('#formula').val(that.options.globalData.metrics[that.currentMetric].formula);
            that.colorize();
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
    colorize: function () {
        var color;
        var that = this;
        var items = that[$.bbq.getState('type')];
        for (var i in items) {
            var polygon = items[i];
            var metric = polygon.getProperty(that.currentMetric);
            var density = polygon.density;
            if (metric != undefined && $('#formula').val() != '') {
                with (this) {
                    extract(polygon.getProperties());
                    n = eval($('#formula').val());
                }
                polygon.bubbleText = Math.ceil(n) + '%';

                n -= 100;
                if (n < -100) {
                    n = -100;
                } else if (n > 100) {
                    n = 100;
                }

                if (n < 0)
                    color = this._hexFromRGB((255 * (-n)) / 100, (255 * (100 - (-n))) / 100, 0);
                else
                    color = this._hexFromRGB(0, (255 * (100 - n)) / 100, (255 * n) / 100);

            } else {
                color = this._hexFromRGB(0, 0, 0);
            }

            polygon.setColor(color);
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
                id: shape.properties.id,
                formula: shape.formula,
                area: area,
                density: density,
                paths: paths,
                strokeOpacity: 0.3,
                strokeWeight: 1,
                fillOpacity: 0.3,
                clickable: true,
                editable: false
            });

            that.polygons[polygon.id] = polygon;

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
                that.infoBubble.setContent('<div class="phoneytext">' + (this.bubbleText) + '</div>');
                that.infoBubble.setPosition(getCenter(this));
                if ($.bbq.getState('type') == 'polygons')
                {
                    that.infoBubble.open(this.map);
                }
            });
            google.maps.event.addListener(polygon, 'click', function () {
                $('#data_save_form form').load('/region/saveData?id=' + this.id + '&metric=' + that.currentMetric, function () {
                    $('#data_save_form').modal('show');
                });
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


function extract(arr, type, prefix) {
    // Imports variables into symbol table from an array
    //
    // version: 1109.2015
    // discuss at: http://phpjs.org/functions/extract
    // +   original by: Brett Zamir (http://brett-zamir.me)
    // %        note 1: Only works by extracting into global context (whether called in the global scope or
    // %        note 1: within a function); also, the EXTR_REFS flag I believe can't be made to work
    // *     example 1: size = 'large';
    // *     example 1: var_array = {'color' : 'blue', 'size' : 'medium', 'shape' : 'sphere'};
    // *     example 1: extract(var_array, 'EXTR_PREFIX_SAME', 'wddx');
    // *     example 1: color+'-'+size+'-'+shape+'-'+wddx_size;
    // *     returns 1: 'blue-large-sphere-medium'
    if (Object.prototype.toString.call(arr) === '[object Array]' &&
        (type !== 'EXTR_PREFIX_ALL' && type !== 'EXTR_PREFIX_INVALID')) {
        return 0;
    }
    var targetObj = this.window;
    if (this.php_js && this.php_js.ini && this.php_js.ini['phpjs.extractTargetObj'] && this.php_js.ini['phpjs.extractTargetObj'].local_value) { // Allow designated object to be used instead of window
        targetObj = this.php_js.ini['phpjs.extractTargetObj'].local_value;
    }
    var chng = 0;

    for (var i in arr) {
        var validIdent = /^[_a-zA-Z$][\w|$]*$/; // TODO: Refine regexp to allow JS 1.5+ Unicode identifiers
        var prefixed = prefix + '_' + i;
        try {
            switch (type) {
                case 'EXTR_PREFIX_SAME' || 2:
                    if (targetObj[i] !== undefined) {
                        if (prefixed.match(validIdent) !== null) {
                            targetObj[prefixed] = arr[i];
                            ++chng;
                        }
                    } else {
                        targetObj[i] = arr[i];
                        ++chng;
                    }
                    break;
                case 'EXTR_SKIP' || 1:
                    if (targetObj[i] === undefined) {
                        targetObj[i] = arr[i];
                        ++chng;
                    }
                    break;
                case 'EXTR_PREFIX_ALL' || 3:
                    if (prefixed.match(validIdent) !== null) {
                        targetObj[prefixed] = arr[i];
                        ++chng;
                    }
                    break;
                case 'EXTR_PREFIX_INVALID' || 4:
                    if (i.match(validIdent) !== null) {
                        if (prefixed.match(validIdent) !== null) {
                            targetObj[prefixed] = arr[i];
                            ++chng;
                        }
                    } else {
                        targetObj[i] = arr[i];
                        ++chng;
                    }
                    break;
                case 'EXTR_IF_EXISTS' || 6:
                    if (targetObj[i] !== undefined) {
                        targetObj[i] = arr[i];
                        ++chng;
                    }
                    break;
                case 'EXTR_PREFIX_IF_EXISTS' || 5:
                    if (targetObj[i] !== undefined && prefixed.match(validIdent) !== null) {
                        targetObj[prefixed] = arr[i];
                        ++chng;
                    }
                    break;
                case 'EXTR_REFS' || 256:
                    throw 'The EXTR_REFS type will not work in JavaScript';
                case 'EXTR_OVERWRITE' || 0:
                // Fall-through
                default:
                    targetObj[i] = arr[i];
                    ++chng;
                    break;
            }
        } catch (e) { // Just won't increment for problem assignments
        }
    }
    return chng;
}