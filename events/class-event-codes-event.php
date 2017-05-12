<?php

/*
 * Event_Codes_Event
 * Event instances for Event Codes that are passed to the view are created using this class
 * Views can accept only objects of these classes, cannot enforce this at a parameter level
 * This is a generated class hence camelCase
 */
class Event_Codes_Event {

	private $title;
	private $title_link;
	private $start_date;
	private $end_date;
	private $start_time;
	private $end_time;
	private $start_date_day;
	private $start_date_mon;
	private $start_date_year;
	private $start_date_hour;
	private $start_date_min;
	private $end_date_day;
	private $end_date_mon;
	private $end_date_year;
	private $end_date_hour;
	private $end_date_min;
	private $city;
	private $address;
	private $address_link;
	private $venue;
	private $price;
	private $currency;
	private $currency_position;
	private $description;
	private $organizer;
	private $tags;
	private $catgory;
	private $art_work;
	private $images;

	public function getEvent() {
		$event = get_object_vars($this);
		foreach($event as $key => $field){
			$event[$key] = $this->{$key};
		}
		return $event;
	}

	public function __get($name){

		if (ObjectHelper::existsMethod($this,$name)){
			return $this->$name();
		}

		return null;
	}

	public function __set($name, $value){

		if (ObjectHelper::existsMethod($this,$name))
			$this->$name($value);
	}

	/**
	 * @return mixed
	 */
	public function getTitleLink()
	{
		return $this->title_link;
	}

	/**
	 * @param mixed $title_link
	 */
	public function setTitleLink($title_link)
	{
		$this->title_link = $title_link;
	}



	public function setDates($event_start_date,$event_end_date,$all_day = false, $showtime = true){
		$startDateDay = date('d',$event_start_date);
		$startDateMon = date('M',$event_start_date);
		$endDateDay = date('d',$event_end_date);
		$endDateMon = date('M',$event_end_date);
		$startTime = $showtime == true ? date('h:i A',$event_start_date) : false;
		$endTime = $showtime == true ? date('h:i A',$event_end_date) : false;

		//If its an all day event show only the day
		if ($all_day) {

			$startTime = false;
			$endTime = false;
		}

		//If start date and end date is the same
		if(strtotime(date('d-M-Y',$event_start_date)) == strtotime(date('d-M-Y',$event_end_date))) {
			$endDateDay = false;
			$endDateMon = false;

		}

		$this->setStartDateDay($startDateDay);
		$this->setStartDateMon($startDateMon);
		$this->setEndDateDay($endDateDay);
		$this->setEndDateMon($endDateMon);
		$this->setStartTime($startTime);
		$this->setEndTime($endTime);
	}

	/**
	 * @return mixed
	 */
	public function getCurrency()
	{
		return $this->currency;
	}

	/**
	 * @param mixed $currency
	 */
	public function setCurrency($currency)
	{
		$this->currency = $currency;
	}

	/**
	 * @return mixed
	 */
	public function getCurrencyPosition()
	{
		return $this->currency_position;
	}

	/**
	 * @param mixed $currency_position
	 */
	public function setCurrencyPosition($currency_position)
	{
		$this->currency_position = $currency_position;
	}




	/**
	 * @return mixed
	 */
	public function getAddressLink()
	{
		return $this->address_link;
	}

	/**
	 * @param mixed $address_link
	 */
	public function setAddressLink($show_link = true)
	{
		if($show_link && $this->address)
		{
			//TODO - unhardcode this
			$this->address_link = 'http://maps.google.com/?q='.$this->address;
		} else  {
			$this->address_link = false;
		}
	}



	/**
	 * @return mixed
	 */
	public function getStartTime()
	{
		return $this->start_time;
	}

	/**
	 * @param mixed $start_time
	 */
	public function setStartTime($start_time)
	{
		$this->start_time = $start_time;
	}

	/**
	 * @return mixed
	 */
	public function getEndTime()
	{
		return $this->end_time;
	}

	/**
	 * @param mixed $end_time
	 */
	public function setEndTime($end_time)
	{
		$this->end_time = $end_time;
	}

	/**
	 * @return mixed
	 */
	public function getStartDateDay()
	{
		return $this->start_date_day;
	}

	/**
	 * @param mixed $start_date_day
	 */
	public function setStartDateDay($start_date_day)
	{
		$this->start_date_day = $start_date_day;
	}

	/**
	 * @return mixed
	 */
	public function getStartDateMon()
	{
		return $this->start_date_mon;
	}

	/**
	 * @param mixed $start_date_mon
	 */
	public function setStartDateMon($start_date_mon)
	{
		$this->start_date_mon = $start_date_mon;
	}

	/**
	 * @return mixed
	 */
	public function getStartDateYear()
	{
		return $this->start_date_year;
	}

	/**
	 * @param mixed $start_date_year
	 */
	public function setStartDateYear($start_date_year)
	{
		$this->start_date_year = $start_date_year;
	}

	/**
	 * @return mixed
	 */
	public function getStartDateHour()
	{
		return $this->start_date_hour;
	}

	/**
	 * @param mixed $start_date_hour
	 */
	public function setStartDateHour($start_date_hour)
	{
		$this->start_date_hour = $start_date_hour;
	}

