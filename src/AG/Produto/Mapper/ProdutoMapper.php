<?php

namespace AG\Produto\Mapper;

use AG\Produto\Entity\Produto;

class ProdutoMapper
{
    private $conn;

    public function __construct(\PDO $conn)
    {
        $this->conn = $conn;
    }

    public function insert(Produto $produto)
    {
        $sql = "INSERT INTO `produtos`(`nome`, `descricao`, `valor`) VALUES (:nome, :descricao, :valor);";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':nome', $produto->getNome());
        $stmt->bindValue(':descricao', $produto->getDescricao());
        $stmt->bindValue(':valor', $produto->getValor());

        return $stmt->execute() ? true : false;
    }
}