<?php
Yii::app()->clientScript->registerCoreScript('jquery')->registerCoreScript('jquery.ui');

Yii::app()->clientScript->registerScriptFile('/js/debug.js');

Yii::app()->clientScript->registerScriptFile('/js/d3/d3.v2.js');

Yii::app()->clientScript->registerCssFile('/css/site/bootstrap/css/bootstrap.css');
Yii::app()->clientScript->registerCssFile('/css/site/bootstrap/css/bootstrap-responsive.css');
?>

<!--<div class="toolbar-sidebar well">-->
<!--    <div class="nodes-holder"></div>-->
<!--    <div class="links-holder"></div>-->
<!--</div>-->
<div class="navbar navbar-fixed-top toolbar-top">
    <div class="navbar-inner">
        <div class="container">
            <div class="nav-collapse">
                <ul class="nav">
                    <li>
                        <form id="search-form" class="form-search">
                            <?php $this->widget('CAutoComplete', array(
                            'name'       => 'search',
                            'url'        => array('/run/autocomplete'),
                            'max'        => 20, //specifies the max number of items to display
                            'minChars'   => 2,
                            'delay'      => 100, //number of milliseconds before lookup occurs
                            'matchCase'  => false, //match case when performing a lookup?
                            'htmlOptions'=> array("class"=> "input-medium search-query"),
                        ));
                            ?>
                            <button type="submit" class="btn">Поиск</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="navbar navbar-fixed-top toolbar-top bottom">
    <div class="navbar-inner">
        <div class="container">
            <div class="nav-collapse">
                <ul class="nav">
                    <li>
                        <div class="btn btn-mini" id="download"><i class="icon-download"></i></div>
                    </li>
                    <li>
                        <div class="btn btn-mini" id="closer"><i class="icon-plus-sign"></i></div>
                    </li>
                    <li>
                        <div class="btn btn-mini" id="further"><i class="icon-minus-sign"></i></div>
                    </li>
                    <li>
                        <input type="checkbox" name="use_path" id="use_path" />
                    </li>
                    <li>
                        <span id="details"></span>
                        <span>|</span>
                        <span id="num"></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div id="chart" style=""></div>

<script type="text/javascript">
//var fill = d3.scale.category20();

var w = $(document).width(),
    h = $(document).height();

var svg = d3.select("body").append("svg:svg")
    .attr("width", w)
    .attr("height", h);

var chart = svg.attr("pointer-events", "all")
    .append('svg:g')
    /*.call(d3.behavior.zoom().on("zoom", function()
{
    chart.attr("transform",
        "translate(" + d3.event.translate + ")"
            + " scale(" + d3.event.scale + ")"
    );
}))
*/
;

var force = d3.layout.force()
    .gravity(.14)
    .friction(.3)
    .linkDistance(50)
    .charge(-1400)
    .theta(.9)
    .size([w, h]);

var circle, path, text, plus, cancel;
var nodes = [];
var links = [];

var visNodes = [];
var visLinks = [];

var use_path = $('#use_path');

var linkedByIndex = {};

function isNodeConnected(a, b) {
    return linkedByIndex[a.name + "," + b.name] || linkedByIndex[b.name + "," + a.name] || a.name == b.name;
}

function fade(opacity, showText) {
    return function(d, i) {
        labels = [];
        var selectedLabelData = null;
        chart.selectAll("circle").style("fill-opacity", function(o) {
            var isNodeConnectedBool = isNodeConnected(d, o);
            var thisOpacity = isNodeConnectedBool ? 1 : opacity;
            if (!isNodeConnectedBool) {
                $(this).parent().children().attr('style', "stroke-opacity:"+opacity+";fill-opacity:"+opacity+";");
            } else {
//                labels.push(o);
                if (o == d) selectedLabelData = o;
            }
            return thisOpacity;
        });

        path.style("stroke-opacity", function(o) {
            return o.source === d || o.target === d ? 1 : opacity;
        });
    }
}

function normalizeNodesAndRemoveLabels() {
    return function(d, i) {
        selectedLabelIndex = null;
        chart.selectAll("line").style("stroke-opacity", 1);
        chart.selectAll("circle").style("stroke-opacity", 1).style("fill-opacity", 1);//.style("stroke-width", 1);
        chart.selectAll("text").style("stroke-opacity", 1).style("fill-opacity", 1);//.style("stroke-width", 1);
//        chart.selectAll(".nodetext").remove();
    }
}

