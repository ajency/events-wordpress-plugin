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
    <h3 class="aj__title">Upcoming Events</h3>
        <div class="aj-grid aj-grid--overlay aj--hastime aj--hasprice aj--hasdesc">
            <div class="aj-grid__single">
                <div class="aj-grid__inner">
                    <div class="aj-grid__top">
                        <a href="#" class="aj-grid__image" style="background-image: url(img/dummyimg.png);">
                            <img src="img/dummyimg.png" alt="">
                        </a>
                        <div class="aj__price aj-grid__price">
                            <small>&#8377;</small> <strong>35</strong>
                        </div>
                        <div class="aj-grid__date">
								<span class="aj-grid__datein">
									<span class="aj-grid__start">
										<span class="aj-grid__day">16</span>
										May
									</span>
									<span class="aj-grid__div">-</span>
									<span class="aj-grid__end">
										<span class="aj-grid__day">18</span>
										May
									</span>
								</span>
                            <span class="aj-grid__time">09:30AM - 02:30PM</span>
                        </div>
                    </div>
                    <div class="aj-grid__content">
                        <h4 class="aj-grid__title"><a href="#">Serendipity Art and Culture Festival</a></h4>
                        <div class="aj__address aj-grid__address">
                            <a href="#"><img src="img/marker.png" alt="">Kala Academy, Panjim, Goa</a>
                        </div>
                        <p class="aj-grid__desc">Seamlessly actualize parallel technologies and multidisciplinary technologies...</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center aj__navi">
            <a href="#" class="aj__link aj--loadmore">Load More</a>
            <a href="#" class="aj__button aj--viewall">View All</a>
        </div>
</div>
<!--
    / E N D
    G R I D
-->
