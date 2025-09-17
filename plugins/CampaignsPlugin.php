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
        return [
            'Common plugin must be enabled' => phpListPlugin::isEnabled('CommonPlugin'),
        ];
    }

    /**
     * Use this hook for translated menu items.
     */
    public function activate()
    {
        $i18n = new phpList\plugin\Common\I18N($this);
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
