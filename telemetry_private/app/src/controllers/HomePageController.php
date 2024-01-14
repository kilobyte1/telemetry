<?php
/**
 * HomePageController.php
 
 * @author Richard Kankam
 */

namespace Telemetry\controllers;

class HomePageController
{

    public function createHtmlOutput(object $container, object $request, object $response): void
    {
        $homepage_view = $container->get('homePageView');
        $view = $container->get('view');
        $settings = $container->get('settings');

        $homepage_view->createHomePageView($view, $settings, $response);


    }
}
