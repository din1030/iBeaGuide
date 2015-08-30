

<div class="col-md-6">
    <legend>展覽品列表</legend>
    <ul id="items_list" class="connectedSortable">
        <li class="ui-state-default">Item 1</li>
        <li class="ui-state-default">Item 2</li>
        <li class="ui-state-default">Item 3</li>
        <li class="ui-state-default">Item 4</li>
        <li class="ui-state-default">Item 5</li>
    </ul>
</div>
<div class="col-md-6">
    <legend>路線排序</legend>
    <div class="well">
        <div class="clearfix" style="">
            <ul id="in_route_list" class="connectedSortable">
                <li class="ui-state-highlight">Item 1</li>
                <li class="ui-state-highlight">Item 2</li>
                <li class="ui-state-highlight">Item 3</li>
                <li class="ui-state-highlight">Item 4</li>
                <li class="ui-state-highlight">Item 5</li>
            </ul>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#items_list, #in_route_list").sortable({
            connectWith: ".connectedSortable"
        }).disableSelection();
    });
</script>
