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
            "mensagem" => "Bem vindo a API Zend/Laminas",
            "endpoints" => [
                "clientes" => [
                    "GET" => "/api/clientes",
                    "GET " => "/api/clientes/{id}",
                    "POST" => [
                        "endpoint" => "/api/clientes/criar",
                        "body" => [
                            "nome" => "??",
                            "telefone" => "??",
                            "email" => "??",
                            "endereco" => "??"
                        ]
                    ],
                    "PUT" => [
                        "endpoint" => "/api/clientes/{id}/alterar",
                        "body" => [
                            "nome" => "??",
                            "telefone" => "??",
                            "email" => "??",
                            "endereco" => "??"
                        ]
                    ],
                    "DELETE" => "/api/clientes/{id}/excluir",
                ],
                "pedidos" => "/api/pedidos",
            ]
        ]);
    
        return $viewModel;
    }
}
