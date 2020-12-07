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
 * Granual control of who can do what
 *
 * @package    local_helloworld
 * @copyright  2020 Jakub Kleban <jakub.kleban2000@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// TODO: add showplugin capability for guest.
/*
    In the next section we will see how to implement more granular control of who
    can do what in the plugin. Experiment with setting up capabilities in a way that
    allows you to control guest users read access via Guest role capabilities, rather
    than preventing them from accessing the page.
*/

$capabilities = array(

    'local/helloworld:viewmessages' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'manager'        => CAP_ALLOW,
            'coursecreator'  => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'teacher'        => CAP_ALLOW,
            'student'        => CAP_ALLOW,
            'guest'          => CAP_ALLOW,
            'user'           => CAP_ALLOW
        )
    ),

    'local/helloworld:postmessages' => array(
        'captype' => 'write',
        'contextlevel' => RISK_SPAM,
        'archetypes' => array(
            'manager'           => CAP_ALLOW,
            'editingteacher'    => CAP_ALLOW,
            'teacher'           => CAP_ALLOW,
            'student'           => CAP_ALLOW,
            'user'              =>  CAP_ALLOW
        )
    ),

    'local/helloworld:deleteanymessage' => array(
        'captype' => 'write',
        'contextlevel' => RISK_DATALOSS,
        'archetypes' => array(
            'manager' => CAP_ALLOW
        )
    ),

);