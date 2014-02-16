<?php
/**
 * CampaignsPlugin for phplist
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
 * @package   CampaignsPlugin
 * @author    Duncan Cameron
 * @copyright 2014 Duncan Cameron
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License, Version 3
 * @link      http://forums.phplist.com/
 */

/**
 * This is the controller class that implements the action() methods
 */
class CampaignsPlugin_Controller
    extends CommonPlugin_Controller
    implements CommonPlugin_IPopulator
{
    const PLUGIN = 'CampaignsPlugin';
    const FORMNAME = 'MessagesForm';
    const RADIONAME = 'campaignID';

    private function tabs($type)
    {
        $captions = array(
            'sent' => $this->i18n->get('tab_sent'),
            'draft' => $this->i18n->get('tab_draft'),
            'active' => $this->i18n->get('tab_active'),
        );

        $tabs = new CommonPlugin_Tabs();

        foreach ($captions as $k => $v) {
            $tabs->addTab($captions[$k], new CommonPlugin_PageURL(null, array('type' => $k)));
        }

        $tabs->setCurrent($captions[$type]);
        return $tabs;
    }

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
            'action' => new CommonPlugin_PageURL(null, array('action' => 'resendFormSubmit'))
        );

        if (isset($_SESSION[self::PLUGIN])) {
            $params += $_SESSION[self::PLUGIN];
            unset($_SESSION[self::PLUGIN]);
        }
        $panel = new UIPanel('Resend campaign', $this->render(dirname(__FILE__) . '/view/resend_panel.tpl.php', $params));
        print $this->render(
            dirname(__FILE__) . '/view/resend.tpl.php', array(
                'toolbar' => $toolbar->display(),
                'panel' => $panel->display()
            )
        );
    }

    protected function actionResend()
    {
        $model = new CampaignsPlugin_Model_ResendForm($this->db);
        $model->reset();
        header('Location: ' . new CommonPlugin_PageURL(null, array(
            'action' => 'resendForm', 'campaignID' => $this->model->campaignID
        )));
        exit;
    }

    protected function actionRequeue()
    {
        $r = $this->model->requeueMessage();
        $_SESSION[self::PLUGIN]['actionResult'] = $r
            ? $this->i18n->get('Campaign %d requeued', $this->model->{self::RADIONAME})
            : $this->i18n->get('Unable to requeue campaign %d', $this->model->{self::RADIONAME});
        header('Location: ' . new CommonPlugin_PageURL(null, array('type' => 'active')));
        exit;
    }

    protected function actionCopy()
    {
        $id = $this->model->copyMessage();
        $_SESSION[self::PLUGIN]['actionResult'] = $id
            ? $this->i18n->get('Campaign %d copied to %d', $this->model->{self::RADIONAME}, $id)
            : $this->i18n->get('Unable to copy campaign %d', $this->model->{self::RADIONAME});
        header('Location: ' . new CommonPlugin_PageURL(null, array('type' => 'draft')));
        exit;
    }

    protected function actionDelete()
    {
        $r = $this->model->deleteMessage();
        $_SESSION[self::PLUGIN]['actionResult'] = $r
            ? $this->i18n->get('Campaign %d deleted', $this->model->{self::RADIONAME})
            : $this->i18n->get('Unable to delete %d ', $this->model->{self::RADIONAME});
        header('Location: ' . new CommonPlugin_PageURL(null, array('type' => $this->model->type)));
        exit;
    }

    protected function actionDeleteDrafts()
    {
        $r = $this->model->deleteDraftMessages();
        $_SESSION[self::PLUGIN]['actionResult'] = $this->i18n->get('%d campaigns deleted', $r);
        header('Location: ' . new CommonPlugin_PageURL(null, array('type' => $this->model->type)));
        exit;
    }

    protected function actionEdit()
    {
        header('Location: ' . new CommonPlugin_PageURL('send', array('id' => $this->model->campaignID)));
        exit;
    }

    protected function actionDefault()
    {
        $toolbar = new CommonPlugin_Toolbar($this);
        $toolbar->addHelpButton('campaigns');
        $listing = new CommonPlugin_Listing($this, $this);
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
        print $this->render(dirname(__FILE__) . '/view/campaigns.tpl.php', $params);
    }

    public function __construct()
    {
        parent::__construct();
        $this->db = new CommonPlugin_DB();
        $this->model = new CampaignsPlugin_Model_Campaigns($this->db);
        $this->model->setProperties($_REQUEST);
    }
    /*
     * Implementation of CommonPlugin_IPopulator
     */
    public function populate(WebblerListing $w, $start, $limit)
    {
        /*
         * Populates the webbler list with campaign details
         */
        $w->title = $this->i18n->get('Campaigns');

        foreach ($this->model->campaigns($start, $limit) as $row) {
            $key = $row['id'];
            $w->addElement($key, new CommonPlugin_PageURL('message', array('id' => $row['id'])));
            $details = array(
                sprintf('%s: %s', $this->i18n->get('From'), $row['fromfield']),
                sprintf('%s: %s', $this->i18n->get('Subject'), $row['subject']),
                sprintf('%s: %s', $this->i18n->get('Entered'), $row['entered'])
            );

            if ($this->model->type == 'sent') {
                $details[] = sprintf('%s: %s', $this->i18n->get('Sent'), $row['sent']);
            } else {
                $details[] = sprintf('%s: %s', $this->i18n->get('Embargo'), $row['embargo']);
            }
            $w->addColumnHtml($key, 'details', implode('<br>', $details));
            $w->addColumn($key, 'status', $row['status'], '');
            $select = CHtml::radioButton(self::RADIONAME, false, array('value' => $key));
            $w->addColumnHtml($key, 'select', $select);
        }
        $query = array('type' => $this->model->type);

         if ($this->model->type == 'sent') {
            $this->addButton($w, 'Resend', true, '', array('action' => 'resend'));
        }
         if ($this->model->type == 'sent' || $this->model->type == 'active') {
            $query['action'] = 'requeue';
            $this->addButton($w, 'Requeue', true, $this->i18n->get('requeue_prompt'), $query);
        }
        $query['action'] = 'copy';
        $this->addButton($w, 'Copy', true, $this->i18n->get('copy_prompt'), $query);

        $query['action'] = 'delete';
        $this->addButton($w, 'Delete', true, $this->i18n->get('delete_prompt'), $query);

        if ($this->model->type == 'draft') {
            $query['action'] = 'deleteDrafts';
            $this->addButton($w, 'Delete drafts', false, $this->i18n->get('delete_draft_prompt'), $query);
        }

        $query['action'] = 'edit';
        $this->addButton($w, 'Edit', true, '', $query);
    }

    private function addButton(WebblerListing $w, $caption, $select, $prompt, array $query)
    {
        $w->addButton($caption, sprintf(
            "javascript:formSubmit(%s, '%s', '%s', '%s', '%s')",
            $select ? 'true' : 'false', $prompt, self::FORMNAME, self::RADIONAME, new CommonPlugin_PageURL(null, $query)
        ));
    }

    public function total()
    {
        return $this->model->totalCampaigns();
    }
}
