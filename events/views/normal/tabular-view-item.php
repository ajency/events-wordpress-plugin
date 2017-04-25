<div class="aj-table__info">
    <div data-display="Event Title" class="aj-table__name">
						<span class="aj__price aj-table__price aj-list__price">
							<small class="aj__data-currency">&#8377;</small> <strong class="aj__data-price"><?php echo $event['price']; ?></strong>
						</span>
        <h4 class="aj-table__title aj__data-title"><a href="#"><?php echo $event['title']; ?></a></h4>
        <p class="aj-table__desc aj__data-desc"><?php echo $event['description']; ?></p>
    </div>
    <div data-display="Location" class="aj__address aj-table__address aj__data-address"><a href="#"><?php echo $event['address']; ?></a></div>
    <div data-display="Date" class="aj-table__date">
						<span class="aj-table__date-wrap">
							<strong>
                                <span class="aj__data-daystart"><?php echo $event['start_date_day']; ?></span> <span class="aj__data-daystart-month"><?php echo $event['start_date_mon']; ?></span>
                                -
                                <span class="aj__data-dayend"><?php echo $event['end_date_day']; ?></span> <span class="aj__data-dayend-month"><?php echo $event['end_date_mon']; ?></span>
                            </strong>
							           <span class="aj__data-time">
								<span class="aj__data-time">
									<span class="aj__data-timestart"><?php echo $event['start_time']; ?></span>
									<span class="aj__data-hyphen">-</span>
									<span class="aj__data-timeend"><?php echo $event['end_time']; ?></span>
								</span>
							</span>
						</span>
    </div>
</div>