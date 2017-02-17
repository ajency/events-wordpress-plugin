<?php
class Ajency_Events_Constants
{

    const FIELD_FEATURED = '_event_featured';

    const FIELD_STARTDATE = '_event_startdate';
    const FIELD_ENDDATE = '_event_enddate';

    const FIELD_LOCATION = '_event_loc';
    const FIELD_LAT = '_event_loc_lat';
    const FIELD_LNG = '_event_loc_lng';

    const FIELD_LOCATION_EDITED = '_event_loc_edited';
    const FIELD_LAT_EDITED = '_event_loc_lat_edited';
    const FIELD_LNG_EDITED = '_event_loc_lng_edited';

    const FIELD_LOCATION_OBJECT = '_event_loc_obj';

    const DATE_SAVE_FORMAT = 'Y-m-d H:i:s';
    const DATE_DISPLAY_FORMAT = 'd-M-Y H:i';

    const META_BOX_LABEL_EVENT_DURATION = 'When?';
    const META_BOX_LABEL_EVENT_LOCATION = 'Where?';
    const META_BOX_LABEL_EVENT_DISPLAY_ADDRESS = 'Where?';
    const META_BOX_LABEL_EVENT_TAGS = 'Event Type';
    const META_BOX_LABEL_EVENT_FEATURED = 'Event Type';

    static function getConstants() {
        $oClass = new ReflectionClass(__CLASS__);
        return $oClass->getConstants();
    }

    static function getHiddenConstants() {
        return [
            self::FIELD_LAT,
            self::FIELD_LNG,
            self::FIELD_LAT_EDITED,
            self::FIELD_LNG_EDITED,
        ];
    }
}