	/**
	 * @return mixed
	 */
	public function getStartDateMin()
	{
		return $this->start_date_min;
	}

	/**
	 * @param mixed $start_date_min
	 */
	public function setStartDateMin($start_date_min)
	{
		$this->start_date_min = $start_date_min;
	}

	/**
	 * @return mixed
	 */
	public function getEndDateDay()
	{
		return $this->end_date_day;
	}

	/**
	 * @param mixed $end_date_day
	 */
	public function setEndDateDay($end_date_day)
	{
		$this->end_date_day = $end_date_day;
	}

	/**
	 * @return mixed
	 */
	public function getEndDateMon()
	{
		return $this->end_date_mon;
	}

	/**
	 * @param mixed $end_date_mon
	 */
	public function setEndDateMon($end_date_mon)
	{
		$this->end_date_mon = $end_date_mon;
	}

	/**
	 * @return mixed
	 */
	public function getEndDateYear()
	{
		return $this->end_date_year;
	}

	/**
	 * @param mixed $end_date_year
	 */
	public function setEndDateYear($end_date_year)
	{
		$this->end_date_year = $end_date_year;
	}

	/**
	 * @return mixed
	 */
	public function getEndDateHour()
	{
		return $this->end_date_hour;
	}

	/**
	 * @param mixed $end_date_hour
	 */
	public function setEndDateHour($end_date_hour)
	{
		$this->end_date_hour = $end_date_hour;
	}

	/**
	 * @return mixed
	 */
	public function getEndDateMin()
	{
		return $this->end_date_min;
	}

	/**
	 * @param mixed $end_date_min
	 */
	public function setEndDateMin($end_date_min)
	{
		$this->end_date_min = $end_date_min;
	}

	/**
	 * @return mixed
	 */
	public function getAddress()
	{
		return $this->address;
	}

	/**
	 * @param mixed $address
	 */
	public function setAddress($address)
	{
		if(!array_filter($address))
		{
			$this->address = false;
		} else {
			if(is_array($address)) {
				$this->address = implode(', ',$address);
			} else {
				$this->address = $address;
			}
		}
	}


	/**
	 * @param mixed $address
	 */
	public function setNoAddressLabel()
	{
		if(!$this->address)
		{
			$this->address = "Not Provided";
		}
	}

	/**
	 * @return mixed
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param mixed $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * @return mixed
	 */
	public function getStartDate()
	{
		return $this->start_date;
	}

	/**
	 * @param mixed $start_date
	 */
	public function setStartDate($start_date)
	{
		$this->start_date = $start_date;
	}

	/**
	 * @return mixed
	 */
	public function getEndDate()
	{
		return $this->end_date;
	}

	/**
	 * @param mixed $end_date
	 */
	public function setEndDate($end_date)
	{
		$this->end_date = $end_date;
	}

	/**
	 * @return mixed
	 */
	public function getCity()
	{
		return $this->city;
	}

	/**
	 * @param mixed $city
	 */
	public function setCity($city)
	{
		$this->city = $city;
	}

	/**
	 * @return mixed
	 */
	public function getVenue()
	{
		return $this->venue;
	}

	/**
	 * @param mixed $venue
	 */
	public function setVenue($venue)
	{
		$this->venue = $venue;
	}

	/**
	 * @return mixed
	 */
	public function getPrice()
	{
		return $this->price;
	}

	/**
	 * @param mixed $price
	 */
	public function setPrice($price)
	{
		$this->price = $price;
	}

	/**
	 * @return mixed
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param mixed $description
	 */
	public function setDescription($description,$set_description = true,$length = 100)
	{
		if($set_description) {
			$excerpt = preg_replace( " (\[.*?\])", '', $description );
			$excerpt = strip_tags( strip_shortcodes($excerpt) );
			$excerpt = trim( preg_replace( '/\s+/', ' ', $excerpt ) );
			if ( strlen( $excerpt ) > $length ) {
				$excerpt = substr( $excerpt, 0, $length );
				$excerpt .= '...';
			}
			$this->description = $excerpt;
		} else {
			$this->description = false;
		}
	}

	/**
	 * @return mixed
	 */
	public function getOrganizer()
	{
		return $this->organizer;
	}

	/**
	 * @param mixed $organizer
	 */
	public function setOrganizer($organizer)
	{
		$this->organizer = $organizer;
	}

	/**
	 * @return mixed
	 */
	public function getTags()
	{
		return $this->tags;
	}

	/**
	 * @param mixed $tags
	 */
	public function setTags($tags)
	{
		$this->tags = $tags;
	}

	/**
	 * @return mixed
	 */
	public function getCatgory()
	{
		return $this->catgory;
	}

	/**
	 * @param mixed $catgory
	 */
	public function setCatgory($catgory)
	{
		$this->catgory = $catgory;
	}

	/**
	 * @return mixed
	 */
	public function getArtWork()
	{
		return $this->art_work;
	}

	/**
	 * @param mixed $art_work
	 */
	public function setArtWork($art_work)
	{
		$this->art_work = $art_work;
	}

	/**
	 * @return mixed
	 */
	public function getImages()
	{
		return $this->images;
	}

	/**
	 * @param mixed $images
	 */
	public function setImages($images)
	{
		$this->images = $images;
	}


}
