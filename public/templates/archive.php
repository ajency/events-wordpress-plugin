<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

    <div class="wrap">

<?php if ( have_posts() ) : ?>
    <div class=""aj-head text-center">
    <?php the_archive_title( '<h3 class="aj-head text-center">', '</h3>' ); ?>
<!--                                    <h3 class="aj-head text-center">Events</h3>-->
    </div><!-- .page-header -->
<?php endif; ?>


    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
    <div class="aj-grid">
<!--        <fieldset class="aj-grid__title">
            <legend class="text-center"><?php /*the_archive_title( '<h3 class="aj-head text-center">', '</h3>' ); */?></legend>
        </fieldset>-->
        <div class="aj-grid__row aj-event">


            <?php
            if ( have_posts() ) : ?>
                <?php
                /* Start the Loop */
                while ( have_posts() ) : the_post(); ?>

                    <?php
                    $field_startdate = get_post_meta( get_the_ID(), Ajency_Events_Constants::FIELD_STARTDATE , true);
                    $field_enddate = get_post_meta( get_the_ID(), Ajency_Events_Constants::FIELD_ENDDATE , true);
                    $field_loc = get_post_meta( get_the_ID(), Ajency_Events_Constants::FIELD_LOCATION_EDITED , true);
                    $field_lat = get_post_meta( get_the_ID(), Ajency_Events_Constants::FIELD_LAT_EDITED , true);
                    $field_lng = get_post_meta( get_the_ID(), Ajency_Events_Constants::FIELD_LNG_EDITED , true);

                    if($field_startdate) {
                        if(date('Y-m-d',strtotime($field_startdate)) == date('Y-m-d',strtotime($field_enddate))){

                            $time = date('M d',strtotime($field_startdate)).' @ '.date('h:i A',strtotime($field_startdate)).' - '.date('h:i A',strtotime($field_enddate));

                        } else {

                            $time = date('M d',strtotime($field_startdate)).' @ '.date('h:i A',strtotime($field_startdate)).' - '.date('M d',strtotime($field_enddate)).' @ '.date('h:i A',strtotime($field_enddate));
                        }
                    }
                    ?>

                    <div class="col">
                        <h3 class="aj-event__heading m-t-0 m-b-0">
                            <a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
                        </h3>

                        <?php if($field_loc && $time) : ?>
                            <div class="aj-event__address">
                                <?php echo $time . ' | ' .$field_loc; ?>
                                <!--                    January 25 @ 7.00 am - 2.00 pm | ventura country fairgrounds, 10 w. harbor blvd. ventura, CA 93001 United states-->
                            </div>
                        <?php elseif ($field_loc): ?>
                            <div class="aj-event__address">
                                <?php echo $field_loc; ?>
                                <!--                    January 25 @ 7.00 am - 2.00 pm | ventura country fairgrounds, 10 w. harbor blvd. ventura, CA 93001 United states-->
                            </div>
                        <?php elseif ($time): ?>
                            <div class="aj-event__address">
                                <?php echo $time; ?>
                                <!--                    January 25 @ 7.00 am - 2.00 pm | ventura country fairgrounds, 10 w. harbor blvd. ventura, CA 93001 United states-->
                            </div>

                        <?php endif; ?>

                        <?php if($field_loc && $field_lat && $field_lng): ?>

                            <div class="aj-event__link">
                                <a target="_blank" href="http://maps.google.com/?q=<?php echo $field_lat.','.$field_lng; ?>">Click here to view Google Map</a>
                            </div>

                        <?php endif; ?>

                        <div class="aj-event__card">
                            <?php if ( has_post_thumbnail() ) { ?>
                                <div class="cover">
                                    <img src="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>" alt="" class="img-responsive">
                                </div>
                            <?php } else { ?>
                        <div class="cover">
                            <img src="http://placehold.it/300x200" alt="" class="img-responsive">
                        </div>
                        <?php } ?>
                            <div class="info">
                                <p class="info__title m-t-0"><?php echo get_the_excerpt(); ?></p>
<!--                                <a href="">Click here to read more</a>-->
                            </div>
                        </div>
                    </div>

                    <?php
                    /*        get_template_part( 'template-parts/post/content', get_post_format() );*/

                endwhile;

                the_posts_pagination( array(
                    'prev_text' => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
                    'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
                    'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
                ) );

            endif; ?>

        </div>
    </div>
        </main>
            </div>
        <?php get_sidebar(); ?>
    </div><!-- .wrap -->

<?php get_footer();
