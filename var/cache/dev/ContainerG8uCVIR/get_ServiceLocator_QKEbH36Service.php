<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private '.service_locator.QKEbH36' shared service.

return $this->privates['.service_locator.QKEbH36'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
    'entityManager' => ['services', 'doctrine.orm.default_entity_manager', 'getDoctrine_Orm_DefaultEntityManagerService', false],
    'user' => ['privates', '.errored..service_locator.QKEbH36.App\\Entity\\Utilisateur', NULL, 'Cannot autowire service ".service_locator.QKEbH36": it references class "App\\Entity\\Utilisateur" but no such service exists.'],
], [
    'entityManager' => '?',
    'user' => 'App\\Entity\\Utilisateur',
]);
