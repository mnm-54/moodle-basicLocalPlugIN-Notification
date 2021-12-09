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


//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class edit extends moodleform
{
    //Add elements to form
    public function definition()
    {
        global $CFG;

        $mform = $this->_form; // Don't forget the underscore! 

        $mform->addElement('text', 'notificationtext',  get_string('notification_txt', 'local_notification')); // Add elements to your form
        $mform->setType('notificationtext', PARAM_NOTAGS);                   //Set type of element
        $mform->setDefault('notificationtext', get_string('enter_notification', 'local_notification'));        //Default value


        $choices = array();
        $choices = array(
            0 => \core\output\notification::NOTIFY_SUCCESS,
            1 => \core\output\notification::NOTIFY_WARNING,
            2 => \core\output\notification::NOTIFY_INFO,
            3 => \core\output\notification::NOTIFY_ERROR
        );
        $mform->addElement('select', 'notificationtype', get_string('notification_typ', 'local_notification'), $choices);
        $mform->setDefault('notificationtype', 2);
        $mform->setAdvanced('mailformat');


        $this->add_action_buttons();
    }
    //Custom validation should be added here
    function validation($data, $files)
    {
        return array();
    }
}
