<?php
// src/Acme/TestBundle/AcmeTestBundle.php
namespace App\Dami\SocialPlacesBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpFoundation\Response;

class SocialPlacesBundle extends Bundle
{
    public function store(){
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
}

