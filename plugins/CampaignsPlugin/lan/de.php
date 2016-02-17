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
 * This file contains the German text
 */
$lan = array(
    'plugin_title' => 'Campaigns Plugin',
    'Manage campaigns' => 'Nachrichten verwalten',
    /* Controller.php */
    'tab_sent' => 'Gesendet',
    'tab_draft' => 'Entwürfe',
    'tab_active' => 'Aktiv',
    'campaign was not resent to any email addresses' => 'Fehler: Nachricht konnte nicht versendet werden.',
    'email addresses must be entered' => 'Sie müssen mindestens eine E-Mail-Adresse eingeben.',
    'Resend campaign' => 'Nachricht erneut versenden',
    'Campaign %d requeued' => 'Nachricht Nr. %d wurde der Warteschlange wieder hinzugefügt',
    'Unable to requeue campaign %d' => 'Kann Nachricht Nr. %d der Warteschlange nicht wieder hinzufügen',
    'Campaign %d copied to %d' => 'Kopie der Nachricht Nr. %d erzeugt; kopierte Nachricht hat die Nr. %d',
    'Unable to copy campaign %d' => 'Kann Nachricht Nr. %d nicht kopieren',
    'Campaign %d deleted' => 'Nachricht Nr. %d gelöscht',
    'Unable to delete %d ' => 'Kann Nachricht Nr. %d nicht löschen',
    '%d campaigns deleted' => '%d Nachrichten gelöscht',
    'Campaigns' => 'Nachrichten',
    'ID' => 'ID',
    'From' => 'Von',
    'Subject' => 'Betreff',
    'Entered' => 'Erfasst',
    'Embargo' => 'Sperrfrist',
    'details' => 'Details',
    'lists' => 'Listen',
    'status' => 'Status',
    'select' => 'ausw.',
    'Sent' => 'Versendet',
    'resend_button' => 'Erneut versenden',
    'requeue_button' => 'Der Warteschlange hinzufügen',
    'requeue_prompt' => 'Sind Sie sicher, dass Sie die ausgewählte Nachricht wieder der Warteschleife hinzufügen möchten?',
    'copy_button' => 'Kopieren',
    'copy_prompt' => 'Sind Sie sicher, dass Sie die ausgewählte Nachricht kopieren möchten?',
    'delete_button' => 'Löschen',
    'delete_prompt' => 'Dies wird alle Daten zu dieser Nachricht löschen. Wenn Sie Click-Tracking aktiviert haben, werden Links nicht mehr funktionieren. Sind Sie sicher?',
    'delete_drafts_button' => 'Entwürfe ohne Betreff löschen',
    'delete_draft_prompt' => 'Sind Sie sicher, dass Sie alle Nachrichten-Entwürfe ohne Betreff löschen möchten?',
    'edit_button' => 'Bearbeiten',
    /* resend_panel.tpl.php */
    'Campaign' => 'Nachricht',
    'campaign will be resent to these subscribers' => 'Nachricht wird diesen Abonnenten erneut zugeschickt',
    'bounces deleted for' => 'Retouren gelöscht für',
    'campaign was not originally sent to these subscribers' => 'Nachricht wurde ursprünglich nicht an diese Abonnenten geschickt',
    'these subscribers are unknown' => 'Diese Abonnenten sind unbekannt',
    'these are invalid email addresses' => 'Diese E-Mail-Adressen sind ungültig',
    'Campaign requeued' => 'Nachricht wurde der Warteschlange wieder hinzugefügt',
    'email addresses (separated by whitespace)' => 'E-Mail-Adressen (einzelne Adressen durch Leerzeichen trennen)',
    'Delete associated bounce records' => 'Lösche verknüpfte Retouren-Einträge',
    'Adjust campaign totals' => 'Nachrichten-Statistiken anpassen',
    'Requeue the campaign' => 'Nachricht wieder der Warteschlange hinzufügen',
    'Submit' => 'Versenden',
    /* campaigns.tpl.php */
    'campaign_select_error' => 'Es muss eine Nachricht ausgewählt sein.',
);
