<?php
namespace controller;
use model\DAO;

use view\user_view;

class crud_controller
{


    public function __construct($page = null, $id = null) {


        if ($_SERVER['REQUEST_METHOD'] == "POST") {
          
            $this->create();
        }elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
            $this->read($page, $id);
        }elseif ($_SERVER['REQUEST_METHOD'] == "PUT") {
            $this->update();
        }elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            $this->delete($id);
        }
   
    }

    public function delete($id) : void {

        if (is_numeric($id)) {
                
            $id = (int) $id;
        }else{
            user_view::fail(400, "Os id's devem ser do tipo inteiro");

        }

        $sql = DAO::query("DELETE FROM produtos WHERE id = :id", array(':id' => $id));

        // IF TRUE termina
        if ($sql) {
            user_view::view(200, "Operação realizada com Sucesso!");
        }
        
        
        user_view::fail(400, "Id inválido!");

    }


    public function update() : void {


        $data = json_decode(file_get_contents("php://input"));


        /*
            Bloco sanatização
        */
        if (empty(trim($data->nome))):

            user_view::fail(400, "Adicione o nome");

        endif;

        if (empty(trim($data->id))):

            user_view::fail(400, "Adicione o id");

        elseif (!is_int($data->id)) :

            user_view::fail(400, "Tipo esperado do campo id, inteiro!");

        endif;


        if (empty(trim($data->descricao))):

            user_view::fail(400, "Adicione a descrição");

        endif;

        if (empty(trim($data->preco))):

            user_view::fail(400, "Adicione o preco");

        elseif (!is_double($data->preco) && !is_int($data->preco)):

            user_view::fail(400, "Tipo esperado do campo preço, decimal ou inteiro!");

        endif;

        if (empty(trim($data->quantidade))):

            user_view::fail(400, "Adicione a quantidade");

        elseif (!is_double($data->quantidade) && !is_int($data->quantidade)):

            user_view::fail(400, "Tipo esperado do campo quantidade, decimal ou inteiro!");
    
        endif;

        /*

            retirando possiveis tags html ou php

        */
        $id = htmlspecialchars(strip_tags($data->id));
        $nome = htmlspecialchars(strip_tags($data->nome));
        $descricao = htmlspecialchars(strip_tags($data->descricao));
        $preco = htmlspecialchars(strip_tags($data->preco));
        $quantidade = htmlspecialchars(strip_tags($data->quantidade));

        $query = DAO::query("UPDATE produtos SET nome = :nome, descricao = :descricao, preco = :preco,
        quantidade = :quantidade WHERE id = :id", array(':nome' => $nome, ':descricao' => $descricao, 
        ':preco' => $preco, ':quantidade' => $quantidade, ':id' => $id));

        
        // IF TRUE termina
      
        user_view::view(200, "Operação realizada com Sucesso!");


    }


    public function read($page, $id) : void {

        if (is_null($id)) {
            
            $page = !is_null($page) ? (int) $page: 1; // recebimento da pagina atual, operador ternario

            $reg_pag = 5; // limite de valores por pagina

            $offset = ($page-1) * $reg_pag; // offset da query sendo OFSSET inicio da indexação até o fim LIMIT

            $total_pages_sql = DAO::select("SELECT COUNT(*) as count FROM produtos");
            // total de linhas na tabela 

            $total_pages = ceil($total_pages_sql[0]['count'] / $reg_pag); // calc total de paginas

            $sql = DAO::select("SELECT * FROM produtos LIMIT $offset, $reg_pag");
            //sql e resultado
            if (count($sql) > 0) {
                user_view::view_get(200, $sql, $page, $total_pages, $total_pages_sql[0]['count'], $reg_pag);
            }else {
                user_view::view_get(400, "Vazio...", $page, $total_pages, $total_pages_sql[0]['count'], $reg_pag);
            }

        }else{

            if (is_numeric($id)) {
                
                $id = (int) $id;
            }else{
                user_view::fail(400, "Os id's devem ser do tipo inteiro");

            }

            $sql = DAO::select("SELECT * FROM produtos WHERE id = :id", array(':id' => $id));


            if (count($sql) > 0) {
                user_view::view(200, $sql);
            }


            user_view::fail(400, "Nenhum registro encontrato para este id!");

        }



        
    }
    
    public function create() : void {
       
        $data = json_decode(file_get_contents("php://input"));

        /*
            Bloco sanatização
        */
        if (empty(trim($data->nome))):

            user_view::fail(400, "Adicione o nome");

        endif;


        if (empty(trim($data->descricao))):

            user_view::fail(400, "Adicione a descrição");

        endif;

        if (empty(trim($data->preco))):

            user_view::fail(400, "Adicione o preco");

        elseif (!is_double($data->preco) && !is_int($data->preco)):

            user_view::fail(400, "Tipo esperado do campo preço, decimal ou inteiro!");

        endif;

        if (empty(trim($data->quantidade))):

            user_view::fail(400, "Adicione a quantidade");

        elseif (!is_double($data->quantidade) && !is_int($data->quantidade)):

            user_view::fail(400, "Tipo esperado do campo preço, decimal ou inteiro!");
    
        endif;

        /*

            retirando possiveis tags html ou php

        */
        $nome = htmlspecialchars(strip_tags($data->nome));
        $descricao = htmlspecialchars(strip_tags($data->descricao));
        $preco = htmlspecialchars(strip_tags($data->preco));
        $quantidade = htmlspecialchars(strip_tags($data->quantidade));


        // execução da query intanciando a DAO, DATA ACESS OBJECT
        $query =  DAO::query("INSERT INTO produtos (nome, descricao, preco, quantidade)
        VALUES(:nome, :descricao, :preco, :quantidade)", array(':nome' => $nome, 
        ':descricao' => $descricao, ':preco' => $preco, ':quantidade' => $quantidade));
        
        // IF TRUE termina
        if ($query) {
            user_view::view(201, "Operação realizada com sucesso!");
        }

        user_view::fail(500, "Erro interno, Contate o suporte!");

        
        
    }
}



?>