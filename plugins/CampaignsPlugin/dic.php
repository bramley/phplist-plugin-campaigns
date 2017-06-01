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
 * @copyright 2014-2017 Duncan Cameron
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License, Version 3
 */

/*
 * This file creates a dependency injection container.
 */
use Mouf\Picotainer\Picotainer;
use Psr\Container\ContainerInterface;

return new Picotainer([
    'CampaignsPlugin_Controller_Campaigns' => function (ContainerInterface $container) {
        return new CampaignsPlugin_Controller_Campaigns(
            new CampaignsPlugin_Model_Campaigns(),
            $container->get('CampaignsPlugin_DAO_Campaign')
        );
    },
    'CampaignsPlugin_Controller_Resend' => function (ContainerInterface $container) {
        return new CampaignsPlugin_Controller_Resend(
            new CampaignsPlugin_Model_ResendForm(),
            $container->get('CampaignsPlugin_DAO_Resend'),
            $container->get('CommonPlugin_DAO_User')
        );
    },
    'CampaignsPlugin_DAO_Campaign' => function (ContainerInterface $container) {
        return new CampaignsPlugin_DAO_Campaign(new CommonPlugin_DB());
    },
    'CampaignsPlugin_DAO_Resend' => function (ContainerInterface $container) {
        return new CampaignsPlugin_DAO_Resend(new CommonPlugin_DB());
    },
    'CommonPlugin_DAO_User' => function (ContainerInterface $container) {
        return new CommonPlugin_DAO_User(new CommonPlugin_DB());
    },
]);
