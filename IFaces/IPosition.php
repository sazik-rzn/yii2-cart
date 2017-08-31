<?php

namespace sazik\cart\IFaces;

interface IPosition {

    /**
     * Find position model
     * @param integer $id ID of position model
     * @return IPosition 
     */
    public static function findByID($id);

    /**
     * Move position
     * @param integer $id ID of position model
     * @param integer $count count
     * @return boolean 
     */
    public static function moveByID($id, $count);

    /**
     * Unmove position
     * @param integer $id ID of position model
     * @param integer $count count
     * @return boolean 
     */
    public static function unmoveByID($id, $count);

    /**
     * Can move position?
     * @param integer $id ID of position model
     * @param integer $count count
     * @return boolean 
     */
    public static function CanMove($id, $count);
}
