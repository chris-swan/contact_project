<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/contact.php";

    session_start();

    if (empty($_SESSION['list_of_contacts'])) {
        $_SESSION['list_of_contacts'] = array();
    }

    $app = new Silex\Application();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {

        return $app['twig']->render('contacts.html.twig', array('contacts' => Contact::getAll()));

    });
//this one goes to the create tasks twig
    $app->post("/contacts", function() use ($app) {
        $task = new Contact($_POST['description']);
        $task->save();
        return $app['twig']->render('create_contact.html.twig', array('newcontact' => $task));
    });
//This one routes to the delete tasks twig
    $app->post("/delete_contacts", function() use ($app) {
        Contact::deleteAll();
        return $app['twig']->render('delete_contacts.html.twig');
    });

    return $app;
?>
