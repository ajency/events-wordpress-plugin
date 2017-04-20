<?php
include 'class-event-codes-event.php';

$event = new Event_Codes_Event();
$event->setArtWork();
$event->setCatgory(['sdfsfdsf','sdfsdfsdf','sdfsdfsdf']);
$event->setCity();
$event->setDescription();
$event->setEndDate();
$event->setImages();
$event->setOrganizer();
$event->setPrice();
$event->setStartDate();
$event->setTags();
$event->setVenue();
$event->setTitle();
print json_encode($event->getEvent());