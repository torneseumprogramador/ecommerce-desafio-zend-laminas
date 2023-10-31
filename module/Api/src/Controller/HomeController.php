<?php

declare(strict_types=1);

namespace Api\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel; // Adicione esta linha para usar o JsonModel

class HomeController extends AbstractActionController
{
    public function indexAction()
    {
        $viewModel = new JsonModel([
            "mensagem" => "Bem vindo a API Zend/Laminas"
        ]);
    
        return $viewModel;
    }
}
