<?php
/**
 * LandingPageController.php
 *
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 * @package dates services
 */

namespace Telemetry\controllers;

class SignupPageController
{

    public function createHtmlOutput(object $container, object $request, object $response): void
    {
        $homepage_view = $container->get('signupPageView');
        $view = $container->get('view');
        $settings = $container->get('settings');

        $homepage_view->createSignupView($view, $settings, $response);
    }
}