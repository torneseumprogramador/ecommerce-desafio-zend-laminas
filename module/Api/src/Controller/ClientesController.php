<?php

declare(strict_types=1);

namespace Api\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use \Doctrine\ORM\EntityManager;
use \Application\Entity\Cliente;
use Laminas\Paginator\Paginator;
use Laminas\Paginator\Adapter\ArrayAdapter;
use Laminas\View\Model\JsonModel;
use Api\Servico\ObjetoParaArray;

class ClientesController extends AbstractActionController
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        if (!$request->isGet()) {
            $this->getResponse()->setStatusCode(405);
            return new JsonModel(["mensagem" => "Método não permitido, somente GET"]);
        }

        $allClientes = $this->entityManager->getRepository(Cliente::class)->findAll();
    
        $page = (int) $this->params()->fromQuery('page', 1);
        $paginator = new Paginator(new ArrayAdapter($allClientes));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(50);
    
        return new JsonModel($paginator);
    }

    public function criarAction()
    {
        $request = $this->getRequest();
        if (!$request->isPost()) {
            $this->getResponse()->setStatusCode(405);
            return new JsonModel(["mensagem" => "Método não permitido, somente POST"]);
        }

        $content = $request->getContent();
        $jsonData = json_decode($content, true); 
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->getResponse()->setStatusCode(400);
            return new JsonModel(["mensagem" => "JSON enviado é inválido"]);
        }

        if (!$jsonData['nome']) {
            $this->getResponse()->setStatusCode(400);
            return new JsonModel(["mensagem" => "Nome obrigatório"]);
        }        

        $cliente = new Cliente();
        $cliente->nome = $jsonData['nome'];
        $cliente->telefone = $jsonData['telefone'];
        $cliente->email = $jsonData['email'];
        $cliente->endereco = $jsonData['endereco'];

        $this->entityManager->persist($cliente);
        $this->entityManager->flush();

        return new JsonModel(ObjetoParaArray::convertObjectToArray($cliente));
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
        $request = $this->getRequest();
        if (!$request->isDelete()) {
            $this->getResponse()->setStatusCode(405);
            return new JsonModel(["mensagem" => "Método não permitido, somente DELETE"]);
        }

        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            $this->getResponse()->setStatusCode(404);
            return new JsonModel(["mensagem" => "Id ($id) não encontrado"]);
        }

        $cliente = $this->entityManager->find(Cliente::class, $id);

        if (!$cliente) {
            $this->getResponse()->setStatusCode(404);
            return new JsonModel(["mensagem" => "cliente de Id ($id) não encontrado"]);
        }

        $this->entityManager->remove($cliente);
        $this->entityManager->flush();

        $this->getResponse()->setStatusCode(200);
        return new JsonModel(["mensagem" => "Item excluido com sucesso"]);
    }

    public function alterarAction()
    {
        $request = $this->getRequest();
        if (!$request->isPut()) {
            $this->getResponse()->setStatusCode(405);
            return new JsonModel(["mensagem" => "Método não permitido, somente PUT"]);
        }

        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            $this->getResponse()->setStatusCode(404);
            return new JsonModel(["mensagem" => "Id ($id) não encontrado"]);
        }

        $cliente = $this->entityManager->find(Cliente::class, $id);

        if (!$cliente) {
            $this->getResponse()->setStatusCode(404);
            return new JsonModel(["mensagem" => "cliente de Id ($id) não encontrado"]);
        }
       
        $content = $request->getContent();
        $jsonData = json_decode($content, true); 
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->getResponse()->setStatusCode(400);
            return new JsonModel(["mensagem" => "JSON enviado é inválido"]);
        }

        if (!$jsonData['nome']) {
            $this->getResponse()->setStatusCode(400);
            return new JsonModel(["mensagem" => "Nome obrigatório"]);
        }

        $cliente->nome = $jsonData['nome'];
        $cliente->telefone = $jsonData['telefone'];
        $cliente->email = $jsonData['email'];
        $cliente->endereco = $jsonData['endereco'];

        $this->entityManager->persist($cliente);
        $this->entityManager->flush();

        return new JsonModel(ObjetoParaArray::convertObjectToArray($cliente));
    }


    public function mostrarAction()
    {
        $request = $this->getRequest();
        if (!$request->isGet()) {
            $this->getResponse()->setStatusCode(405);
            return new JsonModel(["mensagem" => "Método não permitido, somente GET"]);
        }

        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            $this->getResponse()->setStatusCode(404);
            return new JsonModel(["mensagem" => "Id ($id) não encontrado"]);
        }

        $cliente = $this->entityManager->find(Cliente::class, $id);

        if (!$cliente) {
            $this->getResponse()->setStatusCode(404);
            return new JsonModel(["mensagem" => "cliente de Id ($id) não encontrado"]);
        }
       
        return new JsonModel(ObjetoParaArray::convertObjectToArray($cliente));
    }

}
