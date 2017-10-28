<?php
//src/AppBundle/Controller/LuckyController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class LuckyController
{

    public function numberAction()
    {
        $number = mt_rand(0, 100);

        return new Response(
            '<html><body>qdqd number: '.$number.'</body></html>'
        );
    }
}