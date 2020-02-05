<?php
/**
 * CampaignsPlugin for phplist.
 *
 * This file is a part of CampaignsPlugin.
 *
 * @category  phplist
 *
 * @author    Duncan Cameron
 * @copyright 2014-2020 Duncan Cameron
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License, Version 3
 */
class CampaignsPlugin extends phplistPlugin
{
    const VERSION_FILE = 'version.txt';

    /*
     *  Inherited variables
     */
    public $name = 'Campaigns Plugin';
    public $enabled = true;
    public $authors = 'Duncan Cameron';
    public $description = 'Campaign maintenance';
    public $topMenuLinks = array(
        'campaigns' => array('category' => 'campaigns'),
    );
    public $documentationUrl = 'https://resources.phplist.com/plugin/campaigns';

    public function __construct()
    {
        $this->coderoot = dirname(__FILE__) . '/CampaignsPlugin/';
        parent::__construct();
        $this->version = (is_file($f = $this->coderoot . self::VERSION_FILE))
            ? file_get_contents($f)
            : '';
    }

    /**
     * Provide the dependencies for enabling this plugin.
     *
     * @return array
     */
    public function dependencyCheck()
    {
        global $plugins;

        return array(
            'Common plugin v3.8.0 or later installed' => (
                phpListPlugin::isEnabled('CommonPlugin')
                && version_compare($plugins['CommonPlugin']->version, '3.8.0') >= 0
            ),
            'PHP version 5.4.0 or greater' => version_compare(PHP_VERSION, '5.4') > 0,
            'phpList version 3.3.2 or later' => version_compare(VERSION, '3.3.2') >= 0,
        );
    }

    /**
     * Use this hook for translated menu items.
     */
    public function activate()
    {
        $i18n = new CommonPlugin_I18N($this);
        $this->pageTitles = array(
            'campaigns' => $i18n->get('Manage campaigns'),
            'resend' => $i18n->get('Resend campaign'),
        );
    }

    public function adminmenu()
    {
        return $this->pageTitles;
    }
}
