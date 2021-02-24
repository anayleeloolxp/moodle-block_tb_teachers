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
 * Content Box block
 *
 * @package    block_tb_teachers
 * @copyright  2020 Leeloo LXP (https://leeloolxp.com)
 * @author     Leeloo LXP <info@leeloolxp.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/**
 * This block simply outputs the Teachers.
 *
 * @copyright  2020 Leeloo LXP (https://leeloolxp.com)
 * @author     Leeloo LXP <info@leeloolxp.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_tb_teachers extends block_base {

    /**
     * Initialize.
     *
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_tb_teachers');
    }

    /**
     * Return contents of tb_teachers block
     *
     * @return stdClass contents of block
     */
    public function get_content() {

        global $CFG;

        if ($this->content !== null) {
            return $this->content;
        }

        $leeloolxplicense = get_config('block_tb_teachers')->license;
        $settingsjson = get_config('block_tb_teachers')->settingsjson;

        $resposedata = json_decode(base64_decode($settingsjson));
        $mdata = $resposedata->data->instructors_settings;

        if (empty($resposedata->data->block_title)) {
            $resposedata->data->block_title = get_string('displayname', 'block_tb_teachers');
        }
        $this->title = $resposedata->data->block_title;
        $autoslide = @$resposedata->data->autoslide;

        $this->page->requires->js(new moodle_url($CFG->wwwroot . '/blocks/tb_teachers/js/jquery.min.js'));
        $this->page->requires->js(new moodle_url($CFG->wwwroot . '/blocks/tb_teachers/js/owl.carousel.js'));
        if ($autoslide == 1) {
            $this->page->requires->js(new moodle_url($CFG->wwwroot . '/blocks/tb_teachers/js/owlslider-auto.js'));
        } else {
            $this->page->requires->js(new moodle_url($CFG->wwwroot . '/blocks/tb_teachers/js/owlslider.js'));
        }

        $this->page->requires->css(new moodle_url($CFG->wwwroot . '/blocks/tb_teachers/css/owl.carousel.min.css'));
        $this->page->requires->css(new moodle_url($CFG->wwwroot . '/blocks/tb_teachers/css/owl.theme.default.min.css'));

        $this->content = new stdClass();
        $this->content->text = '<div class="tb_teachers owl-carousel owl-theme">';

        foreach ($mdata as $mdatasing) {
            $this->content->text .= '<div id="teachers_box" class="teachers_box">';

            $this->content->text .= '<div class="teachers_img">';
            $this->content->text .= '<img src="' . $mdatasing->image . '"/>';
            $this->content->text .= '</div>';

            $this->content->text .= '<div class="teachers_title">';
            $this->content->text .= $mdatasing->instructor_name;
            $this->content->text .= '</div>';

            $this->content->text .= '<div class="teachers_pos">';
            $this->content->text .= $mdatasing->instructor_position;
            $this->content->text .= '</div>';

            $this->content->text .= '<div class="teachers_des">';
            $this->content->text .= $mdatasing->description;
            $this->content->text .= '</div>';

            $this->content->text .= '</div>';
        }

        $this->content->text .= '</div>';

        $this->content->footer = '';

        return $this->content;
    }

    /**
     * Allow the block to have a configuration page
     *
     * @return boolean
     */
    public function has_config() {
        return true;
    }

    /**
     * Locations where block can be displayed
     *
     * @return array
     */
    public function applicable_formats() {
        return array('all' => true);
    }

    /**
     * Get settings from Leeloo
     */
    public function cron() {
        require_once($CFG->dirroot . '/blocks/tb_teachers/lib.php');
        updateconfteachers();
    }
}
