<?php
Yii::app()->clientScript->registerCoreScript('jquery')->registerCoreScript('jquery.ui');

Yii::app()->clientScript->registerScriptFile('/js/debug.js');

Yii::app()->clientScript->registerScriptFile('/js/d3/d3.v2.js');

Yii::app()->clientScript->registerScriptFile('/js/downloadFile.js');
Yii::app()->clientScript->registerCssFile('/css/site/bootstrap/css/bootstrap.css');
Yii::app()->clientScript->registerCssFile('/css/site/bootstrap/css/bootstrap-responsive.css');
?>

<!--<div class="toolbar-sidebar well">-->
<!--    <input type="checkbox" name="use_path" id="use_path" />-->
<!--    <label for="use_path">Искривление путей</label>-->

<!--    <div class="nodes-holder"></div>-->
<!--    <div class="links-holder"></div>-->
<!--</div>-->
<div class="navbar navbar-fixed-top toolbar-top">
    <div class="navbar-inner">
        <div class="container" style="width: 100%">
            <div class="nav-collapse">
                <ul class="nav">
                    <li>
                        <form id="search-form" class="form-search">
                            <?php $this->widget('CAutoComplete', array(
                            'name'       => 'search',
                            'url'        => array('/dipl/run/autocomplete'),
                            'max'        => 20,
                            //specifies the max number of items to display
                            'minChars'   => 2,
                            'delay'      => 100,
                            //number of milliseconds before lookup occurs
                            'matchCase'  => false,
                            //match case when performing a lookup?
                            'htmlOptions'=> array("class"=> "input-medium search-query"),
                        ));
                            ?>
                            <button type="submit" class="btn">Поиск</button>
                        </form>
                    </li>
                    <li style="float: right;">
                        <div class="btn btn-mini" id="download"><i class="icon-download"></i></div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!--<div class="navbar navbar-fixed-top toolbar-top bottom">-->
<!--    <div class="navbar-inner">-->
<!--        <div class="container" style="width: 100%">-->
<!--            <div class="nav-collapse">-->
<!--                <ul class="nav">-->
<!--                    <li>-->
<!--                        <div class="btn btn-mini" id="download"><i class="icon-download"></i></div>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <input type="checkbox" name="use_path" id="use_path" />-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <span id="details"></span>-->
<!--                        <span>|</span>-->
<!--                        <span id="num"></span>-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<div class="demo" id="demo">
    <p>В поле поиск введите название предметной области. Далее вы увидите подсказку.</p>

    <p>Клик - раскрыть узел.</br>Двойной клик - удалить узел</p>
    <svg class="demo_svg">
        <line class="link associate" x1="0" x2="25" y1="0" y2="0"></line>
    </svg>
    <span>associate</span><br/>
    <svg class="demo_svg">
        <line class="link english" x1="0" x2="25" y1="0" y2="0"></line>
    </svg>
    <span>english</span><br/>
    <svg class="demo_svg">
        <line class="link sinonim" x1="0" x2="25" y1="0" y2="0"></line>
    </svg>
    <span>sinonim</span><br/>
    <svg class="demo_svg">
        <line class="link subclass_of" x1="0" x2="25" y1="0" y2="0"></line>
    </svg>
    <span>subclass_of</span><br/>
    <svg class="demo_svg">
        <line class="link is_a" x1="0" x2="25" y1="0" y2="0"></line>
    </svg>
    <span>is_a</span><br/>
</div>
<div id="chart" style=""></div>

<script type="text/javascript">
var w = $(document).width(),
    h = $(document).height();

var svg = d3.select("body").append("svg:svg")
    .attr("width", w)
    .attr("height", h)
    .attr("xmlns", "http://www.w3.org/2000/svg")
    .attr("version", "1.1")
    .attr("xmlns:xmlns:xlink", "http://www.w3.org/1999/xlink");

var opacityBlack = .75;
var chart = svg.attr("pointer-events", "all")
    .append('svg:g')
    .call(d3.behavior.zoom().on("zoom", function()
{
    chart.attr("transform",
        "translate(" + d3.event.translate + ")"
            + " scale(" + d3.event.scale + ")"
    );
}));
removeItem = function(array, index)
{
    array.splice(index, 1);
};

var pathChart = chart.append('g');

var force = d3.layout.force()
    .gravity(.14)
    .friction(.03)
    .linkDistance(130)
    .charge(-19200)
    .theta(.9)
    .size([w, h]);

var circle, path, text, plus, cancel;
var nodes = [];
var links = [];

var visNodes = [];
var visLinks = [];

var last_click = last_click2 = 0;
var is_dblclick = false;


var use_path = $('#use_path');

var linkedByIndex = [];

var curNode = {x: 300, y: 300};


function isNodeConnected(a, b)
{
    return linkedByIndex[a.name + "," + b.name] || linkedByIndex[b.name + "," + a.name] || a.name == b.name;
}

function fade(opacity, showText)
{
    return function(d, i)
    {
        $(d).parent().children('.cancel').css('display', 'block');
        labels = [];
        var selectedLabelData = null;
        chart.selectAll("circle").style("fill-opacity", function(o)
        {
            var isNodeConnectedBool = isNodeConnected(d, o);
            var thisOpacity = isNodeConnectedBool ? 1 : opacity;
            if (!isNodeConnectedBool)
            {
                $(this).parent().children().attr('style',
                    "stroke-opacity:" + opacity + ";fill-opacity:" + opacity + ";");
            }
            else
            {
                $(this).parent().children().attr('style', "stroke-opacity:1;fill-opacity:1;");
                //                labels.push(o);
                //                if (o == d) selectedLabelData = o;
            }
            return thisOpacity;
        });

        path.style("stroke-opacity", function(o)
        {
            return o.source === d || o.target === d ? 1 : opacity;
        });
    }
}

