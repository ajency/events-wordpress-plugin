<div class="aj-list__single">
    <div class="aj-list__inner">
        <div class="aj-list__top">
            <a href="#" class="aj-list__image aj__data-image" style="background-image: url(img/dummyimg.png);">
                <img src="img/dummyimg.png" alt="">
            </a>
        </div>
        <div class="aj-list__content">
            <div class="aj__price aj-list__price">
                <small class="aj__data-currency">&#8377;</small> <strong class="aj__data-price">35</strong>
            </div>
            <div class="aj-list__date">
								<span class="aj-list__datein">
									<span class="aj-list__start">
										<span class="aj-list__day aj__data-daystart">16</span>
										<span class="aj__data-daystart-month">May</span>
									</span>
									<span class="aj-list__div">-</span>
									<span class="aj-list__end">
										<span class="aj-list__day aj__data-dayend">18</span>
										<span class="aj__data-dayend-month">May</span>
									</span>
								</span>
								<span class="aj-list__time aj__data-time">
									<span class="aj__data-time">
										<span class="aj__data-timestart">09:30AM</span>
										<span class="aj__data-hyphen">-</span>
										<span class="aj__data-timeend">02:30PM</span>
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