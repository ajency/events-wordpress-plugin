<div class="aj-grid__single">
    <div class="aj-grid__inner">
        <div class="aj-grid__top">

            <?php
            if(!$event['art_work']){
                $event['art_work'] =  plugins_url( '/public/img/dummyimg.png', EVENT_CODES_FILE );
            }
            ?>

            <a href="#" class="aj-grid__image aj__data-image" style="background-image: url(<?php echo $event['art_work']; ?>);">
                <img src="<?php echo $event['art_work']; ?>" alt="">
            </a>


            <?php if($event['price']) : ?>
                <div class="aj__price aj-grid__price aj-list__price">
                    <?php if(!$event['currency_position'] || $event['currency_position'] == 'prefix') : ?>

                        <small class="aj__data-currency"><?php echo $event['currency']; ?></small>
                    <?php endif; ?>

                    <strong class="aj__data-price"><?php echo $event['price']; ?></strong>
                    <?php if($event['currency_position'] == 'suffix') : ?>
                        <small class="aj__data-currency"><?php echo $event['currency']; ?></small>
                    <?php endif; ?>


                </div>
            <?php endif; ?>


            <div class="aj-grid__date">

								<span class="aj-grid__datein">
									<span class="aj-grid__start">
										<span class="aj-grid__day aj__data-daystart"><?php echo $event['start_date_day']; ?></span>
										<span class="aj__data-daystart-month"><?php echo $event['start_date_mon']; ?></span>
									</span>
                                    <?php if($event['end_date_day']) : ?>
									<span class="aj-grid__div">-</span>
									<span class="aj-grid__end">
										<span class="aj-grid__day aj__data-dayend"><?php echo $event['end_date_day']; ?></span>
										<span class="aj__data-dayend-month"><?php echo $event['end_date_mon']; ?></span>
									</span>
                                    <?php endif; ?>
								</span>
								<span class="aj-grid__time aj__data-time">
									<span class="aj__data-time">
                                        <?php if($event['start_time']) : ?>
										<span class="aj__data-timestart"><?php echo $event['start_time']; ?></span>
                                        <?php endif; ?>
                                        <?php if($event['end_time']) : ?>
										<span class="aj__data-hyphen">-</span>
										<span class="aj__data-timeend"><?php echo $event['end_time']; ?></span>
                                        <?php endif; ?>
									</span>
								</span>
            </div>
        </div>
        <div class="aj-grid__content">
            <h4 class="aj-grid__title aj__data-title"><a href="<?php echo $event['title_link']; ?>"><?php echo $event['title']; ?></a></h4>

            <?php if($event['address_link']): ?>
                <div target="_blank" class="aj__address aj-grid__address aj__data-address">
                    <a href="<?php echo $event['address_link']; ?>"><img src="<?php echo plugins_url( '/public/img/marker.png', EVENT_CODES_FILE ); ?>" alt=""><?php echo $event['address']; ?></a>
                </div>
            <?php else: ?>
                <div class="aj__address aj-grid__address aj__data-address">
                    <img src="<?php echo plugins_url( '/public/img/marker.png', EVENT_CODES_FILE ); ?>" alt=""><?php echo $event['address']; ?>
                </div>
            <?php endif; ?>


            <p class="aj-grid__desc aj__data-desc"><?php echo $event['description']; ?></p>
        </div>
    </div>
</div>