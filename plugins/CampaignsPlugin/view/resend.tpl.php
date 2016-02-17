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
    <hr>
    <?php echo $toolbar; ?>
    <div style='margin-top: 10px;'>
        <?php echo $panel; ?>
    </div>
</div>