var fps = 0, now, lastUpdate = (new Date)*1 - 1;

// The higher this value, the less the FPS will be affected by quick changes
// Setting this to 1 will show you the FPS of the last sampled frame only
var fpsFilter = 50;
var details = $('#details');
var num = $('#num');
function doFps(){

    var thisFrameFPS = 1000 / ((now=new Date) - lastUpdate);
    fps += (thisFrameFPS - fps) / fpsFilter;
    details.text(fps);
    num.text(force.nodes().length);
    lastUpdate = now * 1 - 1;
}


// Use elliptical arc path segments to doubly-encode directionality.
var tick = function()
{
    /*
    path
        .attr("d", function(d)
        {
            var
//                dx = d.target.x - d.source.x,
//                dy = d.target.y - d.source.y,
//                dr = use_path.prop('checked') ? Math.sqrt(dx * dx + dy * dy) : 0;
                dr = 0;
            return "M" + d.source.x + "," + d.source.y + "A" + dr + "," + dr + " 0 0,1 " + d.target.x + "," + d.target.y;
        });
    */

    path
        .attr("x1", function(d) { return d.source.x; })
        .attr("y1", function(d) { return d.source.y; })
        .attr("x2", function(d) { return d.target.x; })
        .attr("y2", function(d) { return d.target.y; });

    g.attr("transform", function(d)
    {
        return "translate(" + d.x + "," + d.y + ")";
    });

    doFps();
};


var addNodesLinks = function(json)
{
    // Compute the distinct nodes from the links.
    $.each(json.nodes, function(i, node) {
        if (!visNodes[node.name])
        {
            visNodes[node.name] = node;
            nodes.push(node);
        }
    });

    $.each(json.links, function(i, link) {
        if (!visLinks[link.id])
        {
            visLinks[link.id] = link;
            linkedByIndex[link.target + ',' + link.source] = true;
            link.source = visNodes[link.source];
            link.target = visNodes[link.target];
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
    path = chart.selectAll("line.link").data(force.links());
    path.enter().append("svg:line")
        .attr("class", function(d)
        {
            return "link " + d.type;
        })
        .attr("marker-end", function(d)
        {
            if (d.type == 'subclass_of')
            {
                return "url(#suit)";
            }
            else
            {
                return '';
            }
        });
    path.exit().remove();

    // Update the nodes…
    g = chart.selectAll("g").data(force.nodes());
    var a = g.enter().append("svg:g")
        .attr("class", "node")
        .attr("data-id", function(d)
        {
            return d.name
        });

    node = a.append("svg:circle")
        .attr("class", "node")
        .attr("r", 6)
        .on('click', function()
        {
            d3.json('/run/get/id/' + $(this).parent().data('id'), update);
        })
        .on("mouseover", fade(.1, true))
        .on("mouseout", normalizeNodesAndRemoveLabels());

    a.append("svg:text")
        .attr("x", 8)
        .attr("y", ".31em")
        .text(function(d)
        {
            return d.title;
        });

//    a.append("svg:a")
//        .attr('width', 10)
//        .attr('height', 10)
//        .text("x")
//        .attr('class', 'cancel')
//        .attr('id', function(d) {return 'cancel_'+d.name})
//        .attr("x", 1)
//        .attr("y", -6);

//    a.append('svg:text')
//        .attr('id', function(d) {return 'plus_'+d.name})
//        .attr('class', 'plus')
//        .attr('width', 20)
//        .attr('height', 20)
//        .attr("x", -10)
//        .attr("y", -4)
//        .text(function(node)
//        {
//            return node.e_count > node.visible_edge_count && !node.opened ? '+' : '';
//        });


    g.exit().remove();
    force.start();
};

$('#search-form').submit(function()
{
    var self = $(this);
    var input = self.find('input');
    $.get('/run/search', $(this).serialize(),
        function(data)
        {
            input.removeClass('ac_loading');
            update(data);

        }, 'json');

    input.addClass('ac_loading');
    return false;
});

force.on("tick", tick);


$('#closer').click(function()
{
    chart.mousewheel();
    return false;
});
$('#further').click(function()
{
    return false;
});

</script>
