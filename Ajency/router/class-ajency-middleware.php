<?php

abstract class Ajency_Middleware {

	/**
	 * @var WP_Router
	 */
	protected $router;

	/**
	 * @var array
	 */
	protected $store;

	/**
	 * Called by WP_Router to run Middleware.
	 *
	 * @param  WP_Request
	 * @param  WP_Router
	 * @param  array
	 * @return mixed
	 */
	public function run( Ajency_Request $request, Ajency_Router $router, $store )
	{
		$this->router = $router;
		$this->store  = $store;

		return $this->handle( $request );
	}

	/**
	 * Calls the next Middleware.
	 *
	 * @param  WP_Request
	 * @return void
	 */
	public function next( Ajency_Request $request )
	{
		$this->router->next( $request, $this->router, $this->store );
	}

	/**
	 * Method to be implemented by each Middleware.
	 *
	 * @param  WP_Request
	 * @return mixed
	 */
	abstract function handle( Ajency_Request $request );
}
