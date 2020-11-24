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
 * @package    local_helloworld
 * @copyright  2020 Jakub Kleban <jakub.kleban2000@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/**
 * Renderer for displaying local_helloworld
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
            $output .= html_writer::start_tag('ul');

            $output .= html_writer::start_tag('li');
            $output .= html_writer::link(new moodle_url('/'), get_string('backtohome', 'core_moodle'));
            $output .= html_writer::end_tag('li');

            $output .= html_writer::start_tag('li');
            $output .= html_writer::link($url, get_string('backtopageyouwereon', 'core_moodle'));
            $output .= html_writer::end_tag('li');

            $output .= html_writer::end_tag('ul');
        } else {
            $output .= html_writer::tag('p', get_string('questionname', 'local_helloworld'));
            $output .= html_writer::start_tag('form', array(
                    'class' => 'form-inline',
                    'method' => 'get',
                    'action' => $url
            ));
            $output .= html_writer::start_div('form-group');
            $output .= html_writer::start_tag('input', array(
                    'type' => 'text',
                    'class' => 'form-control mx-sm-3',
                    'name' => 'username',
                    'placeholder' => s(get_string('promptname', 'local_helloworld'))
            ));
            $output .= html_writer::start_tag('input', array(
                    'type' => 'submit',
                    'class' => 'btn btn-primary',
                    'value' => get_string('submit', 'core_moodle')
            ));
            $output .= html_writer::end_div();
            $output .= html_writer::end_tag('form');
        }
        $output .= html_writer::end_div();

        return $output;
    }
}