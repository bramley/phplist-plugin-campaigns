<?php
/**
 * CampaignsPlugin for phplist.
 *
 * This file is a part of CampaignsPlugin.
 *
 * This plugin is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This plugin is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * @category  phplist
 *
 * @author    Duncan Cameron
 * @copyright 2014-2016 Duncan Cameron
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License, Version 3
 *
 * @link      http://forums.phplist.com/
 */

/**
 * This class holds the properties entered in the form.
 *
 * @category  phplist
 */
class CampaignsPlugin_Model_ResendForm extends CommonPlugin_Model
{
    /*
     *    Private variables
     */
    private $defaults = array(
        'campaignID' => null,
        'emails' => null,
        'bounce' => 1,
        'totals' => 0,
        'requeue' => 1,
    );

    /*
     *    Inherited protected variables
     */
    protected $properties;
    protected $persist = array(
        'campaignID' => '',
        'emails' => '',
        'bounce' => '',
        'totals' => '',
        'requeue' => '',
    );

    /*
     *    Public methods
     */
    public function __construct()
    {
        $this->properties = $this->defaults;
        parent::__construct('CampaignsPlugin');
    }

    public function reset()
    {
        parent::setProperties($this->defaults);
    }
}
