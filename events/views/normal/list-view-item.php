<div class="aj-list__single">
    <div class="aj-list__inner">
        <div class="aj-list__top">
            <a href="#" class="aj-list__image aj__data-image" style="background-image: url(img/dummyimg.png);">
                <img src="img/dummyimg.png" alt="">
            </a>
        </div>
        <div class="aj-list__content">


            <?php if($event['price']) : ?>
                <div class="aj__price aj-list__price">
                    <?php if(!$event['currency_position'] || $event['currency_position'] == 'prefix') : ?>

                        <small class="aj__data-currency"><?php echo $event['currency']; ?></small>
                    <?php endif; ?>

                    <strong class="aj__data-price"><?php echo $event['price']; ?></strong>
                    <?php if($event['currency_position'] == 'suffix') : ?>
                        <small class="aj__data-currency"><?php echo $event['currency']; ?></small>
                    <?php endif; ?>


                </div>
            <?php endif; ?>
            <div class="aj-list__date">

								<span class="aj-list__datein">
									<span class="aj-list__start">
										<span class="aj-list__day aj__data-daystart"><?php echo $event['start_date_day']; ?></span>
										<span class="aj__data-daystart-month"><?php echo $event['start_date_mon']; ?></span>
									</span>
                                    <?php if($event['end_date_day']) : ?>
                                    <span class="aj-list__div">-</span>
									<span class="aj-list__end">
										<span class="aj-list__day aj__data-dayend"><?php echo $event['end_date_day']; ?></span>
										<span class="aj__data-dayend-month"><?php echo $event['end_date_mon']; ?></span>
									</span>
                                    <?php endif; ?>
								</span>
								<span class="aj-list__time aj__data-time">
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

            <h4 class="aj-list__title aj__data-title"><a href="<?php echo $event['title_link']; ?>"><?php echo $event['title']; ?></a></h4>
            <?php if($event['address_link']): ?>
                <div class="aj__address aj-list__address aj__data-address">
                    <a href="<?php echo $event['address_link']; ?>"><img src="img/marker.png" alt=""><?php echo $event['address']; ?></a>
                </div>
            <?php else: ?>
                <div class="aj__address aj-list__address aj__data-address">
                    <img src="img/marker.png" alt=""><?php echo $event['address']; ?>
                </div>
            <?php endif; ?>

            <p class="aj-list__desc aj__data-desc"><?php echo $event['description']; ?></p>
        </div>
    </div>
</div>