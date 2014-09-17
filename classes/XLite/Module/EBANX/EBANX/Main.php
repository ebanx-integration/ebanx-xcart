<?php
// vim: set ts=4 sw=4 sts=4 et:
namespace XLite\Module\EBANX\EBANX;
/**
* Module description
*
* @package XLite
*/
abstract class Main extends \XLite\Module\AModule
{
    /**
     * Author name
     *
     * @return string
     */
    public static function getAuthorName()
    {
        return 'Ebanx';
    }
 
    /**
     * Module name
     *
     * @return string
     */
    public static function getModuleName()
    {
        return 'Ebanx';
    }
 
    /**
     * Get module major version
     *
     * @return string
     */
    public static function getMajorVersion()
    {
        return '5.1';
    }
 
    /**
     * Module version
     *
     * @return string
     */
    public static function getMinorVersion()
    {
        return 1;
    }
 
    /**
     * Module description
     *
     * @return string
     */
    public static function getDescription()
    {
        return 'EBANX Checkout Integration';
    }
}