function normalizeNodesAndRemoveLabels()
{
    return function(d, i)
    {
        selectedLabelIndex = null;
        chart.selectAll(".link").style("stroke-opacity", opacityBlack);
        chart.selectAll("circle").style("stroke-opacity", opacityBlack).style("fill-opacity", opacityBlack);//.style("stroke-width", 1);
        chart.selectAll("text").style("stroke-opacity", opacityBlack).style("fill-opacity", opacityBlack);//.style("stroke-width", 1);
        //        chart.selectAll(".nodetext").remove();
    }
}
var lock = true;

// Use elliptical arc path segments to doubly-encode directionality.
var tick = function()
{
    path.attr("d", function(d)
    {
        var
            dx = d.target.x - d.source.x,
            dy = d.target.y - d.source.y,
            dr = Math.sqrt(dx * dx + dy * dy);
        return "M" + d.source.x + "," + d.source.y + "A" + dr + "," + dr + " 0 0,1 " + d.target.x + "," + d.target.y;
    });

    g.attr("transform", function(d)
    {
        return "translate(" + d.x + "," + d.y + ")";
    });

};


var addNodesLinks = function(json)
{

    // Compute the distinct nodes from the links.
    $.each(json.nodes, function(i, node)
    {
        if (!visNodes[node.name])
        {
            node.links = [];
            node.x = curNode.x;
            node.y = curNode.y;
            visNodes[node.name] = node;
            nodes.push(node);
        }
    });

    $.each(json.links, function(i, link)
    {
        if (!visLinks[link.id] && visNodes[link.source] && visNodes[link.target])
        {
            visLinks[link.id] = link;
            linkedByIndex[link.target + ',' + link.source] = true;
            link.source = visNodes[link.source];
            link.target = visNodes[link.target];
            link.source.links.push(link.id);
            link.target.links.push(link.id);
            links.push(link);
        }
    });
    force
        .nodes(nodes)
        .links(links);

};

var update = function(json)
{
    addNodesLinks(json);
    //toolbar interfaces
    /*
    var holder = $('.nodes-holder').empty();
    var lholder = $('.links-holder').empty();
    $.each(d3.values(nodes), function(i, el)
    {
        holder.append($('<div>').text(el.title).data('id', el.name));
    });
    $.each(links, function(i, el)
    {
        lholder.append($('<div>').text(el.source.name + ' : ' + el.target.name));
    });
    */

    // Update the paths…
    path = pathChart.selectAll("path.link").data(force.links());
    path.enter().append("svg:path")
        .attr("class", function(d)
        {
            return "link " + d.type + " t-" + d.target.name + " s-" + d.source.name;
        })
        .attr("id", function(d)
        {
            return "link_" + d.id;
        })
        .attr("marker-end", function(d)
        {
            return d.type == 'subclass_of' ? "url(#suit)" : "";
        });
    path.exit().remove();

    // Update the nodes…
    g = chart.selectAll("g.node").data(force.nodes());
    var a = g.enter().append("svg:g")
        .attr("class", "node")
        .attr("data-id", function(d)
        {
            return d.name
        });

    node = a.append("svg:circle")
        .attr("class", "node")
        .attr("r", function(d)
        {
            return 4 + d.e_count * .25;
        })
        .on('click', function(d)
        {
            var self = $(this);
            last_click2 = new Date().getTime() / 1000;
            if (last_click2 - last_click < .3)
            {
                is_dblclick = true;
                return false;
            }
            last_click = last_click2;
            time = setTimeout(function()
            {
                if (is_dblclick)
                {
                    is_dblclick = false;
                    var id = self.parent().data('id');
                    var vlinks = visNodes[id].links;
                    delete visNodes[id];
                    for (var i in vlinks)
                    {
                        var link_id = vlinks[i];
                        var link, j;

                        for (j in links)
                        {
                            if (links[j].id == link_id)
                            {
                                link = links[j];
                                removeItem(links, j);
                            }
                        }

                        $('#link_' + link_id).remove();
                        if (link != undefined)
                        {
                            linkedByIndex[link.target + ',' + link.source] = false;
                            linkedByIndex[link.source + ',' + link.target] = false;
                            delete visLinks[link_id];
                        }
                    }

                    for (var k in nodes)
                    {
                        if (nodes[k].name == id)
                        {
                            removeItem(nodes, k);
                        }
                    }
                    self.parent().remove();
                    force
                        .nodes(nodes)
                        .links(links);
                    force.start();
                }
                else
                {
                    curNode = d;
                    d3.json('/dipl/run/get/id/' + self.parent().data('id'), update);
                }
            }, 300);
        })
        .on("mouseover", fade(.2, true))
        .on("mouseout", normalizeNodesAndRemoveLabels());

    a.append("svg:text")
        .attr("x", 8)
        .attr("y", ".31em")
        .text(function(d)
        {
            return d.title;
        });


    g.exit().remove();
    force.start();
};

$('#search-form').submit(function()
{
    var self = $(this);
    var input = self.find('input');
    $.get('/dipl/run/search', $(this).serialize(),
        function(data)
        {
            input.removeClass('ac_loading');
            update(data);

        }, 'json');

    input.addClass('ac_loading');
    return false;
});

force.on("tick", tick);

$('#download').click(function()
{
    var res = [];
    for (var i in visNodes)
    {
        res.push(i);
    }
    $.fileDownload('/dipl/run/saveFile', {
        httpMethod: "POST",
        data: {ids: res.join(',')}
    });
    return false;
});


</script>
