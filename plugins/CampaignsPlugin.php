<?php
/**
 * CampaignsPlugin for phplist
 * 
 * This file is a part of CampaignsPlugin.
 *
 * @category  phplist
 * @package   CampaignsPlugin
 * @author    Duncan Cameron
 * @copyright 2014 Duncan Cameron
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
        'main' => array('category' => 'campaigns')
    );
    public $pageTitles = array(
        'main' => 'Manage campaigns'
    );

    public function adminmenu() {
        return $this->pageTitles;
    }

    public function __construct() {
        $this->coderoot = dirname(__FILE__) . '/CampaignsPlugin/';
        $this->version = (is_file($f = $this->coderoot . self::VERSION_FILE))
            ? file_get_contents($f)
            : '';
        parent::__construct();
    }
}
?>
