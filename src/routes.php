<?php

use \Psr\Http\Message\ServerRequestInterface as CurrentRequest;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/api-service', function ($request, $response) {

    // Sample log message
    $this->logger->info(" route: '/api-service' ");

    // Render index view
    return $this->renderer->render($response, 'api-service.phtml');
});


$app->get('/api/mindicador[/{codigo}]', function (CurrentRequest $request, Response $response) {
    $apiUrl  = '';
    $apiUrl .= 'http://www.mindicador.cl/api';
    if($codigo = $request->getAttribute('codigo')):
        $apiUrl .= '/'.$codigo;//$args['codigo']
       
    endif;
    //Es necesario tener habilitada la directiva allow_url_fopen para usar file_get_contents
    if ( ini_get('allow_url_fopen') ) {
        $json = file_get_contents($apiUrl);
    } else {
        //De otra forma utilizamos cURL
        $curl = curl_init($apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($curl);
        curl_close($curl);
    }
    $dailyIndicators = json_decode($json);
    return $response->withJson($dailyIndicators,200);//201 Created | 200 OK
});


$app->get('/', function ($request, $response, $args) {

    if($this->has('myService')) {
        $myService = $this->myService;
    }
    $this->logger->info("Mi servicio: ".$myService);
    return $this->renderer->render($response, 'index.phtml', $args);
});
/**/

$app->get('/middleware', function ($request, $response, $args) {
    $response->getBody()->write(' Hello ');
    return $response;
})->add($mimiddleware_testing);


$app->get('/desarrollo-web', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("ChileNetwork: Desarrllo Web '/desarrollo-web' route");

    // Render index view
    return $this->renderer->render($response, 'desarrollo-web.phtml', $args);
})->add( new ExampleMiddleware() );

$app->post('/api/callback/paypal_ipn_chilenetwork', function ($request, $response, $args) {
    // Create new book
    $this->logger->info("ChileNetwork: paypal IPN '/api/callback' route");
});

$app->group('/blog', function () use ($app) {
    
    $app->get('/amazon-web-services', function ($request, $response) {
       
        return $this->renderer->render($response, 'blog/amazon-web-services.phtml');
    });


    $app->get('/time', function ($request, $response) {
        $foo = $request->getAttribute('usuario');
        return $response->getBody()->write($foo);//time()
    });


})->add(function ($request, $response, $next) {
    $request = $request->withAttribute('usuario', 'Mario Soto');
    $response->getBody()->write('It is now ');
    $response = $next($request, $response);
    $response->getBody()->write('. Enjoy!');
    return $response;
});

/*

$app->group('/api', function () {

    $this->group('/auth', function() {
        $this->map(['GET','POST'], '/login/', 'App\controllers\AuthController:login');
        $this->map(['GET','POST'], '/logout/', 'App\controllers\AuthController:logout');
    });

    $this->group('/callback', function() {
        $this->map(['GET'], '/login/', 'App\controllers\DataController:getData');
        
        $this->map(['POST'], '/paypal_ipn_chilenetwork', 'App\controllers\DataController:setData');

        $this->map(['GET'], '/login/', 'App\controllers\DataController:getSubData');
    });

});
*/
?>