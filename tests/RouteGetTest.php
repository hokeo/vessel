<?php namespace Hokeo\Vessel;

use Mockery as m;

class RouteGetTest extends \Illuminate\Foundation\Testing\TestCase {

	use VesselTestTrait;

	protected $vessel_route_prefix;

	public function setUp()
	{
		parent::setUp();

		$this->vessel_route_prefix = $this->app['config']->get('vessel::vessel.uri', 'vessel');

		// $this->app['config']->set('database.connections.mysql.database', 'vessel_testing');
		// $this->app['config']->set('database.connections.mysql.username', 'root');
		// $this->app['config']->set('database.connections.mysql.password', 'root');
	}

    // Helpers

	public function getVesselRoutePath($path)
	{
		return '/'.$this->vessel_route_prefix.(($path == '/') ? '' : (($path[0] == '/') ? $path : '/'.$path));
	}

	public function doRouteTest($path, $under_vessel = true, $auth = true, $assert_response_ok = true)
	{
		if ($auth) $this->authenticate();
		$this->call('GET', (($under_vessel) ? $this->getVesselRoutePath($path) : $path));
		if ($assert_response_ok) $this->assertResponseOk();
	}

	// Tests

	public function testGetHome()
	{
		$this->doRouteTest('/');
	}
		
	public function testGetLogin()
	{
		$this->doRouteTest('login', true, false);
	}

	public function testGetLogout()
	{
		$this->doRouteTest('logout', true, true, false);
		$this->assertRedirectedToRoute('vessel');
	}

	public function testGetPages()
	{
		$this->doRouteTest('pages');
	}

	public function testGetPagesNew()
	{
		$this->doRouteTest('pages/new');
	}

	// public function testGetPagesEdit()
	// {
	// 	$this->doRouteTest('pages/edit');
	// }

}