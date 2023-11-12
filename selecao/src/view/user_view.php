<?php
namespace view;

class user_view
{

    public static function view(int $cod,  $message)
    {
        
        http_response_code($cod);
        echo json_encode([ 

            'sucesso' => 1,
            'mensagem' => $message
            
        ]);
        exit;


    }

    public static function view_get(int $cod,  $message, $pagina_atual, $total_paginas, 
    $total_registros, $registros_por_pagina)
    {
        
        http_response_code($cod);
        echo json_encode([ 
            'pagina_atual' => $pagina_atual,
            'total_paginas' => $total_paginas,
            'total_registros' => $total_registros,
            'registros_por_pagina' => $registros_por_pagina,
            'registros' => $message
            
        ]);
        exit;


    }

    public static function fail(int $error, string $message)
    {
        
        http_response_code($error);
        echo json_encode(
            [
                'sucesso' => 0,
                'mensagem' => $message
            
            ]

        );
        exit;

    }
    
}



?>