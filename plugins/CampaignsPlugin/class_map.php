<?php

$pluginsDir = dirname(__DIR__);

return [
    'CampaignsPlugin_CampaignsPopulator' => $pluginsDir . '/CampaignsPlugin/CampaignsPopulator.php',
    'CampaignsPlugin_ControllerFactory' => $pluginsDir . '/CampaignsPlugin/ControllerFactory.php',
    'CampaignsPlugin_Controller_Campaigns' => $pluginsDir . '/CampaignsPlugin/Controller/Campaigns.php',
    'CampaignsPlugin_Controller_Resend' => $pluginsDir . '/CampaignsPlugin/Controller/Resend.php',
    'CampaignsPlugin_DAO_Campaign' => $pluginsDir . '/CampaignsPlugin/DAO/Campaign.php',
    'CampaignsPlugin_DAO_Resend' => $pluginsDir . '/CampaignsPlugin/DAO/Resend.php',
    'CampaignsPlugin_Model_Campaigns' => $pluginsDir . '/CampaignsPlugin/Model/Campaigns.php',
    'CampaignsPlugin_Model_ResendForm' => $pluginsDir . '/CampaignsPlugin/Model/ResendForm.php',
    'CampaignsPlugin_PageactionController' => $pluginsDir . '/CampaignsPlugin/pageaction.php',
];
