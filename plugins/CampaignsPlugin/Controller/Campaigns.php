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
class CampaignsPlugin_Controller_Campaigns extends CommonPlugin_Controller
{
    const PLUGIN = 'CampaignsPlugin';
    const FORMNAME = 'MessagesForm';
    const CHECKBOXNAME = 'campaignID';

    private $model;
    private $dao;

    private function tabs($type)
    {
        $captions = array(
            'sent' => $this->i18n->get('tab_sent'),
            'active' => $this->i18n->get('tab_active'),
            'draft' => $this->i18n->get('tab_draft'),
        );
        $tabs = new CommonPlugin_Tabs();

        foreach ($captions as $key => $value) {
            $tabs->addTab($value, new CommonPlugin_PageURL(null, array('type' => $key)));
        }
        $tabs->setCurrent($captions[$type]);

        return $tabs;
    }

    protected function actionRequeue()
    {
        $r = $this->dao->requeueMessage($this->model->{self::CHECKBOXNAME});
        $_SESSION[self::PLUGIN]['actionResult'] = $r
            ? $this->i18n->get('Campaign %d requeued', $this->model->{self::CHECKBOXNAME})
            : $this->i18n->get('Unable to requeue campaign %d', $this->model->{self::CHECKBOXNAME});
        header('Location: ' . new CommonPlugin_PageURL(null, array('type' => 'active')));
        exit;
    }

    protected function actionCopy()
    {
        $id = $this->dao->copyMessage($this->model->{self::CHECKBOXNAME});
        $_SESSION[self::PLUGIN]['actionResult'] = $id
            ? $this->i18n->get('Campaign %d copied to %d', $this->model->{self::CHECKBOXNAME}, $id)
            : $this->i18n->get('Unable to copy campaign %d', $this->model->{self::CHECKBOXNAME});
        header('Location: ' . new CommonPlugin_PageURL(null, array('type' => 'draft')));
        exit;
    }

    protected function actionDelete()
    {
        $deleted = array();
        $failed = array();
        $messageIds = $this->model->{self::CHECKBOXNAME};
        sort($messageIds, SORT_NUMERIC);

        foreach ($messageIds as $id) {
            if ($this->dao->deleteMessage($id)) {
                $this->logEvent($this->i18n->get('Campaign %d deleted by %s', $id, $_SESSION['logindetails']['adminname']));
                $deleted[] = $id;
            } else {
                $failed[] = $id;
            }
        }
        $_SESSION[self::PLUGIN]['actionResult'] = '';

        if ($deleted) {
            $_SESSION[self::PLUGIN]['actionResult'] .= $this->i18n->get('Campaigns %s deleted', implode(', ', $deleted));
        }

        if ($failed) {
            $_SESSION[self::PLUGIN]['actionResult'] .= $this->i18n->get('Unable to delete %s ', implode(', ', $failed));
        }
        header('Location: ' . $this->model->redirect);
        exit;
    }

    protected function actionDeleteOne()
    {
        $campaignId = $this->model->{self::CHECKBOXNAME};
        $r = $this->dao->deleteMessage($campaignId);

        if ($r) {
            $_SESSION[self::PLUGIN]['actionResult'] = $this->i18n->get('Campaign %s deleted', $campaignId);
            $this->logEvent($this->i18n->get('Campaign %d deleted by %s', $campaignId, $_SESSION['logindetails']['adminname']));
        } else {
            $_SESSION[self::PLUGIN]['actionResult'] = $this->i18n->get('Unable to delete %s ', $campaignId);
        }
        header('Location: ' . $this->model->redirect);
        exit;
    }

    protected function actionDeleteDrafts()
    {
        $r = $this->dao->deleteDraftMessages();
        $_SESSION[self::PLUGIN]['actionResult'] = $this->i18n->get('%d draft campaigns deleted', $r);
        header('Location: ' . new CommonPlugin_PageURL(null, array('type' => 'draft')));
        exit;
    }

    protected function actionDefault()
    {
        $toolbar = new CommonPlugin_Toolbar($this);
        $toolbar->addHelpButton('campaigns');
        $access = accessLevel('messages');
        $owner = ($access == 'owner') ? $_SESSION['logindetails']['id'] : null;
        $listing = new CommonPlugin_Listing(
            $this,
            new CampaignsPlugin_CampaignsPopulator($owner, $this->model->type, $this->dao, $this->i18n)
        );
        $listing->pager->setItemsPerPage(array(5, 25), 5);
        $params = array(
            'toolbar' => $toolbar->display(),
            'tabs' => $this->tabs($this->model->type)->display(),
            'formName' => self::FORMNAME,
            'listing' => $listing->display(),
        );

        if (isset($_SESSION[self::PLUGIN])) {
            $params += $_SESSION[self::PLUGIN];
            unset($_SESSION[self::PLUGIN]);
        }
        echo $this->render(dirname(__FILE__) . '/../view/campaigns.tpl.php', $params);
    }

    public function __construct(CampaignsPlugin_Model_Campaigns $model, CampaignsPlugin_DAO_Campaign $dao)
    {
        parent::__construct();
        $this->model = $model;
        $this->model->setProperties($_REQUEST);
        $this->dao = $dao;
    }
}
