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
 * This is the controller class that implements the action() methods.
 */
class CampaignsPlugin_Controller_Resend
    extends CommonPlugin_Controller
{
    const PLUGIN = 'CampaignsPlugin';

    private $db;

    protected function actionResendFormSubmit()
    {
        $model = new CampaignsPlugin_Model_ResendForm($this->db);

        $this->normalise($_POST);
        $model->setProperties($_POST);
        $session = array();

        if ($model->emails) {
            $session['resendResults'] = $model->resend();

            if (count($session['resendResults']['deleted']) == 0) {
                $session['errorMessage'] = $this->i18n->get('campaign was not resent to any email addresses');
            }
        } else {
            $session['errorMessage'] = $this->i18n->get('email addresses must be entered');
        }
        $_SESSION[self::PLUGIN] = $session;
        header('Location: ' . new CommonPlugin_PageURL(null, array('action' => 'resendForm')));
        exit;
    }

    protected function actionResendForm()
    {
        $model = new CampaignsPlugin_Model_ResendForm($this->db);
        $model->setProperties($_GET);
        $count = $model->loadBouncedEmails();

        $toolbar = new CommonPlugin_Toolbar($this);
        $toolbar->addHelpButton('resend');

        $params = array(
            'model' => $model,
            'action' => new CommonPlugin_PageURL(null, array('action' => 'resendFormSubmit')),
        );

        if (isset($_SESSION[self::PLUGIN])) {
            $params += $_SESSION[self::PLUGIN];
            unset($_SESSION[self::PLUGIN]);
        }
        $panel = new UIPanel(
            $this->i18n->get('Resend campaign'),
            $this->render(__DIR__ . '/../view/resend_panel.tpl.php', $params)
        );
        echo $this->render(
            __DIR__ . '/../view/resend.tpl.php', array(
                'toolbar' => $toolbar->display(),
                'panel' => $panel->display(),
            )
        );
    }

    public function __construct()
    {
        parent::__construct();
        $this->db = new CommonPlugin_DB();
    }
}
