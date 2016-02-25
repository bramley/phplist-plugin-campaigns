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
 * @copyright 2014-2016 Duncan Cameron
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License, Version 3
 * @link      http://forums.phplist.com/
 */

/**
 * This file contains the English text
 */
$lan = array(
    'plugin_title' => 'Campaigns Plugin',
    'Manage campaigns' => 'Manage campaigns',
    /* Controller.php */
    'tab_sent' => 'Sent',
    'tab_draft' => 'Draft',
    'tab_active' => 'Active',
    'campaign was not resent to any email addresses' => 'campaign was not resent to any email addresses',
    'email addresses must be entered' => 'email addresses must be entered',
    'Resend campaign' => 'Resend campaign',
    'Campaign %d requeued' => 'Campaign %d requeued',
    'Unable to requeue campaign %d' => 'Unable to requeue campaign %d',
    'Campaign %d copied to %d' => 'Campaign %d copied to %d',
    'Unable to copy campaign %d' => 'Unable to copy campaign %d',
    'Campaigns %s deleted' => 'Campaigns %s deleted',
    'Unable to delete %s ' => 'Unable to delete %s ',
    '%d campaigns deleted' => '%d campaigns deleted',
    'Campaigns' => 'Campaigns',
    'ID' => 'ID',
    'From' => 'From',
    'Subject' => 'Subject',
    'Entered' => 'Entered',
    'Embargo' => 'Embargo',
    'details' => 'details',
    'lists' => 'Lists',
    'status' => 'status',
    'select' => 'select',
    'Sent' => 'Sent',
    'resend_button' => 'Resend',
    'requeue_button' => 'Requeue',
    'requeue_prompt' => 'Are you sure that you want to requeue the selected campaign?',
    'copy_button' => 'Copy',
    'copy_prompt' => 'Are you sure that you want to copy the selected campaign?',
    'delete_button' => 'Delete selected',
    'delete_prompt' => 'This will delete all data for the campaigns. If you have enabled click tracking then link clicks will no longer work. Are you sure?',
    'delete_drafts_button' => 'Delete drafts',
    'delete_draft_prompt' => 'Are you sure that you want to delete all draft campaigns without a subject?',
    'edit_button' => 'Edit',
    /* resend_panel.tpl.php */
    'Campaign' => 'Campaign',
    'campaign will be resent to these subscribers' => 'campaign will be resent to these subscribers',
    'bounces deleted for' => 'bounces deleted for',
    'campaign was not originally sent to these subscribers' => 'campaign was not originally sent to these subscribers',
    'these subscribers are unknown' => 'these subscribers are unknown',
    'these are invalid email addresses' => 'these are invalid email addresses',
    'Campaign requeued' => 'Campaign requeued',
    'email addresses (separated by whitespace)' => 'email addresses (separated by whitespace)',
    'Delete associated bounce records' => 'Delete associated bounce records',
    'Adjust campaign totals' => 'Adjust campaign totals',
    'Requeue the campaign' => 'Requeue the campaign',
    'Submit' => 'Submit',
    /* campaigns.tpl.php */
    'none_selected_error' => 'A campaign must be selected',
    'only_one_allowed_error' => 'You can select only one campaign for this action',
);
