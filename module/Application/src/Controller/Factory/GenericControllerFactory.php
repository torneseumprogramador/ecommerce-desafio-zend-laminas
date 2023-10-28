<?php
namespace Application\Controller\Factory;

use Psr\Container\ContainerInterface;

class GenericControllerFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        // Obter EntityManager
        $entityManager = $container->get(\Doctrine\ORM\EntityManager::class);

        // Crie uma instância do controlador solicitado e passe EntityManager
        return new $requestedName($entityManager);
    }
}
