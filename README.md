# Campaign Management Plugin #

## Description ##

The plugin provides extra commands to handle campaigns, beyond those in core phplist.

* copy a campaign to a new campaign
* delete a campaign, regardless of its status
* edit a campaign, regardless of its status
* resend a campaign to specific subscribers

It also provides the core phplist functions of requeue and delete drafts.

Be careful if you have enabled click tracking and delete a "sent" message, as the campaign's click tracking data
will also be deleted and clicks of links in the campaign will no longer work.

The plugin adds an item to the Campaigns menu to display a page of campaigns organised in three tabs - Sent, Active and Draft.

## Installation ##

### Dependencies ###

This plugin requires phplist release 3.2.2 or later, and requires php version 5.4 or later.

You also need to install the Common Plugin version 3.6.3 or later. This plugin is now included with phpList so
you should not normally need to install it and need only to enable it on the Manage Plugins page.

See <https://github.com/bramley/phplist-plugin-common>

### Install through phplist ###
Install on the Plugins page (menu Config > Manage Plugins) using the package URL

`https://github.com/bramley/phplist-plugin-campaigns/archive/master.zip`

### Install manually ###
Download the plugin zip file from <https://github.com/bramley/phplist-plugin-campaigns/archive/master.zip>

Expand the zip file, then copy the contents of the plugins directory to your phplist plugins directory.
This should contain

* the file CampaignsPlugin.php
* the directory CampaignsPlugin

## Usage ##

For guidance on usage see the plugin page within the phplist documentation site <https://resources.phplist.com/plugin/campaigns>

## Version history ##

    version     Description
    2.3.4+20200204  Revise README
    2.3.3+20190509  Improve display of action buttons for the trevellin theme
    2.3.2+20190328  Minor bug fix
    2.3.1+20170625  Write to event log when a campaign is deleted
    2.3.0+20170601  Internal changes and reworking
    2.2.3+20170304  Use core phplist help dialog
    2.2.2+20160331  Updated dependencies
    2.2.1+20160226  Correct the location of button images
    2.2.0+20160226  Allow multiple delete, use buttons for actions that apply to only one campaign
    2.1.0+20160217  Return to original page after deleting a campaign
    2.0.0+20150815  Added dependencies
    2015-05-30      Add German translation
    2015-03-23      Change to autoload approach
    2014-05-28      Fix for GitHub issue #2
    2014-05-27      Add column to display lists
    2014-02-15      Initial version
