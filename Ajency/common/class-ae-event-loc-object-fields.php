<?php
class Ajency_Events_Location_Object_Fields
{
    const NAME = '_name';
    const STREET_NO = '_street_no';
    const ROUTE = '_route';
    const LOCALITY = '_locality';
    const ADMIN_AREA_1 = '_admin_1';
    const ADMIN_AREA_2 = '_admin_2';
    const SUB_LOCALITY_1 = '_subloc_1';
    const SUB_LOCALITY_2 = '_subloc_2';
    const POSTAL_CODE = '_postal_code';
    const COUNTRY = '_country';

    static function getConstants() {
        $oClass = new ReflectionClass(__CLASS__);
        return $oClass->getConstants();
    }
}