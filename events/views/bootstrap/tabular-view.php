<!--
    T A B L E
    styles: basic / shadow
    ===================================
    Add/replace the beolow classes to the div with class "aj-table"
    ===================================
    class for view: aj-table--basic / aj-table--shadow
    class for alt row grey: aj-table--alternate
    class for price: aj--hasprice
    class for time: aj--hastime
    class for desc: aj--hasdesc
-->
<div class="aj">
    <h3 class="aj__title">Upcoming Events</h3>
    <div id="data-<?php echo $shortcode_id; ?>" class="aj-table aj-table--<?php echo $atts['style']; ?> aj--hasprice aj--hastime aj--hasdesc">
        <div class="aj-table__info aj-table--header row">
            <div class="aj-table__name col-md-6 col-sm-6">Event Title</div>
            <div class="aj__address aj-table__address col-md-3 col-sm-3">Location</div>
            <div class="aj-table__date col-md-3 col-sm-3">Date</div>
        </div>
        <?php foreach($event_data['events'] as $event) : ?>
            <?php include(dirname( __FILE__ )  . '/tabular-view-item.php' ); ?>
        <?php endforeach; ?>
    </div>
    <div class="text-center aj-table__navi">
        <?php if($atts['count'] < $event_data['count']) : ?>
            <a id="<?php echo $shortcode_id; ?>" href="" class="aj__link aj--loadmore">Load More</a>
        <?php endif; ?>
        <a href="<?php echo esc_url( tribe_get_events_link() ); ?>" class="aj__button aj--viewall btn btn-primary pull-right">View All</a>
    </div>
    <script type="text/javascript">
        /* <![CDATA[ */
        var event_codes_sc_atts_<?php echo $shortcode_id; ?> = <?php print json_encode($atts); ?>;
        /* ]]> */
    </script>
</div>
<!--
    / E N D
    T A B L E
-->
