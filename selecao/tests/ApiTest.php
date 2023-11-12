<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class ApiTest extends TestCase
{
    private $baseUri = 'http://localhost:3000'; // Altere conforme necessário

    
    public function testPostRequest() // teste POST (inserir)
    {
        $client = new Client(['base_uri' => $this->baseUri]);
        $response = $client->post('/insert/', [
            'json' => ['nome' => 'teste', 'descricao' => 'teste', 'preco' => 25.5, 'quantidade' => 20],
        ]);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals(json_encode([ 
            'sucesso' => 1,
            'mensagem' => "Operação realizada com sucesso!"
        ]), $response->getBody()->getContents());
    }
    
    public function testGetRequest() // teste get (ler)
    {
        $client = new Client(['base_uri' => $this->baseUri]);
        $response = $client->get('/get');

        $responseData = json_decode($response->getBody()->getContents(), true);
        $keys = array_keys($responseData);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['pagina_atual', 'total_paginas', 'total_registros',
        'registros_por_pagina', 'registros'], $keys);
    }

    public function testGetRequestId() // teste get (paginar)
    {
        $client = new Client(['base_uri' => $this->baseUri]);
        $response = $client->get('/get/id/1/');

        $this->assertEquals(200, $response->getStatusCode());
    }
    

    public function testGetRequestPage() // teste get (paginar)
    {
        $client = new Client(['base_uri' => $this->baseUri]);
        $response = $client->get('/get/1');

        $responseData = json_decode($response->getBody()->getContents(), true);
        $keys = array_keys($responseData);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['pagina_atual', 'total_paginas', 'total_registros',
        'registros_por_pagina', 'registros'], $keys);
    }
    
    
    public function testPutRequest() // test put atualizar
    {
        $client = new Client(['base_uri' => $this->baseUri]);
        $response = $client->put('/update/', [
            'json' => ['id' => 1, 'nome' => 'teste', 'descricao' => 'teste', 'preco' => 25.4, 'quantidade' => 20],
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(json_encode([ 
            'sucesso' => 1,
            'mensagem' => "Operação realizada com Sucesso!"
        ]), $response->getBody()->getContents());
    }

    
    public function testDeleteRequest() // teste delete (deletar)
    {
        $client = new Client(['base_uri' => $this->baseUri]);
        $response = $client->delete('/delete/1');


        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(json_encode([ 
            'sucesso' => 1,
            'mensagem' => "Operação realizada com Sucesso!"
        ]), $response->getBody()->getContents());
    }
    
    
}
