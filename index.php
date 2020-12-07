<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Index page of helloworld plugin
 *
 * @package    local_helloworld
 * @copyright  2020 Jakub Kleban <jakub.kleban2000@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
require_login();

// Variables.
$username = optional_param('username', null, PARAM_ALPHA);
$heading = get_string('hellouser', 'local_helloworld', fullname($USER));
$context = context_system::instance();

// Page setup.
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
$PAGE->set_heading($heading);
$PAGE->set_title(get_string('pluginname', 'local_helloworld'));
$PAGE->set_url(new moodle_url('/local/helloworld/index.php'));
$output = $PAGE->get_renderer('local_helloworld');

// Save message into database.
if (has_capability('local/helloworld:postmessages', $context)) {
    $messagetext = optional_param('message', null, PARAM_TEXT);
    if (isset($messagetext) && !empty($messagetext)) {
        $time = new DateTime("now", core_date::get_server_timezone_object());
        $timestamp = $time->getTimestamp();

        $message = new stdClass();
        $message->message = $messagetext;
        $message->timecreated = $timestamp;
        $message->userid = $USER->id;

        $DB->insert_record('local_helloworld_messages', $message);
    }
}

// RENDERING HTML.
echo $output->header();

echo $output->display_script($PAGE->url, $context);

echo $output->footer();