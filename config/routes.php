<?php

use App\Controller\RegisterAction;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes): void {
    $routes->add('blog_list', '/blog')
        // the controller value has the format [controller_class, method_name]
        ->controller([RegisterAction::class, 'register'])

        // if the action is implemented as the __invoke() method of the
        // controller class, you can skip the 'method_name' part:
        // ->controller(BlogController::class)
    ;
};