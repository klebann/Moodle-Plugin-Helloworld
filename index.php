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

$username = optional_param('username', null, PARAM_ALPHA);
$validusername = isset($username) && !empty($username);
if ($validusername) {
    $heading = get_string('hellouser', 'local_helloworld', $username);
} else {
    $worldname = get_string('world', 'local_helloworld');
    $heading = get_string('hellouser', 'local_helloworld', $worldname);
}

$PAGE->set_url(new moodle_url('/local/helloworld/index.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('pluginname', 'local_helloworld'));
$PAGE->set_heading($heading);
$PAGE->set_pagelayout('standard');

echo $OUTPUT->header();

echo '<div>';
if ($validusername) {
    echo '<ul>';
    echo '<li><a href="' . new moodle_url('/') . '">' . get_string('backtohome', 'core_moodle') . '</a></li>';
    echo '<li><a href="' . $PAGE->url . '">' . get_string('backtopageyouwereon', 'core_moodle') . '</a></li>';
    echo '</ul>';
} else {
    $promptname = get_string('promptname', 'local_helloworld');

    echo '<p>' . get_string('questionname', 'local_helloworld') . '</p>';
    echo '<form class="form-inline" method="get" action="'.$PAGE->url.'">';
    echo '  <div class="form-group">';
    echo '      <input type="text" class="form-control mx-sm-3" name="username" placeholder="' . s($promptname) . '">';
    echo '      <input type="submit" class="btn btn-primary" value="' . get_string('submit', 'core_moodle') . '">';
    echo '  </div>';
    echo '</form>';
}
echo '</div>';

echo $OUTPUT->footer();