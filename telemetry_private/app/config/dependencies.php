<?php

declare (strict_types = 1);

use DI\Container;
use Slim\App;
use Slim\Views\Twig;
use Telemetry\controllers\SignupPageController;
use Telemetry\controllers\SmsPageController;
use Telemetry\controllers\submitFormController;
use Telemetry\Views\DisplayMessageView;
use Telemetry\views\HomePageView;
use Telemetry\Views\LoginView;
use Telemetry\views\SignupPageView;
use Telemetry\views\smsPageView;
use Telemetry\views\submitFormView;

// Register components in a container

return function (Container $container, App $app) {
    $settings = $container->get('settings');
    $template_path = $settings['view']['template_path'];
    $cache_path = $settings['view']['cache_path'];

    $container->set(
        'view',
        function ()
        use ($template_path, $cache_path)
        {
            {
                return Twig::create($template_path, ['cache' => false]);
            }
        }
    );

    /**
     * Using Doctrine
     * @param $c
     * @return \Doctrine\ORM\EntityManager
     * @throws \Doctrine\ORM\Exception\ORMException
     */

    $container->set('em', function ($c) {
        $settings = $c->get('settings');
        $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
            $settings['doctrine']['meta']['entity_path'],
            $settings['doctrine']['meta']['auto_generate_proxies'],
            $settings['doctrine']['meta']['proxy_dir'],
            $settings['doctrine']['meta']['cache'],
            false
        );
        return \Doctrine\ORM\EntityManager::create($settings['doctrine']['connection'], $config);
    });

    $container->set('signupPageController', function () {
        $controller = new SignupPageController();
        return $controller;
    });

    $container->set('signupPageView', function () {
        $view = new SignupPageView();
        return $view;
    });
    $container->set('homePageView', function () {
        $view = new HomePageView();
        return $view;
    });

    $container->set('loginPageView', function () {
        $view = new LoginView();
        return $view;
    });
    $container->set('displayMessagePageView', function () {
        $view = new DisplayMessageView();
        return $view;
    });
    $container->set('loginPageController', function () {
        return new \Telemetry\controllers\LoginController();
    });
    $container->set('displayMessagePageController', function () {
        return new \Telemetry\controllers\DisplayMessageController();
    });

    $container->set('soapWrapper', function () use ($container) {
        $settings = $container->get('settings')['wsdl'];
        return new \Telemetry\support\SoapClientWrapper($settings);
    });



    $container->set('registerUserController', function () {
        return new \Telemetry\controllers\RegisterUserController();
    });
    $container->set('homePageController', function () {
        return new \Telemetry\controllers\HomePageController();
    });

    $container->set('registerUserModel', function () {
        return new \Telemetry\models\RegisterUserModel();
    });
    $container->set('smsPageModel', function () {
        return new \Telemetry\models\smsPageModel();
    });

    $container->set('loginModel', function () {
        return new \Telemetry\models\LoginModel();
    });
    $container->set('messageValidationModel', function () {
        return new \Telemetry\models\messagevalidationModel();
    });

    $container->set('registerUserView', function () {
        return new \Telemetry\views\RegisterUserView();
    });

    $container->set('validator', function () {
        $validator = new \Telemetry\Support\Validator();
        return $validator;
    });

    $container->set('libSodiumWrapper', function () {
        return new \Telemetry\Support\LibSodiumWrapper();
    });

    $container->set('base64Wrapper', function () {
        return new \Telemetry\Support\Base64Wrapper();
    });

    $container->set('bcryptWrapper', function () {
        return new \Telemetry\Support\BcryptWrapper();
    });

    $container->set('doctrineSqlQueries', function () {
        return new \Telemetry\Support\DoctrineSqlQueries();
    });


//    $container->set('signupPageModel', function () {
//        return new \Telemetry\models\SignupUserModel();
//    });

    $container->set('smsPageController', function () {
        $controller = new SmsPageController();
        return $controller;
    });

    $container->set('smsPageView', function () {
        $view = new SmsPageView();
        return $view;
    });

    $container->set('smsFormView', function(){
        $view = new submitFormView();
        return $view;
    });

    $container->set('submitFormController', function () {
        $controller = new submitFormController();
        return $controller;
    });


    $container->set('settings', function () use ($settings) {
        return $settings;
    });
    $container->set('m2m_service_url', function ($container) {
        return $container->get('settings')['m2m_service_url'];
    });

    $container->set('soapClientWrapper', function () {
        $wrapper = new \Telemetry\Support\SoapClientWrapper();
        return $wrapper;
    });
};