<?php

namespace Api\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="pedidos")
 */
class Pedido
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="integer")
     */
    public $clienteId;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    public $valor_total;

    /**
     * @ORM\Column(type="text")
     */
    public $descricao;

    /**
     * @ORM\Column(type="datetime")
     */
    public $data;
}
