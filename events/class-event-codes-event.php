<?php

class Event_Codes_Event {

	private $title;
	private $start_date;
	private $end_date;
	private $city;
	private $venue;
	private $price;
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
	public function setDescription($description)
	{
		$this->description = $description;
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
