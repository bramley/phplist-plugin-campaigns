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
 */
class CampaignsPlugin_Model_Campaigns extends CommonPlugin_Model
{
    /*
     *    Inherited protected variables
     */
    protected $properties = array(
        'campaignID' => null,
        'type' => 'sent',
        'redirect' => null,
    );
    protected $persist = array(
        'type' => '',
    );

    public function __construct()
    {
        parent::__construct('CampaignsPlugin');
    }
}
