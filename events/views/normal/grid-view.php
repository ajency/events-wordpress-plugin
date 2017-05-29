<!--
			G R I D
			styles: basic / big-date / overlay
			===================================
			Add/replace the beolow classes to the div with class "aj-grid"
			===================================
			class for layout: aj-grid--basic / aj-grid--bigdate / aj-grid--overlay
			class for price: aj--hasprice
			class for time: aj--hastime
			class for desc: aj--hasdesc
		-->
<div class="aj">
    <h3 class="aj__title"><?php echo $event_data->event_range_lbl; ?> Events</h3>
    <div id="data-<?php echo $shortcode_id; ?>" class="aj-grid aj-grid--<?php echo $atts['style']; ?> <?php echo $atts['description'] ? 'aj--hasdesc':'' ?> <?php echo $atts['showtime'] ? 'aj--hastime':'' ?> aj--hasprice">

        <?php foreach($event_data->events as $event) : ?>
            <?php include(dirname( __FILE__ )  . '/grid-view-item.php' ); ?>
        <?php endforeach; ?>

    </div>
    <div class="text-center aj__navi">
        <?php if($atts['show-load-more'] && $atts['count'] < $event_data->count) : ?>
            <a id="<?php echo $shortcode_id; ?>" href="" class="aj__link aj--loadmore"><?php echo sprintf(esc_html(__('Load More','event-codes'))); ?></a>
        <?php endif; ?>
        <?php if($atts['show-view-all']) : ?>
            <a href="<?php echo esc_url( tribe_get_events_link() ); ?>" class="aj__button aj--viewall"><?php echo sprintf(esc_html(__('View All','event-codes'))); ?></a>
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
    G R I D
-->