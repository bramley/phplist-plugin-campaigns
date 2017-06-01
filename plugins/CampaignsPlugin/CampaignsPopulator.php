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
 * This class populates the listing of campaigns.
 */
class CampaignsPlugin_CampaignsPopulator implements CommonPlugin_IPopulator
{
    const PLUGIN = 'CampaignsPlugin';
    const FORMNAME = 'MessagesForm';
    const CHECKBOXNAME = 'campaignID';

    private $dao;
    private $i18n;
    private $owner;
    private $type;

    private function addButton(WebblerListing $w, $caption, $select, $prompt, array $query)
    {
        $w->addButton(
            $caption,
            htmlspecialchars(sprintf(
                "javascript:formSubmit(%s, '%s', '%s', '%s', '%s', '%s', '%s')",
                $select,
                $prompt,
                self::FORMNAME,
                self::CHECKBOXNAME,
                new CommonPlugin_PageURL(null, $query),
                $this->i18n->get('none_selected_error'),
                $this->i18n->get('only_one_allowed_error')
            ))
        );
    }

    private function confirmDeleteButton($id)
    {
        return new confirmButton(
            $this->i18n->get('delete_prompt'),
            new CommonPlugin_PageURL(
                null,
                array('action' => 'deleteOne', 'campaignID' => $id, 'redirect' => $_SERVER['REQUEST_URI'])
            ),
            'Delete',
            'delete campaign',
            'button'
        );
    }

    private function confirmCopyButton($id)
    {
        return new confirmButton(
            $this->i18n->get('copy_prompt'),
            new CommonPlugin_PageURL(
                null,
                array('action' => 'copy', 'campaignID' => $id)
            ),
            'Copy',
            'copy campaign',
            'button'
        );
    }

    public function __construct($owner, $type, $dao, $i18n)
    {
        $this->owner = $owner;
        $this->type = $type;
        $this->dao = $dao;
        $this->i18n = $i18n;
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
        $rows = $this->dao->campaigns($this->owner, $this->type, $start, $limit);

        if (count($rows) == 0) {
            return;
        }
        $type = $this->type;

        foreach ($rows as $row) {
            $message = loadMessageData($row['id']);
            $key = ($message['subject'] == $message['campaigntitle'])
                ? "$row[id] | $message[subject]"
                : "$row[id] | $message[campaigntitle]<br><b>$message[subject]</b>";
            $w->addElement($key, new CommonPlugin_PageURL('message', array('id' => $row['id'])));
            $details = array(
                sprintf('%s: %s', $this->i18n->get('From'), $row['fromfield']),
                sprintf('%s: %s', $this->i18n->get('Entered'), formatDateTime($row['entered'])),
            );

            if ($type == 'sent') {
                $details[] = sprintf('%s: %s', $this->i18n->get('Sent'), formatDateTime($row['sent']));
            } else {
                $details[] = sprintf('%s: %s', $this->i18n->get('Embargo'), formatDateTime($row['embargo']));
            }
            $w->addColumnHtml($key, $this->i18n->get('details'), implode('<br>', $details));

            if ($type == 'active') {
                $w->addColumn($key, $this->i18n->get('status'), $row['status'], '');
            }
            $deleteButton = $this->confirmDeleteButton($row['id']);
            $copyButton = $this->confirmCopyButton($row['id']);
            $editLink = new CommonPlugin_PageLink(
                new CommonPlugin_PageURL('send', array('id' => $row['id'])),
                'Edit',
                array('class' => 'button', 'title' => 'edit campaign')
            );

            if ($type == 'sent') {
                $resendLink = new CommonPlugin_PageLink(
                    new CommonPlugin_PageURL('resend', array('pi' => self::PLUGIN, 'action' => 'resendForm', 'campaignID' => $row['id'])),
                    'Resend',
                    array('class' => 'button', 'title' => 'resend campaign')
                );
                $requeueLink = new CommonPlugin_PageLink(
                    new CommonPlugin_PageURL(null, array('action' => 'requeue', 'campaignID' => $row['id'])),
                    'Requeue',
                    array('class' => 'button', 'title' => 'requeue campaign')
                );
            } else {
                $resendLink = '';
                $requeueLink = '';
            }

            $w->addColumnHtml(
                $key,
                $this->i18n->get('action'),
                '<span class="edit">' . $editLink . '</span>'
                . '<span class="copy">' . $copyButton->show() . '</span>'
                . '<span class="re-send">' . $resendLink . '</span>'
                . '<span class="resend">' . $requeueLink . '</span>'
                . '<span class="delete">' . $deleteButton->show() . '</span>'
            );
            $select = CHtml::checkBox(self::CHECKBOXNAME . '[]', false, array('value' => $row['id']));
            $w->addColumnHtml($key, $this->i18n->get('select'), $select);
            $w->addRowHtml($key, $this->i18n->get('lists'), str_replace('|', '<br>', htmlspecialchars($row['lists'])), '');
        }

        $this->addButton(
            $w,
            $this->i18n->get('delete_button'),
            2,
            $this->i18n->get('delete_prompt'),
            array('action' => 'delete', 'redirect' => urlencode($_SERVER['REQUEST_URI']))
        );

        if ($type == 'draft') {
            $this->addButton(
                $w,
                $this->i18n->get('delete_drafts_button'),
                0,
                $this->i18n->get('delete_draft_prompt'),
                array('action' => 'deleteDrafts')
            );
        }
    }

    public function total()
    {
        return $this->dao->totalCampaigns($this->owner, $this->type);
    }
}
