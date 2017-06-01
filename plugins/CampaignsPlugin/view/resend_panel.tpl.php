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
 * This is the HTML template for the plugin page
 * 
 */

/**
 *
 * Available fields
 * - $model: CampaignsPlugin_Model_ResendForm
 * - $toolbar: HTML for toolbar
 * - $errorMessage: resend error message
 * - $resendResults: array of results
 * - $action: form action URL
 * - $message: 
 */
?>
    <div>
<?php if (isset($errorMessage)): ?>
        <div class="note"><?php echo $errorMessage ?></div>
<?php endif; ?>
<?php if (isset($resendResults)): ?>
        <div class="note">
        <b><?php echo $this->i18n->get('Campaign'); ?> <?php echo $resendResults['campaignID'] ?></b>
        <table>
    <?php if ($resendResults['deleted']): ?>
            <tr><td><?php echo $this->i18n->get('campaign will be resent to these subscribers'); ?> - </td><td><?php echo implode(', ', $resendResults['deleted']) ?></td></tr>
    <?php endif; ?>
    <?php if ($resendResults['bounced']): ?>
            <tr><td><?php echo $this->i18n->get('bounces deleted for'); ?> - </td><td><?php echo implode(', ', $resendResults['bounced']) ?></td></tr>
    <?php endif; ?>
    <?php if ($resendResults['notsent']): ?>
            <tr><td><?php echo $this->i18n->get('campaign was not originally sent to these subscribers'); ?> - </td><td><?php echo implode(', ', $resendResults['notsent']) ?></td></tr>
    <?php endif; ?>
    <?php if ($resendResults['ignored']): ?>
            <tr><td><?php echo $this->i18n->get('these subscribers are unknown'); ?> - </td><td><?php echo implode(', ', $resendResults['ignored']) ?></td></tr>
    <?php endif; ?>
    <?php if ($resendResults['invalid']): ?>
            <tr><td><?php echo $this->i18n->get('these are invalid email addresses'); ?> - </td><td><?php echo implode(', ', $resendResults['invalid']) ?></td></tr>
    <?php endif; ?>
        </table>
    <?php if ($resendResults['requeued']): ?>
        <p><?php echo $this->i18n->get('Campaign requeued'); ?></p>
    <?php endif; ?>
        </div>
<?php endif; ?>
    </div>
    <form method='POST' action='<?php echo $action; ?>'>
        <table>
            <tr>
                <td WIDTH='30%'><?php echo $this->i18n->get('Campaign'); ?></td>
                <td WIDTH='70%'><?php echo sprintf('%s | %s', $model->campaignID, $subject); ?></td>
            </tr>
            <tr>
                <td><?php echo $this->i18n->get('email addresses (separated by whitespace)'); ?></td>
                <td>
                    <textarea name='emails' rows='10' cols='40' ><?php echo $model->emails; ?></textarea>
                </td>
            </tr>
            <tr>
                <td><?php echo CHtml::label($this->i18n->get('Delete associated bounce records'), 'bounce'); ?></td>
                <td><?php echo CHtml::checkBox('bounce', $model->bounce, array('uncheckValue' => 0)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::label($this->i18n->get('Adjust campaign totals'), 'totals'); ?></td>
                <td><?php echo CHtml::checkBox('totals', $model->totals, array('uncheckValue' => 0)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::label($this->i18n->get('Requeue the campaign'), 'requeue'); ?></td>
                <td><?php echo CHtml::checkBox('requeue', $model->requeue, array('uncheckValue' => 0)); ?></td>
            </tr>
        </table>
        <input type=submit value="<?php echo $this->i18n->get('Submit') ?>" name='submit' />
    </form>


