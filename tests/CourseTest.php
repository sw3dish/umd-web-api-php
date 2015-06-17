<?php
use \UMDWebAPI;

class CourseTest extends PHPUnit_Framework_TestCase
{
	private function setupMock($fixture = 200)
    {
        if (is_int($fixture)) {
            $return = array(
                'status' => $fixture
            );
        } else {
            $fixture = __DIR__ . '/fixtures/course/' . $fixture . '.json';
            $fixture = file_get_contents($fixture);

            $response = json_decode($fixture);
            $return = array(
                'body' => $response
            );
        }
        $request = $this->getMock('UMDWebAPI\Request');
        $request->method('api')
                ->willReturn($return);
        $api = new UMDWebAPI\Course($request);
        return $api;
    }

	public function testGetAllCourses()
	{
		$api = $this->setupMock('all-courses');
    	$response = $api->getAllCourses();

    	$this->assertNotEmpty($response);
    	$this->assertObjectHasAttribute('course_id', $response[0]);
	}

	public function testGetAllCoursesWithParams()
	{
		/*$api = $this->setupMock('all-courses-with-params');
    	$response = $api->getAllCourses(array(
    		"semester" => array(
    			"value" => "201508",
    			"comparison" => "="
    		),
    		"page" => array(
    			"value" => "2",
    			"comparison" => "="
    		),
    		"per_page" => array(
    			"value" => "50",
    			"comparison" => "="
    		)
    	));

    	$this->assertObjectHasAttribute('course_id', $response[0]);*/
	}

	public function testGetCoursesSingle()
	{
		$api = $this->setupMock('courses-single');
    	$response = $api->getCourses('ENES100');

    	$this->assertObjectHasAttribute('course_id', $response);
	}

	public function testGetCoursesMultiple()
	{
		$api = $this->setupMock('courses-multiple');
    	$response = $api->getCourses(array('ENES100', 'HEIP143'));

    	$this->assertObjectHasAttribute('course_id', $response[0]);
    	$this->assertObjectHasAttribute('course_id', $response[1]);
	}

	public function testSearchCoursesWithParams()
	{

	}

	public function testGetAllSections()
	{
		$api = $this->setupMock('all-sections');
    	$response = $api->getAllSections();

    	$this->assertNotEmpty($response);
    	$this->assertObjectHasAttribute('section_id', $response[0]);
	}

	public function testGetAllSectionsWithParams()
	{

	}

	public function testGetSectionsSingle()
	{
		$api = $this->setupMock('sections-single');
    	$response = $api->getSections('ENGL101-0101');

    	$this->assertObjectHasAttribute('section_id', $response);
	}

	public function testGetSectionsMultiple()
	{
		$api = $this->setupMock('sections-multiple');
    	$response = $api->getSections(array('ENGL101-0101', 'ENGL101-0102'));

    	$this->assertObjectHasAttribute('section_id', $response[0]);
    	$this->assertObjectHasAttribute('section_id', $response[1]);
	}

	public function testSearchSectionsWithParams()
	{

	}

	public function testGetAllDepartments()
	{
		$api = $this->setupMock('all-departments');
    	$response = $api->getAllDepartments();

    	$this->assertNotEmpty($response);
	}
}
