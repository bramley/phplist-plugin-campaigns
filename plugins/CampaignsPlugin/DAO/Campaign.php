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
 * @copyright 2014 Duncan Cameron
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License, Version 3
 * @link      http://forums.phplist.com/
 */

/**
 * 
 */
class CampaignsPlugin_DAO_Campaign extends CommonPlugin_DAO_Message
{
    private function wrapQuotes($v)
    {
        return "'$v'";
    }

    public function campaigns($owner, array $statuses, $start, $limit)
    {
        $conditions = array();

        if ($owner)
            $conditions[] = "(owner = $owner)";

        if (count($statuses) > 0) {
            $values = implode(',', array_map(array($this, 'wrapQuotes'), $statuses));
            $conditions[] = "(status IN ($values))";
        }

        $where = count($conditions) > 0 ? 'WHERE ' . implode(' AND ', $conditions) : '';
        $sql =
            "SELECT * FROM {$this->tables['message']}
            $where
            ORDER BY id DESC
            LIMIT $start, $limit";

        return $this->dbCommand->queryAll($sql);
    }

    public function totalCampaigns($owner, array $statuses) {
        $conditions = array();

        if ($owner)
            $conditions[] = "(owner = $owner)";

        if (count($statuses) > 0) {
            $values = implode(',', array_map(array($this, 'wrapQuotes'), $statuses));
            $conditions[] = "(status IN ($values))";
        }

        $where = count($conditions) > 0 ? 'WHERE ' . implode(' AND ', $conditions) : '';
        $sql =
            "SELECT count(*) AS t 
            FROM {$this->tables['message']} m
            $where";

        return $this->dbCommand->queryOne($sql, 't');
    }
}
