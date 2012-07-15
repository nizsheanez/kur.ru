function savePolygon(polygon)
{
    var vertices = polygon.getPath();
    var res = {};
    for (var i = 0; i < vertices.length; i++)
    {
        var xy = vertices.getAt(i);
        res['polygons['+polygon.properties.id+'][' + i + '][lat]'] = xy.lat();
        res['polygons['+polygon.properties.id+'][' + i + '][lng]'] = xy.lng();
    }

    $.post('/region/save', res);
}