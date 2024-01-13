<?php
/**
 * SignupPageController.php
 *
 * @author Richard Kankam
 */

namespace Telemetry\controllers;

class SignupPageController
{

    public function createHtmlOutput(object $container, object $request, object $response): void
    {

        $signup_page_view = $container->get('signupPageView');
        $view = $container->get('view');
        $settings = $container->get('settings');

        $signup_page_view->createSignupPageView($view, $settings, $response);
    }
}
