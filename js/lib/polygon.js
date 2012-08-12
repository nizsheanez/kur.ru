accessors.define(google.maps.Polygon, 'area', {
    get: function()
    {
        return google.maps.geometry.spherical.computeArea(this.getPaths());
    }
});

accessors.define(google.maps.Polygon, 'density', {
    get: function()
    {
        return this.getProperty('peoples') / this.area;
    }
});

google.maps.Polygon.prototype.setColor = function(color)
{
    this.setOptions({
        strokeColor: '#' + color,
        fillColor: '#' + color
    });
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

google.maps.Polygon.prototype.getBounds = function()
{
    var bounds = new google.maps.LatLngBounds();

    this.getPaths().forEach(function(path)
    {
        path.forEach(function(point)
        {
            bounds.extend(point);
        });
    });

    return bounds;
};
