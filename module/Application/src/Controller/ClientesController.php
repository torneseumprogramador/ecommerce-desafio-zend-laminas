<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use \Doctrine\ORM\EntityManager;
use \Application\Entity\Cliente;

class ClientesController extends AbstractActionController
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {
        $cliente = new Cliente();
        $cliente->nome = 'João Silva';
        $cliente->telefone = '(11) 1234-5678';
        $cliente->email = 'joao.silva@email.com';
        $cliente->endereco = 'Rua das Flores, 123, Cidade, UF';

        $this->entityManager->persist($cliente);
        $this->entityManager->flush();

        return new ViewModel();
    }
}
