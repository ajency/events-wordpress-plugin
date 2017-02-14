<?php
class Ajency_Events_Custom_Fields
{
    const FEATURED = '_event_featured';

    const STARTDATE = '_event_startdate';
    const ENDDATE = '_event_enddate';

    const LOCATION = '_event_loc';
    const LAT = '_event_loc_lat';
    const LNG = '_event_loc_lng';

    const LOCATION_EDITED = '_event_loc_edited';
    const LAT_EDITED = '_event_loc_lat_edited';
    const LNG_EDITED = '_event_loc_lng_edited';

    const LOCATION_OBJECT = '_event_loc_obj';


    static function getConstants() {
        $oClass = new ReflectionClass(__CLASS__);
        return $oClass->getConstants();
    }

    static function getHiddenConstants() {
        return [
            self::LAT,
            self::LNG,
            self::LAT_EDITED,
            self::LNG_EDITED,
        ];
    }
}