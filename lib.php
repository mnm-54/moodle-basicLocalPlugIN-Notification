<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Version details
 *
 * @package    local_notification
 * @author     shahriar
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin 
 */


function local_notification_before_footer()
{
    global $DB, $USER;
    //$notifications = $DB->get_records('local_notification');

    $sql = "SELECT ln.id, ln.notificationtext, ln.notificationtype 
            FROM {local_notification} ln 
            LEFT OUTER JOIN {local_notification_read} lnr ON ln.id = lnr.notification_id 
            WHERE lnr.userid <> :userid 
            OR lnr.userid IS NULL";

    $params = [
        'userid' => $USER->id
    ];

    $notifications = $DB->get_records_sql($sql, $params);
    //die(var_dump($notifications));

    $choices = array(
        0 => \core\output\notification::NOTIFY_SUCCESS,
        1 => \core\output\notification::NOTIFY_WARNING,
        2 => \core\output\notification::NOTIFY_INFO,
        3 => \core\output\notification::NOTIFY_ERROR
    );

    foreach ($notifications as $notification) {
        \core\notification::add($notification->notificationtext, $choices[$notification->notificationtype]);

        // now creating record for the read notification

        $readrecord = new stdClass();
        $readrecord->notification_id = $notification->id;
        $readrecord->userid = $USER->id;
        $readrecord->timeread = time();

        $DB->insert_record('local_notification_read', $readrecord);
    }
}
