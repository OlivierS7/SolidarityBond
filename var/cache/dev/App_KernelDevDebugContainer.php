<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerMeLJYXz\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerMeLJYXz/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerMeLJYXz.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerMeLJYXz\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerMeLJYXz\App_KernelDevDebugContainer([
    'container.build_hash' => 'MeLJYXz',
    'container.build_id' => '0e3ca21c',
    'container.build_time' => 1593004359,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerMeLJYXz');
