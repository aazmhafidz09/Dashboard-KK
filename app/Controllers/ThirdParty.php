<?php

namespace App\Controllers;


class ThirdParty extends BaseController
{
    public function __construct() { }

    public function sinta($sintaId) {
        $URL = "https://sinta.kemdikbud.go.id/authors/profile/$sintaId";
        $content = file_get_contents($URL);

        if ($content === FALSE) {
            http_response_code(500); // Internal server error
            echo "Error fetching content. It may caused by either a profile with sintaId $sintaId not exist.";
        } else {
            // Set proper content type (depends on the type of data you're fetching)
            header('Content-Type: text/html'); 
            echo $content;
        }
    }
}
