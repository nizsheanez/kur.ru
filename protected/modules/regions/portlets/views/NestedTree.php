<div id="<?php echo $this->id ?>" class="<?php echo $this->sortable ? 'nestedSortable' : 'tree' ?>">
    <?php echo $tree ?>
</div>

<input id="sortable_tree_submit" class="submit mid" type="submit"/>

<script>
    $(document).ready(function()
    {
        var id = '<?php echo $this->id ?>';
        var tree = $('#' + id + ' > ul');
        $('#sortable_tree_submit').click(function()
        {
            var data = tree.nestedSortable('toArray');
            $.post('/regions/save/sortMetrics',
                {
                    tree:$.toJSON(data)
                },
                function(data)
                {
                    if (data.status == 'ok')
                    {
                    }
                },
                'json'
            );
            return false;
        });

        $('#sortable_tree_cancel').click(function()
        {
            return false;
        });

    })
    ;

</script>