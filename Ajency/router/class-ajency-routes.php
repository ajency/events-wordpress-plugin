<?php

class Ajency_Routes {

    protected $router;

    public function __construct()
    {
        global $ajency_router;

        $this->router  = $ajency_router;

        $this->register_routes();
    }

    public function register_protected_routes()
    {
        $this->router->get( array(
            'as'   => 'getTest',
            'uri'  => 'test/{id}',
            'uses' => array( $this, 'get' )
        ) );
    }

    protected function register_routes()
    {

        /*$this->router->group( array(
            'prefix' => '/ajency-events',
            'middlewares' => array( 'Middleware_One' ),
            'uses' => array( $this, 'register_protected_routes' )
        ) );*/

        $this->router->get( array(
            'as'   => 'simpleRoute',
            'uri'  => '/simple',
            'uses' => function()
            {
                return 'Hello World';
            }
            ) );

        $this->router->get( array(
            'as'   => 'getTest',
            'uri'  => 'test/{id}',
            //'uses' => array( $this, 'get' )
            'uses' => function($id)
            {
                return "User: {$id}";
            }
        ) );

        $this->router->post( array(
            'as'   => 'postTest',
            'uri'  => '/test/{id}',
            'uses' => array( $this, 'post' ),
            'prefix' => ''
        ) );

        $this->router->put( array(
            'as'   => 'putTest',
            'uri'  => '/test/{id}',
            'uses' => array( $this, 'put' )
        ) );
    }

    public function get($id, Ajency_Request $request)
    {
        $all = $request->all();

        return new Ajency_JSON_Response($all);
    }

    public function post($id)
    {
        return 'POST: The ID is ' . $id;
    }

    public function put($id)
    {
        return 'PUT: The ID is ' . $id;
    }

}