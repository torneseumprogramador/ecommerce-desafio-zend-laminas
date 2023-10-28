<?php
namespace Application\Entity;

use \Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="clientes")
 */
class Cliente
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    public $nome;

    /**
     * @ORM\Column(type="string", length=30))
     */
    public $telefone;

    /**
     * @ORM\Column(type="string", length=200)
     */
    public $email;

    /**
     * @ORM\Column(type="text")
     */
    public $endereco;
}
