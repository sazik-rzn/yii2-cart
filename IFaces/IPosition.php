<?php

namespace sazik\cart\IFaces;

interface IPosition {

    public static function findByID($id);

    public static function moveByID($id, $count);
    
    public static function unmoveByID($id, $count);
    
    public static function CanMove($id, $count);
}
