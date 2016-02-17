<?php
/**
 * CampaignsPlugin for phplist.
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
 *
 * @author    Duncan Cameron
 * @copyright 2014-2016 Duncan Cameron
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License, Version 3
 *
 * @link      http://forums.phplist.com/
 */

/**
 * This class holds the properties entered in the form.
 * 
 * @category  phplist
 */
class CampaignsPlugin_Model_ResendForm extends CommonPlugin_Model
{
    /*
     *    Private variables
     */
    private $dao;
    private $userDao;
    private $defaults = array(
        'campaignID' => null,
        'emails' => null,
        'bounce' => 1,
        'totals' => 0,
        'requeue' => 1,
    );

    public $subject;
    /*
     *    Inherited protected variables
     */
    protected $properties;
    protected $persist = array(
        'campaignID' => '',
        'emails' => '',
        'bounce' => '',
        'totals' => '',
        'requeue' => '',
    );
    /*
     *    Public methods
     */
    public function __construct($db)
    {
        $this->dao = new CampaignsPlugin_DAO_Resend($db);
        $this->userDao = new CommonPlugin_DAO_User($db);
        $this->properties = $this->defaults;
        parent::__construct('CampaignsPlugin');
    }
    public function setProperties(array $properties)
    {
        parent::setProperties($properties);

        if ($this->campaignID) {
            $row = $this->dao->messageById($this->campaignID);
            $this->subject = $row['subject'];
        }
    }

    public function loadBouncedEmails()
    {
        $emails = $this->dao->bouncedEmails($this->campaignID);
//        $this->setProperties(array('emails' => implode("\n", $emails)));
        $this->emails = '';

        return 0;

        return count($emails);
    }

    public function reset()
    {
        parent::setProperties($this->defaults);
    }

    public function resend()
    {
        $campaignID = $this->campaignID;
        $notsent = array();
        $deleted = array();
        $bounced = array();
        $ignored = array();
        $invalid = array();
        $requeued = false;

        $emails = preg_split('/\s+/', $this->emails, null, PREG_SPLIT_NO_EMPTY);

        foreach ($emails as $email) {
            if (!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
                $invalid[] = $email;
                continue;
            }

            if (!($row = $this->userDao->userByEmail($email))) {
                $ignored[] = $email;
                continue;
            }
            $userID = $row['id'];
            $count = $this->dao->deleteSent($campaignID, $userID);

            if ($count > 0) {
                $deleted[] = $email;

                if ($this->bounce) {
                    if ($this->dao->deleteBounces($campaignID, $userID) > 0) {
                        $bounced[] = $email;
                    }
                }

                if ($this->totals) {
                    $this->dao->adjustTotals($campaignID);
                }
            } else {
                $notsent[] = $email;
            }
        }

        if ($this->requeue && count($deleted) > 0) {
            $this->dao->requeueMessage($campaignID);
            $requeued = true;
        }

        return array(
                'campaignID' => $campaignID,
                'deleted' => $deleted,
                'bounced' => $bounced,
                'ignored' => $ignored,
                'notsent' => $notsent,
                'requeued' => $requeued,
                'invalid' => $invalid,
        );
    }
}
