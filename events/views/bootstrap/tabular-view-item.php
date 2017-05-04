<div class="aj-table__info row">
    <div data-display="Event Title" class="aj-table__name col-md-6 col-sm-6">
        <?php if($event['price']) : ?>
            <span class="aj__price aj-table__price pull-right aj-list__price">
							<?php if(!$event['currency_position'] || $event['currency_position'] == 'prefix') : ?>
                                <small class="aj__data-currency"><?php echo $event['currency']; ?></small>
                            <?php endif; ?>
                <strong class="aj__data-price"><?php echo $event['price']; ?></strong>
                <?php if($event['currency_position'] == 'suffix') : ?>
                    <small class="aj__data-currency"><?php echo $event['currency']; ?></small>
                <?php endif; ?>
                        </span>
        <?php endif; ?>
        <h4 class="aj-table__title aj__data-title"><a href="<?php echo $event['title_link']; ?>"><?php echo $event['title']; ?></a></h4>
        <?php if($event['description']): ?>
            <p class="aj-table__desc aj__data-desc"><?php echo $event['description']; ?></p>
        <?php endif; ?>
    </div>
    <div data-display="Location" class="aj__address aj-table__address col-md-3 col-sm-3 aj__data-address">
        <?php if($event['address_link']): ?>
            <a target="_blank" href="<?php echo $event['address_link']; ?>">
                <?php echo $event['address']; ?>
            </a>
        <?php else: ?>
            <?php echo $event['address']; ?>
        <?php endif; ?>

    </div>
    <div data-display="Date" class="aj-table__date col-md-3 col-sm-3">
						<span class="aj-table__date-wrap ">
							<strong>
                                <span class="aj__data-daystart"><?php echo $event['start_date_day']; ?></span> <span class="aj__data-daystart-month"><?php echo $event['start_date_mon']; ?></span>
                                <?php if($event['end_date_day']) : ?>
                                    -
                                    <span class="aj__data-dayend"><?php echo $event['end_date_day']; ?></span> <span class="aj__data-dayend-month"><?php echo $event['end_date_mon']; ?></span>
                                <?php endif; ?>

                            </strong>

                            <span class="aj__data-time">
                                <?php if($event['start_time'] || $event['end_time']) : ?>
                                    <span class="aj__data-time">
                                    <?php if($event['start_time']) : ?>
                                        <span class="aj__data-timestart"><?php echo $event['start_time']; ?></span>
                                    <?php endif; ?>
                                        <?php if($event['end_time']) : ?>
                                            <span class="aj__data-hyphen">-</span>
                                            <span class="aj__data-timeend"><?php echo $event['end_time']; ?></span>
                                        <?php endif; ?>
                                </span>
                                <?php endif; ?>
							</span>
						</span>
    </div>
</div>