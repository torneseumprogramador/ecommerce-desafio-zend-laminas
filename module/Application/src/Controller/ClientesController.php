<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use \Doctrine\ORM\EntityManager;
use \Application\Entity\Cliente;
use Laminas\Paginator\Paginator;
use Laminas\Paginator\Adapter\ArrayAdapter;

class ClientesController extends AbstractActionController
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {
        $allClientes = $this->entityManager->getRepository(Cliente::class)->findAll();
    
        $page = (int) $this->params()->fromQuery('page', 1);
        $paginator = new Paginator(new ArrayAdapter($allClientes));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(5);
    
        return new ViewModel([
            'clientes' => $paginator
        ]);
    }

    public function novoAction()
    {
        return new ViewModel();
    }

    public function criarAction()
    {
        $request = $this->getRequest();
        if (!$request->isPost()) {
            $this->getResponse()->setStatusCode(405);
            return;
        }

        $postData = $request->getPost();

        $cliente = new Cliente();
        $cliente->nome = $postData['nome'];
        $cliente->telefone = $postData['telefone'];
        $cliente->email = $postData['email'];
        $cliente->endereco = $postData['endereco'];

        $this->entityManager->persist($cliente);
        $this->entityManager->flush();

        $this->flashMessenger()->addSuccessMessage('Cliente criado com sucesso!');

        return $this->redirect()->toRoute('clientes');
    }

    public function editarAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            $this->flashMessenger()->addErrorMessage('Cliente não encontrado!');
            return $this->redirect()->toRoute('clientes');
        }

        // Encontrar cliente pelo ID
        $cliente = $this->entityManager->find(Cliente::class, $id);

        if (!$cliente) {
            $this->flashMessenger()->addErrorMessage('Cliente não encontrado!');
            return $this->redirect()->toRoute('clientes');
        }

        // Implementar lógica de edição aqui (pode ser um formulário, por exemplo)

        return new ViewModel([
            'cliente' => $cliente
        ]);
    }

    public function excluirAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            $this->flashMessenger()->addErrorMessage('Cliente não encontrado!');
            return $this->redirect()->toRoute('clientes');
        }

        $cliente = $this->entityManager->find(Cliente::class, $id);

        if (!$cliente) {
            $this->flashMessenger()->addErrorMessage('Cliente não encontrado!');
            return $this->redirect()->toRoute('clientes');
        }

        $this->entityManager->remove($cliente);
        $this->entityManager->flush();

        // Adicionar mensagem de sucesso após a exclusão
        $this->flashMessenger()->addSuccessMessage('Cliente removido com sucesso!');

        return $this->redirect()->toRoute('clientes');
    }

    public function alterarAction()
    {
        $request = $this->getRequest();
        if (!$request->isPost()) {
            $this->getResponse()->setStatusCode(405);
            return;
        }

        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('clientes');
        }

        $cliente = $this->entityManager->find(Cliente::class, $id);

        if (!$cliente) {
            return $this->redirect()->toRoute('clientes');
        }

        $postData = $request->getPost();

        $cliente->nome = $postData['nome'];
        $cliente->telefone = $postData['telefone'];
        $cliente->email = $postData['email'];
        $cliente->endereco = $postData['endereco'];

        $this->entityManager->persist($cliente);
        $this->entityManager->flush();

        $this->flashMessenger()->addSuccessMessage('Cliente atualizado com sucesso!');

        return $this->redirect()->toRoute('clientes');
    }

}
