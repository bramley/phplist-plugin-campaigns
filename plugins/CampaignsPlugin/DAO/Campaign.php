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
class CampaignsPlugin_DAO_Campaign extends CommonPlugin_DAO_Message
{
    private function wrapQuotes($v)
    {
        return "'$v'";
    }

    private function typeToStatus($type)
    {
        switch ($type) {
            case 'active':
                return array('inprocess', 'submitted', 'suspended');
                break;
            case 'sent':
                return array('sent');
                break;
            default:
                return array($type);
        }
    }

    public function campaigns($owner, $type, $start, $limit)
    {
        $statuses = $this->typeToStatus($type);
        $conditions = array();

        if ($owner) {
            $conditions[] = "(m.owner = $owner)";
        }

        if (count($statuses) > 0) {
            $values = implode(',', array_map(array($this, 'wrapQuotes'), $statuses));
            $conditions[] = "(m.status IN ($values))";
        }

        $where = count($conditions) > 0 ? 'WHERE ' . implode(' AND ', $conditions) : '';
        $sql =
            "SELECT m.*,
                (SELECT GROUP_CONCAT(l.name SEPARATOR '|')
                    FROM {$this->tables['list']} l
                    JOIN {$this->tables['listmessage']} lm ON lm.listid = l.id
                    WHERE lm.messageid = m.id
                ) AS lists
            FROM {$this->tables['message']} m
            $where
            ORDER BY m.id DESC
            LIMIT $start, $limit";

        return $this->dbCommand->queryAll($sql);
    }

    public function totalCampaigns($owner, $type)
    {
        $statuses = $this->typeToStatus($type);
        $conditions = array();

        if ($owner) {
            $conditions[] = "(owner = $owner)";
        }

        if (count($statuses) > 0) {
            $values = implode(',', array_map(array($this, 'wrapQuotes'), $statuses));
            $conditions[] = "(status IN ($values))";
        }

        $where = count($conditions) > 0 ? 'WHERE ' . implode(' AND ', $conditions) : '';
        $sql =
            "SELECT count(*) AS t 
            FROM {$this->tables['message']} m
            $where";

        return $this->dbCommand->queryOne($sql);
    }
}
