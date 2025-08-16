<?php echo $OUTPUT->main_content();
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

defined('MOODLE_INTERNAL') || die();

// // Get the HTML for the frontpage.
// $bodyattributes = $OUTPUT->body_attributes();
$templatecontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    'bodyattributes' => $bodyattributes,
    // 'hasdrawer' => true,
    // 'draweropen' => false,
    // 'regionmainsettingsmenu' => $regionmainsettingsmenu,
    // 'hasregionmainsettingsmenu' => !empty($regionmainsettingsmenu),
    // 'isloggedin' => isloggedin(),
    // 'isguestuser' => isguestuser(),
    // 'loginurl' => get_login_url(),
    // 'signupurl' => new moodle_url('/login/signup.php'),
    // 'sitenews' => '',
    // 'faq' => [],
    // 'carousel_slides' => []
];

// // Add site news if available
// // if ($SITE->newsitems) {
// //     require_once($CFG->dirroot .'/mod/forum/lib.php');
// //     if (($newsforum = forum_get_course_forum($SITE->id, 'news'))) {
// //         $newsforumcm = get_fast_modinfo($SITE)->instances['forum'][$newsforum->id];
// //         // For now, we'll just show a simple message about news availability
// //         $templatecontext['sitenews'] = '<p>Site announcements and news are available. Please log in to view the latest updates.</p>';
// //     }
// // }

// // Add FAQ items (placeholder for now)
// $templatecontext['faq'] = [
//     ['question' => 'How do I create an account?', 'link' => '#'],
//     ['question' => 'How do I enroll in a course?', 'link' => '#'],
//     ['question' => 'How do I access my courses?', 'link' => '#'],
//     ['question' => 'How do I contact support?', 'link' => '#']
// ];

// // Add carousel slides (placeholder for now)
// $templatecontext['carousel_slides'] = [
//     ['title' => 'Welcome to UVLE', 'description' => 'Your virtual learning environment', 'image' => ''],
//     ['title' => 'Start Learning', 'description' => 'Explore our courses and begin your journey', 'image' => '']
// ];

echo $OUTPUT->render_from_template('theme_boost/frontpage', $templatecontext);
