<div id="map"></div>
<div class="modal hide" id="new_sector_modal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Редактирование метрики</h3>
    </div>
    <div class="modal-body">
        <form class="form-vertical">
            <input id="new_sector_title" />
            <?= CHtml::dropDownList('square_id', 1, CHtml::listData(Square::model()->findAll(), 'id', 'title'), array('id' => 'new_sector_square_id')) ?>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Отмена</a>
        <a href="#" id="new_sector_save" class="btn btn-primary">Сохранить</a>
    </div>
</div>

<script type="text/javascript">

    // Create the Google Map…
    var map = new google.maps.Map(d3.select("#map").node(), {
        zoom: 15,
        center: new google.maps.LatLng(51.149633, 71.466837),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var drawingManager = new google.maps.drawing.DrawingManager({
        drawingControl: true,
        drawingControlOptions: {
            drawingModes: [google.maps.drawing.OverlayType.POLYGON]
        },
        drawingMode: google.maps.drawing.OverlayType.POLYGON,
        polygonOptions: {
            fillColor: '#ffffff',
            fillOpacity: 1,
            strokeWeight: 5,
            clickable: true,
            editable: true
        }
    });
    drawingManager.setMap(map);

    google.maps.event.addListener(drawingManager, 'polygoncomplete', function(polygon) {
        $('#new_sector_modal').modal('show');
        $('#new_sector_save').click(function() {
            savePolygon(polygon, function() {
                $('#new_sector_modal').modal('hide');
                $('#new_sector_modal form').reset();
            });
            return false;
        });
    });


</script>