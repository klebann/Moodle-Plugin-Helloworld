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
 * Add navigations
 *
 * @package    local_helloworld
 * @copyright  2020 Jakub Kleban <jakub.kleban2000@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/**
 * Insert a link to index.php on the site front page navigation menu.
 *
 * @param navigation_node $frontpage Node representing the front page in the navigation tree.
 */
function local_helloworld_extend_navigation_frontpage(navigation_node $frontpage) {

    $frontpage->add(
            get_string('pluginname', 'local_helloworld'),
            new moodle_url('/local/helloworld/index.php'),
            navigation_node::TYPE_CUSTOM,
            null,
            null,
            new pix_icon('share', '', 'local_helloworld')
    );
}

/**
 * Add link to index.php into navigation drawer.
 *
 * @param global_navigation $root Node representing the global navigation tree.
 */
function local_helloworld_extend_navigation(global_navigation $root) {
    $showinnavigation = get_config('local_helloworld', 'showinnavigation');
    $showinflatnavigation = get_config('local_helloworld', 'showinflatnavigation');
    if ($showinnavigation || $showinflatnavigation) {
        $node = navigation_node::create(
                get_string('sayhello', 'local_helloworld'),
                new moodle_url('/local/helloworld/index.php'),
                navigation_node::TYPE_CUSTOM,
                null,
                null,
                new pix_icon('t/message', '')
        );

        if ($showinflatnavigation) {
            $node->showinflatnavigation = true;
        }

        $root->add_node($node);
    }
}