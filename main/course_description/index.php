<?php
/* For licensing terms, see /dokeos_license.txt */

/**
* Template (front controller in MVC pattern) used for distpaching to the controllers depend on the current action  
* @package dokeos.course_description
* @author Christian Fasanando <christian1827@gmail.com>
*/

// name of the language file that needs to be included
$language_file = array ('course_description', 'pedaSuggest', 'accessibility');

// including files 
require_once '../inc/global.inc.php';

require_once api_get_path(LIBRARY_PATH).'course_description.lib.php';
require_once api_get_path(LIBRARY_PATH).'app_view.php';
require_once api_get_path(LIBRARY_PATH).'app_controller.php';
require_once 'course_description_controller.php';
require_once api_get_path(LIBRARY_PATH).'formvalidator/FormValidator.class.php';
require_once api_get_path(LIBRARY_PATH).'WCAG/WCAG_rendering.php';

// defining constants
define('ADD_BLOCK', 9);
define('THEMATIC_ADVANCE', 8);

// current section
$this_section = SECTION_COURSES;

api_protect_course_script(true);

// get actions
$actions = array('listing', 'add', 'edit', 'delete', 'history');
$action = 'listing';
if (isset($_GET['action']) && in_array($_GET['action'],$actions)) {
	$action = $_GET['action'];
}

$description_type = '';
if (isset($_GET['description_type'])) {
	$description_type = intval($_GET['description_type']);
}

// interbreadcrumb
$interbreadcrumb[] = array ("url" => "index.php", "name" => get_lang('CourseProgram'));
if(intval($description_type) == 1) $interbreadcrumb[] = array ("url" => "#", "name" => get_lang('GeneralDescription'));
if(intval($description_type) == 2) $interbreadcrumb[] = array ("url" => "#", "name" => get_lang('Objectives'));
if(intval($description_type) == 3) $interbreadcrumb[] = array ("url" => "#", "name" => get_lang('Topics'));
if(intval($description_type) == 4) $interbreadcrumb[] = array ("url" => "#", "name" => get_lang('Methodology'));
if(intval($description_type) == 5) $interbreadcrumb[] = array ("url" => "#", "name" => get_lang('CourseMaterial'));
if(intval($description_type) == 6) $interbreadcrumb[] = array ("url" => "#", "name" => get_lang('HumanAndTechnicalResources'));
if(intval($description_type) == 7) $interbreadcrumb[] = array ("url" => "#", "name" => get_lang('Assessment'));
if(intval($description_type) == 8) $interbreadcrumb[] = array ("url" => "#", "name" => get_lang('ThematicAdvance'));
if(intval($description_type) >= 9) $interbreadcrumb[] = array ("url" => "#", "name" => get_lang('Others'));

// course description controller object
$course_description_controller = new CourseDescriptionController();

// distpacher actions to controller
switch ($action) {	
	case 'listing':	
						$course_description_controller->listing();
						break;	
	case 'history':		
						$course_description_controller->listing(true);
						break;
	case 'add'	  :   
						if (api_is_allowed_to_edit(null,true)) {
							$course_description_controller->add();
						}
						break;
	case 'edit'	  :	
						if (api_is_allowed_to_edit(null,true)) {
							$course_description_controller->edit($description_type);
						}
						break;
	case 'delete' :	
						if (api_is_allowed_to_edit(null,true)) {
							$course_description_controller->destroy($description_type);
						}
						break;
	default		  :	
						$course_description_controller->listing();
}
?>