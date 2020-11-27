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
 * Upgrade code for install
 *
 * @package    local_helloworld
 * @copyright  2020 Jakub Kleban <jakub.kleban2000@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * upgrade this assignment instance - this function could be skipped but it will be needed later
 * @param int $oldversion The old version of the assign module
 * @return bool
 */
function xmldb_local_helloworld_upgrade($oldversion){
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2020112700) {

        // Define field userid to be added to local_helloworld_messages.
        $table = new xmldb_table('local_helloworld_messages');
        $field = new xmldb_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '1', 'id');

        // Define key userid (foreign) to be added to local_helloworld_messages.
        $key = new xmldb_key('userid', XMLDB_KEY_FOREIGN, ['userid'], 'user', ['id']);

        // Conditionally launch add field userid.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);

            // Launch add key userid.
            $dbman->add_key($table, $key);
        }

        // Helloworld savepoint reached.
        upgrade_plugin_savepoint(true, 2020112700, 'local', 'helloworld');
    }

    return true;
}