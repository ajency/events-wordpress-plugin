<!--
    T A B L E
    styles: basic / shadow
    ===================================
    Add/replace the beolow classes to the div with class "aj-table"
    ===================================
    class for layout: aj-table--basic / aj-table--shadow
    class for alt row grey: aj-table--alternate
    class for price: aj--hasprice
    class for time: aj--hastime
    class for desc: aj--hasdesc
-->
<div class="aj">
    <h3 class="aj__title">Upcoming Events</h3>
        <div class="aj-table aj-table--<?php echo $atts['style']; ?> aj--hasprice aj--hastime aj--hasdesc">
            <div class="aj-table__info aj-table--header">
                <div class="aj-table__name">Event Title</div>
                <div class="aj__address aj-table__address">Location</div>
                <div class="aj-table__date">Date</div>
            </div>
            <?php foreach($event_data as $event) : ?>
                <?php include(dirname( __FILE__ )  . '/tabular-view-item.php' ); ?>
            <?php endforeach; ?>
        </div>
        <div class="text-center aj-table__navi">
            <a href="#" class="aj__link aj--loadmore">Load More</a>
            <a href="#" class="aj__button aj--viewall">View All</a>
        </div>
</div>
<!--
    / E N D
    T A B L E
-->
