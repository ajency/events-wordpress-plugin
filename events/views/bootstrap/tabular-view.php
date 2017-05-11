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
    <h3 class="aj__title"><?php echo $event_data->event_range_lbl; ?> Events</h3>
    <div id="data-<?php echo $shortcode_id; ?>" class="aj-table aj-table--<?php echo $atts['style']; ?> <?php echo $atts['row'] == 'alternate-gray' ? 'aj-table--alternate':'' ?> <?php echo $atts['description'] ? 'aj--hasdesc':'' ?> <?php echo $atts['showtime'] ? 'aj--hastime':'' ?> aj--hasprice">
        <div class="aj-table__info aj-table--header row">
            <div class="aj-table__name col-md-6 col-sm-6"><?php echo sprintf(esc_html(__('Event Title','event-codes'))); ?></div>
            <div class="aj__address aj-table__address col-md-3 col-sm-3"><?php echo sprintf(esc_html(__('Location','event-codes'))); ?></div>
            <div class="aj-table__date col-md-3 col-sm-3"><?php echo sprintf(esc_html(__('Date','event-codes'))); ?></div>
        </div>
        <?php foreach($event_data->events as $event) : ?>
            <?php include(dirname( __FILE__ )  . '/tabular-view-item.php' ); ?>
        <?php endforeach; ?>
    </div>
    <div class="text-center aj-table__navi">
        <?php if($atts['show-load-more'] && $atts['count'] < $event_data->count) : ?>
            <a id="<?php echo $shortcode_id; ?>" href="" class="aj__link aj--loadmore"><?php echo sprintf(esc_html(__('Load More','event-codes'))); ?></a>
        <?php endif; ?>
        <?php if($atts['show-view-all']) : ?>
        <a href="<?php echo esc_url( tribe_get_events_link() ); ?>" class="aj__button aj--viewall btn btn-primary pull-right"><?php echo sprintf(esc_html(__('View All','event-codes'))); ?></a>
        <?php endif; ?>
    </div>
    <?php if($atts['show-load-more'] && $atts['count'] < $event_data->count) : ?>
    <script type="text/javascript">
        /* <![CDATA[ */
        var event_codes_sc_atts_<?php echo $shortcode_id; ?> = <?php print json_encode($atts); ?>;
        /* ]]> */
    </script>
    <?php endif; ?>
</div>
<!--
    / E N D
    T A B L E
-->
