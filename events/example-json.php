<?php
include 'class-event-codes-event.php';

$event = new Event_Codes_Event();
$event->setCatgory(['sdfsfdsf','sdfsdfsdf','sdfsdfsdf']);
$event->setDescription('Seamlessly actualize parallel technologies and multidisciplinary technologies...');
$event->setEndDate('15 Mar');
$event->setStartDate('23 Feb');
$event->setVenue('Kala Academy, Panjim, Goa');
$event->setTitle('sdfsdfsdfsdf sdfsdfsdfsfd');
$events = [];
$events[] = $event->getEvent();
$events[] = $event->getEvent();
$events[] = $event->getEvent();
$events[] = $event->getEvent();
header('Content-Type: application/json');
echo json_encode($events);