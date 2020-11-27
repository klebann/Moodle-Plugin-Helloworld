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
 * Renderer for local_helloworld
 *
 * TODO: get name from user. display it in header. Remove asking what is your name. Change 'message' -> 'content' in Database. Add author of message.
 *
 * @package    local_helloworld
 * @copyright  2020 Jakub Kleban <jakub.kleban2000@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/**
 * Renderer for displaying local_helloworld as HTML
 *
 * @package    local_helloworld
 * @copyright  2020 Jakub Kleban <jakub.kleban2000@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class local_helloworld_renderer extends plugin_renderer_base {

    /**
     * Generates html to display script
     *
     * @param bool $isusernameset Is the username set?
     * @param string $url URL of index.php
     * @return string
     */
    public function display_script($isusernameset, $url) {
        $output = '';
        if ($isusernameset) {
            $output .= $this->type_your_message($url);
        } else {
            $output .= $this->ask_me_for_name($url);
        }

        $output .= $this->display_messages();

        $output .= $this->footer($url);

        return $output;
    }

    /**
     * Generate html to make textarea message form
     *
     * @param string $url URL of index.php
     * @return string Form for message-textarea
     */
    private function type_your_message($url) {
        $output = '';

        $output .= html_writer::start_tag('form', array(
                'method' => 'post',
                'action' => $url
        ));
            $output .= html_writer::start_div('form-group');
                $output .= html_writer::label(get_string('typemessage', 'local_helloworld'), 'messagetextarea');
                $output .= html_writer::tag('textarea', '', array(
                        'class' => 'form-control',
                        'id' => 'messagetextarea',
                        'rows' => 5,
                        'name' => 'message'
                ));
            $output .= html_writer::end_div();
            $output .= html_writer::tag('button', get_string('messageselectadd', 'core_moodle') , array(
                    'type' => 'submit',
                    'class' => 'btn btn-primary'
            ));
        $output .= html_writer::end_tag('form');

        return $output;
    }

    /**
     * Generate name-input form
     *
     * @param string $url URL of index.php
     * @return string html for user name input
     */
    private function ask_me_for_name($url) {
        $output = '';

        $output .= html_writer::tag('p', get_string('questionname', 'local_helloworld'));

        $output .= html_writer::start_tag('form', array(
                'class' => 'form-inline',
                'method' => 'get',
                'action' => $url
        ));
            $output .= html_writer::start_div('form-group');
                $output .= html_writer::empty_tag('input', array(
                        'type' => 'text',
                        'class' => 'form-control mx-sm-3',
                        'name' => 'username',
                        'placeholder' => s(get_string('promptname', 'local_helloworld'))
                ));
                $output .= html_writer::tag('button', get_string('submit', 'core_moodle'), array(
                        'type' => 'submit',
                        'class' => 'btn btn-primary',
                ));
            $output .= html_writer::end_div();
        $output .= html_writer::end_tag('form');

        return $output;
    }

    /**
     * Generate html to display messages
     *
     * @return string html for displaying messages
     */
    private function display_messages() {
        global $DB;

        $output = '';

        $output .= $this->make_break();

        $output .= html_writer::start_div('card-columns');
            $messages = $DB->get_records('local_helloworld_messages');
            foreach ($messages as $message) {
                $now = new DateTime('now', core_date::get_server_timezone_object());
                $timediff = $now->getTimestamp() - $message->timecreated;
                $formatedtime = format_time($timediff);
                $lastupdated = get_string('lastupdated', 'local_helloworld', $formatedtime);

                $output .= $this->display_message($message->message, $lastupdated);
            }
        $output .= html_writer::end_div();

        return $output;
    }

    /**
     * Generate html to display one message
     *
     * @param string $message Content of the message
     * @param string $lastupdated Formated text displaying how long ago was the message created
     * @return string html for displaying one message
     */
    private function display_message(string $message, string $lastupdated) {
        $output = '';

        $output .= html_writer::start_div('card');
            $output .= html_writer::start_div('card-body');
                $output .= html_writer::tag('h5', 'FirstName LastName', array(
                        'class' => 'card-title'
                ));
                $output .= html_writer::tag('p', $message, array(
                        'class' => 'card-text'
                ));
                $output .= html_writer::start_tag('p', array(
                        'class' => 'card-text'
                ));
                    $output .= html_writer::tag('small', $lastupdated , array('class' => 'text-muted'));
                $output .= html_writer::end_tag('p');
            $output .= html_writer::end_div();
        $output .= html_writer::end_div();

        return $output;
    }

    /**
     * Generate html for footer that contain links
     *
     * @param string $url URL of index.php
     * @return string html for footer
     */
    private function footer($url) {
        $output = '';

        $output .= $this->make_break();

        $output .= html_writer::start_tag('ul');
            $output .= html_writer::start_tag('li');
                $output .= html_writer::link(new moodle_url('/'), get_string('backtohome', 'core_moodle'));
            $output .= html_writer::end_tag('li');
            $output .= html_writer::start_tag('li');
                $output .= html_writer::link($url, get_string('backtopageyouwereon', 'core_moodle'));
            $output .= html_writer::end_tag('li');
        $output .= html_writer::end_tag('ul');

        return $output;
    }

    /**
     * Generate html to make a brake between two HTML elements
     *
     * @return string html with break-lines and horizontal-line
     */
    private function make_break() {
        $output = '';

        $output .= html_writer::empty_tag('br');
        $output .= html_writer::empty_tag('hr');
        $output .= html_writer::empty_tag('br');

        return $output;
    }
}