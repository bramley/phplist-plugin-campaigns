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
class CampaignsPlugin_Controller_Resend extends CommonPlugin_Controller
{
    const PLUGIN = 'CampaignsPlugin';

    private $dao;
    private $model;
    private $userDao;

    private function resend()
    {
        $campaignID = $this->model->campaignID;
        $notsent = array();
        $deleted = array();
        $bounced = array();
        $ignored = array();
        $invalid = array();
        $requeued = false;

        $emails = preg_split('/\s+/', $this->model->emails, null, PREG_SPLIT_NO_EMPTY);

        foreach ($emails as $email) {
            if (!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
                $invalid[] = $email;
                continue;
            }

            if (!($row = $this->userDao->userByEmail($email))) {
                $ignored[] = $email;
                continue;
            }
            $userID = $row['id'];
            $count = $this->dao->deleteSent($campaignID, $userID);

            if ($count > 0) {
                $deleted[] = $email;

                if ($this->model->bounce) {
                    if ($this->dao->deleteBounces($campaignID, $userID) > 0) {
                        $bounced[] = $email;
                    }
                }

                if ($this->model->totals) {
                    $this->dao->adjustTotals($campaignID);
                }
            } else {
                $notsent[] = $email;
            }
        }

        if ($this->model->requeue && count($deleted) > 0) {
            $this->dao->requeueMessage($campaignID);
            $requeued = true;
        }

        return array(
                'campaignID' => $campaignID,
                'deleted' => $deleted,
                'bounced' => $bounced,
                'ignored' => $ignored,
                'notsent' => $notsent,
                'requeued' => $requeued,
                'invalid' => $invalid,
        );
    }

    protected function actionResendFormSubmit()
    {
        $this->normalise($_POST);
        $this->model->setProperties($_POST);
        $session = array();

        if ($this->model->emails) {
            $session['resendResults'] = $this->resend();

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
        $this->model->setProperties($_GET);
        $toolbar = new CommonPlugin_Toolbar($this);
        $toolbar->addHelpButton('resend');

        if ($this->model->campaignID) {
            $row = $this->dao->messageById($this->model->campaignID);
            $subject = $row['subject'];
        } else {
            $subject = '';
        }
        $params = array(
            'model' => $this->model,
            'subject' => $subject,
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

    public function __construct(
        CampaignsPlugin_Model_ResendForm $model,
        CampaignsPlugin_DAO_Resend $dao,
        CommonPlugin_DAO_User $userDao
    ) {
        parent::__construct();
        $this->model = $model;
        $this->dao = $dao;
        $this->userDao = $userDao;
    }
}
