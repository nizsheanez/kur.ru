(function(window, document, $, undefined)
{
    $.widget("geo.metricMap", $.geo.baseMetricMap, {
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
            maxWidth: 300
        }),
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
            $.geo.baseMetricMap.prototype._create.call(this);
            this._drawingManagerOn();
            $('.fancy').fancybox({
                fitToView: false,
                width: '70%',
                height: '70%',
                autoSize: false,
                closeClick: false,
                openEffect: 'none',
                closeEffect: 'none'
            });
            var that = this;

            $('#navigation ul a').filter(':not(.fancy)').filter(':not(.no-hashe)').click(function()
            {
                var state = {},
                    url = $(this).attr('href').replace(/^#/, '');
                state['metric'] = url;
                state['type'] = $(this).closest('ul').data('type');
                $.bbq.pushState(state);
                return false;
            });

            $('#sector_delete').click(function() {
                window.location.href = '/regions/save/deleteSector?id='+$('#data_save_form').data('sector_id');
            });
            $('#formula_save').click(function()
            {
                var btn = $(this);
                btn.text('......');
                $.post('/regions/save/metric', {
                    metric: that.currentMetric,
                    data: {
                        formula: $('#metric_formula').val(),
                        min: $('#metric_min').val(),
                        norma: $('#metric_norma').val(),
                        max: $('#metric_max').val()
                    }
                }, function()
                {
                    that.colorize();
                    btn.text('Сохранить');
                });
                $('#metric_form').modal('hide');
                return false;
            });
//            $('form').submit(function()
//            {
//                return false;
//            });
            $('#data_save').click(function()
            {
                var btn = $(this);
                btn.text('......');
                $.post('/regions/save/data', $('#data_save_form form').serialize(), function(globalData)
                {
                    that.options.globalData = globalData;
                    that.colorize();
                    btn.text('Сохранить');
                }, 'json');
                $('#data_save_form').modal('hide');
                return false;
            });
            $('.dropdown-toggle').dropdown();
            $(window).bind('hashchange', function(e)
            {
                var url = $.param.fragment();
                that.currentMetric = $.bbq.getState('metric', true) || 'peoples';
                var metric = that.options.globalData.metrics[that.currentMetric];
                $('#metric_formula').val(metric.formula);
                $('#metric_min').val(metric.min);
                $('#metric_norma').val(metric.norma);
                $('#metric_max').val(metric.max);

                $('#navigation .active').removeClass('active');
                $('#navigation a[href=#' + that.currentMetric + ']').parent().addClass('active').parent().parent().addClass('active');

                that.colorize();
            });

            $(window).trigger('hashchange');
        },
        colorize: function()
        {
            var color;
            var that = this;
            var items = that[$.bbq.getState('type')];

            var m = {
                formula: $('#metric_formula').val(),
                min: $('#metric_min').val() + ';',
                norma: $('#metric_norma').val() + ';',
                max: $('#metric_max').val() + ';'
            };

            for (var i in items)
            {
                var polygon = items[i];
                var metric = polygon.getProperty(that.currentMetric);
                if (metric != undefined && m.formula != '')
                {
                    var result, _a, _b, _c;
                    with (polygon)
                    {
                        extract(polygon.getProperties());
                        result = eval(m.formula);
                        _a = eval(m.min);
                        _b = eval(m.norma);
                        _c = eval(m.max);
                    }
                    polygon.bubbleText = 'Формула: ' + m.formula + ' = ' + Math.round(result * 100) / 100;
                    polygon.bubbleText+= '<br/>';
                    polygon.bubbleText+= 'Минимум: ' + m.min + ' = ' + Math.round(_a * 100) / 100;
                    polygon.bubbleText+= '<br/>';
                    polygon.bubbleText+= 'Норма: ' + m.norma + ' = ' + Math.round(_b * 100) / 100;
                    polygon.bubbleText+= '<br/>';
                    polygon.bubbleText+= 'Максимум: ' + m.max + ' = ' + Math.round(_c * 100) / 100;
                    polygon.bubbleText+= '<br/>';


                    if (result == Infinity || _a == Infinity || _b == Infinity || _c == Infinity ||
                        result == undefined || _a == undefined || _b == undefined || _c == undefined)
                    {
                        n = undefined;
                        color = this._hexFromRGB(0, 0, 0);
                    }
                    else
                    {
                        // transfer a to zero
                        result -= _a;
                        _c -= _a;
                        _b -= _a;
                        _a -= _a;

                        if (result > _b)
                        {
                            // transfer b to zero
                            result -= _b
                            _c -= _b;
                            _b -= _b;

                            n = 100 + 100 * result / _c;
                        }
                        else
                        {
                            n = 100 * result / _b;
                        }


                        polygon.bubbleText += '<br/>Проценты: ' + Math.ceil(n) + '%';
                        n -= 100;
                        n = (n > 100) ? 100 : (n < -100 ? -100 : n);

                        if (n < 0)
                        {
                            color = this._hexFromRGB((255 * (-n)) / 100, (255 * (100 - (-n))) / 100, 0);
                        }
                        else
                        {
                            color = this._hexFromRGB(0, (255 * (100 - n)) / 100, (255 * n) / 100);
                        }
                    }
                }
                else
                {
                    color = this._hexFromRGB(0, 0, 0);
                }

                polygon.setColor(color);
            }
        }

    })

}(window, document, jQuery));