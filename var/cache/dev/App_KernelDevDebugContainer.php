<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerZ5iYH5i\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerZ5iYH5i/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerZ5iYH5i.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerZ5iYH5i\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerZ5iYH5i\App_KernelDevDebugContainer([
    'container.build_hash' => 'Z5iYH5i',
    'container.build_id' => 'd93a2175',
    'container.build_time' => 1591779851,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerZ5iYH5i');
