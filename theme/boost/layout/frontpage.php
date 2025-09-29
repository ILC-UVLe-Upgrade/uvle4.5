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

require_once($CFG->libdir . '/behat/lib.php');

// Site news functionality from Moodle 3.9 homepage.php
function frontpage_part($skipdivid, $contentsdivid, $header, $contents) {
    if (strval($contents) === '') {
        return '';
    }

    $output = $contents;

    return $output;
}

function frontpage_news($forum) {
    global $CFG, $SITE, $SESSION, $USER;
    require_once($CFG->dirroot .'/mod/forum/lib.php');

    $output = '';

    $coursemodule = get_coursemodule_from_instance('forum', $forum->id);
    $context = context_module::instance($coursemodule->id);

    $entityfactory = mod_forum\local\container::get_entity_factory();
    $forumentity = $entityfactory->get_forum_from_stdclass($forum, $context, $coursemodule, $SITE);

    $rendererfactory = mod_forum\local\container::get_renderer_factory();
    $discussionsrenderer = $rendererfactory->get_frontpage_news_discussion_list_renderer($forumentity);
    $cm = \cm_info::create($coursemodule);

    return $output . $discussionsrenderer->render($USER, $cm, null, null, 0, $SITE->newsitems);
}

// Process site news
$sitenews = '';
require_once($CFG->dirroot .'/mod/forum/lib.php');
if (($newsforum = forum_get_course_forum($SITE->id, 'news')) &&
($forumcontents = frontpage_news($newsforum))) {
    $newsforumcm = get_fast_modinfo($SITE)->instances['forum'][$newsforum->id];
    $sitenews = frontpage_part('skipsitenews', 'site-news-forum', $newsforumcm->get_formatted_name(), $forumcontents);
}

// Add block button in editing mode.
$addblockbutton = $OUTPUT->addblockbutton();

$extraclasses = [];
$bodyattributes = $OUTPUT->body_attributes($extraclasses);
$blockshtml = $OUTPUT->blocks('side-pre');
$hasblocks = (strpos($blockshtml, 'data-block=') !== false || !empty($addblockbutton));

$secondarynavigation = false;
$overflow = '';
if ($PAGE->has_secondary_navigation()) {
    $tablistnav = $PAGE->has_tablist_secondary_navigation();
    $moremenu = new \core\navigation\output\more_menu($PAGE->secondarynav, 'nav-tabs', true, $tablistnav);
    $secondarynavigation = $moremenu->export_for_template($OUTPUT);
    $overflowdata = $PAGE->secondarynav->get_overflow_menu_data();
    if (!is_null($overflowdata)) {
        $overflow = $overflowdata->export_for_template($OUTPUT);
    }
}

$primary = new core\navigation\output\primary($PAGE);
$renderer = $PAGE->get_renderer('core');
$primarymenu = $primary->export_for_template($renderer);
$buildregionmainsettings = !$PAGE->include_region_main_settings_in_header_actions()  && !$PAGE->has_secondary_navigation();
// If the settings menu will be included in the header then don't add it here.
$regionmainsettingsmenu = $buildregionmainsettings ? $OUTPUT->region_main_settings_menu() : false;

$header = $PAGE->activityheader;
$headercontent = $header->export_for_template($renderer);

// Add carousel slides
function carousel_slides() {
    global $PAGE;
    $theme = $PAGE->theme;

    $carousel_slides = "";
    for ($idx = 1; $idx <= 3; $idx++) {
        $idx_stringified = strval($idx);
        $setting_name = "carouselimage" . strval($idx);
        $link_setting_name = $setting_name . "_link";

        // Retrieve settings
        $link = isset($theme->settings->{$link_setting_name}) ? $theme->settings->{$link_setting_name} : "";
        $file_location = $theme->setting_file_url($setting_name, $setting_name);
        $active = $idx == 1 ? "active" : "";

        // Build HTML
        if ($file_location != NULL) {
            $carousel_slides .= "<div class='carousel-item " . $active . "' target='_blank'>" .
                "<a href='" . $link . "'>" .
                    "<img id='homepage-carousel-image-". $idx_stringified ."' class='d-block w-100'>" .
                "</a>". 
            "</div>";
        }
    }

    return $carousel_slides;
}

$templatecontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    'sidepreblocks' => $blockshtml,
    'hasblocks' => $hasblocks,
    // 'bodyattributes' => $bodyattributes,
    // 'primarymoremenu' => $primarymenu['moremenu'],
    // 'secondarymoremenu' => $secondarynavigation ?: false,
    // 'mobileprimarynav' => $primarymenu['mobileprimarynav'],
    'usermenu' => $primarymenu['user'],
    'langmenu' => $primarymenu['lang'],
    'regionmainsettingsmenu' => $regionmainsettingsmenu,
    'hasregionmainsettingsmenu' => !empty($regionmainsettingsmenu),
    'headercontent' => $headercontent,
    'overflow' => $overflow,
    'addblockbutton' => $addblockbutton,
    'sitenews' => $sitenews,
    'loginurl' => get_login_url(),
    'isloggedin' => isloggedin(),

    'carousel_slides' => carousel_slides(),
];

echo $OUTPUT->render_from_template('theme_boost/frontpage', $templatecontext);
