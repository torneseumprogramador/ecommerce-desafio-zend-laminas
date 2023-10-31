<?php

declare(strict_types=1);

namespace Api;

use Laminas\Mvc\MvcEvent; // Adicione esta linha
use Laminas\View\Model\JsonModel; // Adicione esta linha

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $app = $e->getApplication();
        $eventManager = $app->getEventManager();
        
        $eventManager->attach(MvcEvent::EVENT_RENDER, function (MvcEvent $e) {
            $result = $e->getResult();
            if ($result instanceof JsonModel) {
                // Desabilita a renderização do layout/view para JsonModel
                $e->getViewModel()->setTerminal(true);
            }
        }, 100); // A prioridade alta garante que este evento seja executado antes do processo de renderização padrão
    }

    public function getConfig(): array
    {
        /** @var array $config */
        $config = include __DIR__ . '/../config/module.config.php';
        return $config;
    }
}
