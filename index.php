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
if (isset($username) && !empty($username)) {
    echo "<h1>". get_string('hello', 'local_helloworld', $username) ."</h1>";
    $frontpageurl = new moodle_url('/');
    $helloworldurl = new moodle_url('/local/helloworld/index.php');
    echo '<ul>';
    echo '<li><a href="' . $frontpageurl . '">' . get_string('backtohome', 'core_moodle') . '</a></li>';
    echo '<li><a href="' . $helloworldurl . '">' . get_string('backtopageyouwereon', 'core_moodle') . '</a></li>';
    echo '</ul>';
} else {
    echo
    "<h1>" . get_string('hello', 'local_helloworld', get_string('world', 'local_helloworld')) . "</h1>
    <p>" . get_string('questionname', 'local_helloworld') . "</p>
    <form method='GET'>
        <input type='text' name='username' placeholder='" . get_string('promptname', 'local_helloworld') . "'>
        <input type='submit' value='" . get_string('submit', 'core_moodle') . "'>
    </form>";
}