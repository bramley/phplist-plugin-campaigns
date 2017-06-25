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

You also need to install the Common Plugin version 3.6.3 or later, and should install or upgrade to the latest version.
See <https://github.com/bramley/phplist-plugin-common>

### Set the plugin directory ###
You can use a directory outside of the web root by changing the definition of `PLUGIN_ROOTDIR` in config.php.
The benefit of this is that plugins will not be affected when you upgrade phplist.

### Install through phplist ###
Install on the Plugins page (menu Config > Plugins) using the package URL `https://github.com/bramley/phplist-plugin-campaigns/archive/master.zip`.

In phplist releases 3.0.5 and earlier there is a bug that can cause a plugin to be incompletely installed on some configurations (<https://mantis.phplist.com/view.php?id=16865>). 
Check that these files are in the plugin directory. If not then you will need to install manually. The bug has been fixed in release 3.0.6.

* the file CampaignsPlugin.php
* the directory CampaignsPlugin

### Install manually ###
Download the plugin zip file from <https://github.com/bramley/phplist-plugin-campaigns/archive/master.zip>

Expand the zip file, then copy the contents of the plugins directory to your phplist plugins directory.
This should contain

* the file CampaignsPlugin.php
* the directory CampaignsPlugin

## Version history ##

    version     Description
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
