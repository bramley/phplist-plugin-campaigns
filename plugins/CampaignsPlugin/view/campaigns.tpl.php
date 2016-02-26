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
 */

/**
 *
 * Available fields
 * - $actionResult: optional result of copying a message
 * - $help: HTML for help widget
 * - $formName: name for the form
 * - $listing: HTML result of listing display
 */
global $pagefooter;
global $pageroot;

$pagefooter[basename(__FILE__)] = <<<'END'

<script language="javascript" type="text/javascript">

function formSubmit(select, prompt, name, radio, url, noneselectederror, onlyoneallowederror) {
/**
 * select - whether a radio button must be selected
 * prompt - confirmation prompt, empty if not required
 * name - form name
 * radio - radio buttons name
 * url - URL for form action
 */
    var form = document.forms[name];
    var radios = form.elements[radio];

    if (!radios.length) {
        radios = [radios];
    }
    var found = 0;

    for (i = 0; i < radios.length; i++){
        if (radios[i].checked == true) {
            ++found;
        }
    }

    if (select != 0 && found == 0) {
        alert(noneselectederror);
    } else if (select == 1 && found > 1) {
        alert(onlyoneallowederror);
    } else {
        if (prompt == '' || confirm(prompt)) {
            form.action = url;
            form.submit();
        }
    }
}
</script>
END;
?>
<style>
span.copy a.button {
    background:url("<?php echo $pageroot; ?>/admin/ui/dressprow/images/16x16/plus.png") no-repeat scroll 50% 50%;
    width: 16px;
    height: 16px;
    vertical-align: middle;
    overflow: hidden;
    text-indent: -9999px;
}
span.re-send a.button {
    background:url("<?php echo $pageroot; ?>/admin/ui/dressprow/images/16x16/customers.png") no-repeat scroll 50% 50%;
    width: 16px;
    height: 16px;
    vertical-align: middle;
    overflow: hidden;
    text-indent: -9999px;
}

</style>
<div id="top">
    <hr/>
<?php echo $toolbar; ?>
<?php echo $tabs; ?>
    <div style='padding-top: 10px;' >
<?php if (isset($actionResult)): ?>
        <div class="note"><?php echo $actionResult; ?></div>
<?php endif; ?>
        <form name='<?php echo $formName; ?>' method='post'>
<?php echo $listing; ?>
        </form>
    </div>
    <a href='#top'>[<?php echo $this->i18n->get('top') ?>]</a>
</div>
