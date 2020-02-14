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
 * @copyright 2014-2020 Duncan Cameron
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
        <div class="error"><?= $errorMessage ?></div>
<?php endif; ?>
<?php if (isset($resendResults)): ?>
        <div>
    <?php if ($resendResults['deleted']): ?>
            <div class="note">
                <?= $this->i18n->get('campaign will be resent to these subscribers'), '<br/>', implode('<br/>', $resendResults['deleted']); ?>
            </div>
    <?php endif; ?>
    <?php if ($resendResults['bounced']): ?>
            <div class="note">
                <?= $this->i18n->get('bounces deleted for'), '<br/>', implode('<br/>', $resendResults['bounced']); ?>
            </div>
    <?php endif; ?>
    <?php if ($resendResults['notsent']): ?>
            <div class="note">
                <?= $this->i18n->get('campaign was not originally sent to these subscribers'), '<br/>', implode('<br/>', $resendResults['notsent']); ?>
            </div>
    <?php endif; ?>
    <?php if ($resendResults['ignored']): ?>
            <div class="note">
                <?= $this->i18n->get('these subscribers are unknown'), '<br/>', implode('<br/>', $resendResults['ignored']); ?>
            </div>
    <?php endif; ?>
    <?php if ($resendResults['invalid']): ?>
            <div class="note">
                <?= $this->i18n->get('these are invalid email addresses'), '<br/>', implode('<br/>', $resendResults['invalid']); ?>
            </div>
    <?php endif; ?>
    <?php if ($resendResults['requeued']): ?>
            <p><?= $this->i18n->get('Campaign requeued'); ?></p>
    <?php endif; ?>
        </div>
<?php endif; ?>
    </div>
    <form method="POST" action="<?= $action; ?>">
        <table>
            <tr>
                <td>
                    <div><input type="submit" value="<?= $this->i18n->get('Load bounced') ?>" name="loadbounced" /></div>
                    <?= $this->i18n->get('email addresses (separated by whitespace)'); ?></td>
                <td>
                    <textarea name="emails" rows="10" cols="40" ><?= $model->emails; ?></textarea>
                </td>
            </tr>
            <tr>
                <td><?= CHtml::label($this->i18n->get('Delete associated bounce records'), 'bounce'); ?></td>
                <td><?= CHtml::checkBox('bounce', $model->bounce, array('uncheckValue' => 0)); ?></td>
            </tr>
            <tr>
                <td><?= CHtml::label($this->i18n->get('Adjust campaign totals'), 'totals'); ?></td>
                <td><?= CHtml::checkBox('totals', $model->totals, array('uncheckValue' => 0)); ?></td>
            </tr>
            <tr>
                <td><?= CHtml::label($this->i18n->get('Requeue the campaign'), 'requeue'); ?></td>
                <td><?= CHtml::checkBox('requeue', $model->requeue, array('uncheckValue' => 0)); ?></td>
            </tr>
        </table>
        <input type="submit" value="<?= $this->i18n->get('Submit') ?>" name="submit" />
    </form>


