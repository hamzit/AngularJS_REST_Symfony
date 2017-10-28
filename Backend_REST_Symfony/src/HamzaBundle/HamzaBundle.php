<?php

namespace HamzaBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class HamzaBundle extends Bundle
{
    
    public function getParent()
        {
            return 'FOSUserBundle';
        }
    
}
