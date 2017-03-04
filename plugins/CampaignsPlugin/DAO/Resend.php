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
 * This class provides access to the phplist database.
 */
class CampaignsPlugin_DAO_Resend extends CommonPlugin_DAO_Message
{
    public function deleteSent($mid, $userid)
    {
        $sql =
            "DELETE FROM {$this->tables['usermessage']} 
            WHERE messageid = $mid AND userid = $userid";

        return $this->dbCommand->queryAffectedRows($sql);
    }

    public function bouncedEmails($mid)
    {
        $sql =
            "SELECT email FROM {$this->tables['user']} u
            JOIN {$this->tables['user_message_bounce']} umb ON u.id = umb.user
            WHERE umb.message = $mid";

        return $this->dbCommand->queryColumn($sql, 'email');
    }

    public function deleteBounces($mid, $userid)
    {
        $sql =
            "DELETE FROM {$this->tables['bounce']} 
            WHERE id IN (
                SELECT bounce
                FROM {$this->tables['user_message_bounce']}
                WHERE user = $userid AND message = $mid
            )";
        $count = $this->dbCommand->queryAffectedRows($sql);

        if ($count > 0) {
            $sql =
                "DELETE FROM {$this->tables['user_message_bounce']}
                WHERE user = $userid AND message = $mid";
            $this->dbCommand->queryAffectedRows($sql);

            $sql =
                "UPDATE {$this->tables['message']}
                SET bouncecount = bouncecount - 1 
                WHERE id = $mid";
            $this->dbCommand->queryAffectedRows($sql);

            $sql =
                "UPDATE {$this->tables['user']} 
                SET bouncecount = bouncecount - 1 
                WHERE id = $userid";
            $this->dbCommand->queryAffectedRows($sql);
        }

        return $count;
    }

    public function adjustTotals($mid)
    {
        $sql =
            "UPDATE {$this->tables['message']}
            SET processed = processed - 1 
            WHERE id = $mid";
        $count = $this->dbCommand->queryAffectedRows($sql);

        $sql =
            "UPDATE {$this->tables['message']} 
            SET ashtml = ashtml - 1 
            WHERE id = $mid AND sendformat = 'HTML'";
        $count = $this->dbCommand->queryAffectedRows($sql);

        $sql =
            "UPDATE {$this->tables['message']} 
            SET astext = astext - 1 
            WHERE id = $mid AND sendformat = 'text'";
        $count = $this->dbCommand->queryAffectedRows($sql);
    }
}
