<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerHsiLZky\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerHsiLZky/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerHsiLZky.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerHsiLZky\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \ContainerHsiLZky\srcApp_KernelDevDebugContainer([
    'container.build_hash' => 'HsiLZky',
    'container.build_id' => '53d0e6ba',
    'container.build_time' => 1564690750,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerHsiLZky');
