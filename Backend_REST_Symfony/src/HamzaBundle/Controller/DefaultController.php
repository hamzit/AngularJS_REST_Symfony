<?php



namespace HamzaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;

use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class DefaultController extends Controller
{

    public function numberAction(Request $request)
    {

        //
        // // Login form
        // $form1 = $this->get('form.factory')
        //     ->createNamedBuilder('login', 'form',null, array('attr' => array('id' => 'login-form')))
        //     ->getForm();
        //
        //
        //
        //
        // //inscription form
        // $form2 = $this->get('form.factory')
        //     ->createNamedBuilder('inscription', 'form',null, array('attr' => array('id' => 'register-form','style' => 'display: none;')))
        //     ->getForm();
        //
        //
        //
        // if('POST' === $request->getMethod()) {
        //
        //     $task = $request->request->all();
        //
        //
        //     if ($request->request->has('login-submit')) {
        //
        //         $response = $this->forward('HamzaBundle:Login:authenticate', array(
        //             'user'  => $task['username'],
        //             'pass' => $task['password'],
        //         ));
        //         return $response;
        //
        //     }
        //
        //     if ($request->request->has('register-submit')) {
        //
        //         $response = $this->forward('HamzaBundle:Login:register');
        //         return $response;
        //     }
        // }
        //
        // return $this->render('@HamzaBundle/Default/index.html.twig', ['login' => $form1->createView(),
        //                                                               'inscription' => $form2->createView()]);

if('POST' === $request->getMethod()) {
  $test = array(
    'hamza' => 'hamza'
 );
//
//  $data = json_decode($request->getContent(), true);
// $request->request->replace($data);

$fs = new Filesystem();
    // $what = var_dump($request);
    $fs->dumpfile('/tmp/log.txt', $request);

  $myresponse =new JsonResponse($request->request->all(), 200, array('Access-Control-Allow-Origin'=> '*'));
  return $myresponse;
  // return new Response($test);
}


    }

}
