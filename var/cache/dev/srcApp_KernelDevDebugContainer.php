<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerDQ43CUz\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerDQ43CUz/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerDQ43CUz.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerDQ43CUz\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \ContainerDQ43CUz\srcApp_KernelDevDebugContainer([
    'container.build_hash' => 'DQ43CUz',
    'container.build_id' => '9540ddf1',
    'container.build_time' => 1564924857,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerDQ43CUz');
