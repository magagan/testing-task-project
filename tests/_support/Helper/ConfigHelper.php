<?php
/**
 * Created by PhpStorm.
 * User: mcgagan
 * Date: 6/2/20
 * Time: 11:58 PM
 */

namespace Helper;

class ConfigHelper extends \Codeception\Module
{
    public function getConfig($key)
    {
        if (isset($this->config[$key])) {
            return $this->config[$key];
        } else {
            return null;
        }
    }
}