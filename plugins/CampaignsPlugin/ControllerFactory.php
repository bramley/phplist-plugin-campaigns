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
 * @author    Duncan Cameron
 * @copyright 2014-2016 Duncan Cameron
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License, Version 3
 *
 * @link      https://discuss.phplist.org/
 */

/**
 * This class is a concrete implementation of CommonPlugin_ControllerFactoryBase.
 */
class CampaignsPlugin_ControllerFactory extends CommonPlugin_ControllerFactoryBase
{
    /**
     * Custom implementation to create a controller using plugin and page.
     *
     * @param string $pi     the plugin
     * @param array  $params further parameters from the URL
     *
     * @return CommonPlugin_Controller
     */
    public function createController($pi, array $params)
    {
        $container = include __DIR__ . '/dic.php';

        $class = $pi . '_Controller_' . ucfirst($params['page']);

        return $container->get($class);
    }
}
