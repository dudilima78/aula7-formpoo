<?php

class Create extends Conn{

    private $tabela;
    private $dados;
    private $resultado;
    private $msg;
    private $query;
    private $conn;

    //metodo de inserção de dados
    public function exeCreate($tabela, array $dados)
    {
        $this->tabela = (string) $tabela;
        $this-> dados = $dados;

        //execute após estas definições os metodos:
        $this->getInstrucao();
        $this->executarInstrucao();
    }

    public function getResultado()
    {
        return $this->resultado;
    }

    public function getMsg()
    {
        return $this->msg ;   
    }

    public function conexao()
    {
        $this->conn = parent::getConn();
        $this->query = $this->conn->prepare($this->query);
    }

    public function getInstrucao(){
        //insert into tbl (nome,email,valor) values (':nome',':email',34)
        $keys = implode(',',array_keys($this->dados));
        $values =':'.implode(', :', array_keys($this->dados));

        $this->query = "INSERT INTO {$this->tabela} ({$keys}) VALUES ({$values})";
    }

    public function executarInstrucao(){
        $this->conexao();
        try {
            $this->query->execute($this->dados);
            $this->resultado = $this->conn->lastInsertId();
        } catch (Exception $e) {
            $this->Resultado = null;
            $this->Msg = "<b>Erro ao Cadastrar: </b> {$e->getMessage()}";
        }

    }

}