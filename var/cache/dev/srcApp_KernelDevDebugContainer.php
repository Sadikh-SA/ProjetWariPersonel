<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\Container2L1yxl4\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/Container2L1yxl4/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/Container2L1yxl4.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\Container2L1yxl4\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \Container2L1yxl4\srcApp_KernelDevDebugContainer([
    'container.build_hash' => '2L1yxl4',
    'container.build_id' => '4addbdf2',
    'container.build_time' => 1564661199,
], __DIR__.\DIRECTORY_SEPARATOR.'Container2L1yxl4');
