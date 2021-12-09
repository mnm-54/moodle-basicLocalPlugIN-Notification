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


require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/local/notification/classes/form/edit.php');

global $DB;

$PAGE->set_url(new moodle_url('/local/notification/manage.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('title_edit', 'local_notification'));

$mform = new edit();

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
    redirect($CFG->wwwroot . '/local/notification/manage.php', get_string('cancelled_form', 'local_notification'));
} else if ($fromform = $mform->get_data()) {
    //In this case you process validated data. $mform->get_data() returns data posted in form.

    $recordtoinsert = new stdClass();
    $recordtoinsert->notificationtext = $fromform->notificationtext;
    $recordtoinsert->notificationtype = $fromform->notificationtype;

    $DB->insert_record('local_notification', $recordtoinsert);

    redirect($CFG->wwwroot . '/local/notification/manage.php', get_string('created_notification', 'local_notification') . $fromform->notificationtype);
}

echo $OUTPUT->header();

$mform->display();

echo $OUTPUT->footer();
