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

The plugin adds an item to the Campaigns menu to display a page of campaigns organised in three tabs - Sent, Draft and Active.

## Installation ##

### Dependencies ###

Requires php version 5.2 or later.

Requires the Common Plugin to be installed. 

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
    2014-05-27  Add column to display lists
    2014-02-15  Initial version
