<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Stylist.php";
    require_once __DIR__."/../src/Client.php";

    //Start Silex app
    $app = new Silex\Application();
    $app[debug] = true;

    $server = 'mysql:host=localhost:8889;dbname=hair_salon';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    //Twig Paths
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    // Get Calls
    $app->get("/", function() use($app) {

        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    //Stylists getId
    $app->get("/stylists/{id}", function($id) use ($app) {
        $stylist = Stylist::find($id);

        return $app['twig']->render('stylist.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

    //Stylists getId/edit
    $app->get("/stylists/{id}/edit", function($id) use ($app) {
        $stylist = Stylist::find($id);

        return $app['twig']->render('stylist_edit.html.twig', array('stylist' => $stylist));
    });

    $app->get("/clients/{id}/edit", function($id) use ($app) {
        $client = Client::find($id);

        return $app['twig']->render('client_edit.html.twig', array('client' => $client));
    });

    //Patch Calls
    $app->patch("/stylists/{id}", function($id) use ($app) {
        $name_stylist = $_POST['stylist_name'];
        $stylist = Stylist::find($id);
        $stylist->update($name_stylist);

        return $app['twig']->render('stylist.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

    $app->patch("/clients/{id}", function($id) use ($app) {
        $name_client = $_POST['name'];
        $client = Client::find($id);
        $client->update($name_client);

        $stylist_id = $client->getStylistId();
        $stylist = Stylist::find($stylist_id);

        return $app['twig']->render('stylist.html.twig', array('stylist' => $stylist,'clients' => $stylist->getClients()));
    });

    //Post Calls
    //Client Post Calls
    $app->post("/clients", function() use ($app) {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $stylist_id = $_POST['stylist_id'];
        $client = new Client($name, $phone, $stylist_id, $id = null);
        $client->save();

        $stylist = Stylist::find($stylist_id);

        return $app['twig']->render('stylist.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });


    //Stylist Post Calls
    $app->post("/stylists", function() use ($app) {
        $stylist = new Stylist($_POST['stylist_name']);
        $stylist->save();

        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    //Delete Calls
    //Client Delete Call
    $app->post("/delete_clients", function() use ($app) {
        Client::deleteAll();

        return $app['twig']->render('delete_clients.html.twig');
    });

    //Stylist Delete All Call
    $app->post("/delete_stylists", function() use ($app) {
        Stylist::deleteAll();

        return $app['twig']->render('delete_stylists.html.twig');
    });

    //Stylist Delete Single Call
    $app->delete("/stylists/{id}", function($id) use ($app) {
    $stylist = Stylist::find($id);
    $stylist->delete();
    return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    //Client delete single call
    $app->delete("/clients/{id}", function($id) use ($app) {
    $client = Client::find($id);
    $client->delete();
    return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    return $app;

 ?>
