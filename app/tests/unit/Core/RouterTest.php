<?php namespace Core;

//use \Core\Router;

class RouterTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }


    public function testConvertToStudlyCaps()
    {
        $router = new Router();

        // simple input: post-author
        $this->assertEquals(
            'PostAuthor',
            $this->invokeMethod($router, 'convertToStudlyCaps', array('post-author'))
        );

        // extended input: post-author-test
        $this->assertEquals(
            'PostAuthorTest',
            $this->invokeMethod($router, 'convertToStudlyCaps', array('post-author-test'))
        );

        // one word input: post
        $this->assertEquals(
            'Post',
            $this->invokeMethod($router, 'convertToStudlyCaps', array('post'))
        );

        // mixed lower-upper case input: post-tEst
        $this->assertEquals(
            'PostTEst',
            $this->invokeMethod($router, 'convertToStudlyCaps', array('post-tEst'))
        );

        // mixed lower-upper-symbols
        $this->assertEquals(
            'Post_Test_I',
            $this->invokeMethod($router, 'convertToStudlyCaps', array('post_Test_I'))
        );
    }


    public function testConvertToCamelCase()
    {
        $router = new Router();

        // simple input: post-author
        $this->assertEquals(
            'postAuthor',
            $this->invokeMethod($router, 'convertToCamelCase', array('post-author'))
        );

        // extended input: post-author-test
        $this->assertEquals(
            'postAuthorTest',
            $this->invokeMethod($router, 'convertToCamelCase', array('post-author-test'))
        );

        // one word input: post
        $this->assertEquals(
            'post',
            $this->invokeMethod($router, 'convertToCamelCase', array('post'))
        );

        // mixed lower-upper case input: post-tEst
        $this->assertEquals(
            'postTEst',
            $this->invokeMethod($router, 'convertToCamelCase', array('post-tEst'))
        );

        // mixed lower-upper-symbols
        $this->assertEquals(
            'post_Test_I',
            $this->invokeMethod($router, 'convertToCamelCase', array('post_Test_I'))
        );

        // camel case
        $this->assertEquals(
            'testAction',
            $this->invokeMethod($router, 'convertToCamelCase', array('testAction'))
        );
    }


    public function testRemoveQueryStringVariables() {
        $router = new Router();

        $values = ['page=1', ''];
        $this->assertEquals(
            $values[1],
            $this->invokeMethod($router, 'removeQueryStringVariables', array($values[0]))
        );

        $values = ['posts&page=1', 'posts'];
        $this->assertEquals(
            $values[1],
            $this->invokeMethod($router, 'removeQueryStringVariables', array($values[0]))
        );

        $values = ['posts/index', 'posts/index'];
        $this->assertEquals(
            $values[1],
            $this->invokeMethod($router, 'removeQueryStringVariables', array($values[0]))
        );

        $values = ['posts/index&page=1', 'posts/index'];
        $this->assertEquals(
            $values[1],
            $this->invokeMethod($router, 'removeQueryStringVariables', array($values[0]))
        );

        $values = ['&page=1', ''];
        $this->assertEquals(
            $values[1],
            $this->invokeMethod($router, 'removeQueryStringVariables', array($values[0]))
        );

    }

    //  ----------   getNamespace()
    public function testGetNamespaceWhenValueSetProperlyOnParams() {

        $router = $this->make(Router::class, [
           'params' => [ 'namespace' => 'Admin']
        ]);

        $this->assertEquals(
            'App\\Controllers\\Admin\\',
            $this->invokeMethod($router, 'getNamespace', array())
        );

    }

    public function testGetNamespaceWhenValueSetToNullOnParams() {

        $router = $this->make(Router::class, [
            'params' => [ 'namespace' => null]
        ]);

        $this->assertEquals(
            'App\\Controllers\\',
            $this->invokeMethod($router, 'getNamespace', array())
        );

    }

    public function testGetNamespaceWhenNamespaceNotSetOnParams() {

        $router = $this->make(Router::class, [
            'params' => [ ]
        ]);

        $this->assertEquals(
            'App\\Controllers\\',
            $this->invokeMethod($router, 'getNamespace', array())
        );

    }

    // -------- getParams()
    public function testGetParams() {

        $params = ['dummy'];
        $router = $this->make(Router::class, [
            'params' => $params
        ]);

        $this->assertEquals(
            $params,
            $this->invokeMethod($router, 'getParams', array())
        );
    }

    // -------- getRoutes()
    public function testGetRoutes() {

        $routes = ['dummy'];
        $router = $this->make(Router::class, [
            'routes' => $routes
        ]);

        $this->assertEquals(
            $routes,
            $this->invokeMethod($router, 'getRoutes', array())
        );
    }

    public function testTempTest() {
        $router = $this->make(Router::class, [ 'getParams' => 'ssssss' ]);
    }

    // HELPER FUNCTIONS
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }


}