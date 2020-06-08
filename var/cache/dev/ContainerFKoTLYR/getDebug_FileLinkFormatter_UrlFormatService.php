<?php

namespace ContainerFKoTLYR;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getDebug_FileLinkFormatter_UrlFormatService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'debug.file_link_formatter.url_format' shared service.
     *
     * @return \string
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['debug.file_link_formatter.url_format'] = \Symfony\Component\HttpKernel\Debug\FileLinkFormatter::generateUrlFormat(($container->services['router'] ?? $container->getRouterService()), '_profiler_open_file', '?file=%f&line=%l#line%l');
    }
}
