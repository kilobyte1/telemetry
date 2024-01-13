<?php
/**
 * HomePageController.php
 *
 * Controller for the home page of the telemetry application.
 * Handles the creation of HTML output for the home page.
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 * @package Telemetry
 */

namespace Telemetry\controllers;

/**
 * Controller for handling the homepage view.
 */
class HomePageController
{
    /**
     * Creates HTML output for the homepage.
     *
     * @param object $container Dependency injection container.
     * @param object $request HTTP request object.
     * @param object $response HTTP response object.
     *
     * @return void
     */

    public function createHtmlOutput(object $container, object $request, object $response): void
    {
        // Retrieve homepage view, view renderer, and settings from the container
        $homepage_view = $container->get('homePageView');
        $view = $container->get('view');
        $settings = $container->get('settings');

        // Generate and render the home page view
        $homepage_view->createHomePageView($view, $settings, $response);


    }
}
