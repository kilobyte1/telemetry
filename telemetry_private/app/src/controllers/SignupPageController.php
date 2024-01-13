<?php
/**
 * SignupPageController.php
 *
 * Controller for handling the display of the signup page.
 * Responsible for creating HTML output for the signup page, utilizing views and settings.
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 * @package Dates Services
 */

namespace Telemetry\controllers;

/**
 * Controller for the signup page.
 */
class SignupPageController
{
    /**
     * Creates HTML output for the signup page.
     *
     * @param object $container Dependency injection container.
     * @param object $request HTTP request object.
     * @param object $response HTTP response object.
     *
     * @return void
     */
    public function createHtmlOutput(object $container, object $request, object $response): void
    {
        // Retrieve the signup page view, view renderer, and settings from the container
        $homepage_view = $container->get('signupPageView');
        $view = $container->get('view');
        $settings = $container->get('settings');
        // Generate and render the signup page view
        $homepage_view->createSignupView($view, $settings, $response);
    }
}
