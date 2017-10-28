<?php

namespace HamzaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;

class LoginController extends Controller
{


    // manual encoding of authentification
    public function authenticateAction(Request $request)
    {
      $fs = new Filesystem();
          // $what = var_dump($request);
          $fs->dumpfile('/tmp/log.txt', 'yaaay');

      $data = json_decode(file_get_contents('php://input'),true);
      $username = $data['user'];
      $pass = $data['pass'];

      if('POST' === $request->getMethod() and !empty($_POST['user']) and !empty($_POST['pass'])) {
        $username = $_POST['user'];
        $pass = $_POST['pass'];
      }

        // This data is most likely to be retrieven from the Request object (from Form)
        // But to make it easy to understand ...
        //        $_username = "test";
        //        $_password = "test";

        // Retrieve the security encoder of symfony
        $factory = $this->get('security.encoder_factory');






        /// Start retrieve user
        // If using FOSUserBundle:
        // $user_manager = $this->get('fos_user.user_manager');
        // $user = $user_manager->findUserByUsername($username);

        // Or manually
               $user = $this->getDoctrine()->getManager()->getRepository("HamzaBundle:Insect")
                   ->findOneBy(array('username' => $username));
        /// End Retrieve user





        // Check if the user exists
        if(!$user){
          $response = array(
                  'status' => 'failed',
                  'username' => $username,
                  'id' => 'empty',
                  'error' => 'empty',
                  'token' => 'empty'
         );
        $myresponse =new JsonResponse($response, 200, array('Access-Control-Allow-Origin'=> '*'));
        return $myresponse;
        // $content = $this->renderView('@HamzaBundle/Default/index.html.twig',
        //                              array('error' => 'Username doesnt exists','login' => $form1->createView(),
        //                                    'inscription' => $form2->createView())
        //                             );
        //
        // return new Response($content);
        }

        /// Start verification
        $encoder = $factory->getEncoder($user);
        $salt = $user->getSalt();

        if(!$encoder->isPasswordValid($user->getPassword(), $pass, $salt)) {
          $response = array(
                  'status' => 'failed',
                  'username' => $username,
                  'id' => 'empty',
                  'error' => 'no match',
                  'token' => 'empty'
         );
        $myresponse =new JsonResponse($response, 200, array('Access-Control-Allow-Origin'=> '*'));
        return $myresponse;
        // $content = $this->renderView('@HamzaBundle/Default/index.html.twig',
        //                              array('error' => 'Username doesnt exists','login' => $form1->createView(),
        //                                    'inscription' => $form2->createView())
        //                             );
        //
        // return new Response($content);
        }
        /// End Verification


        // The password matches ! proceed to set the user in session

        $response = array(
                'status' => 'sucess',
                'username' => $user->getUsername(),
                'id' => $user->getId(),
                'error' => 'sucess',
                'token' => $user->getConfirmationToken()
        );
        $myresponse =new JsonResponse($response, 200, array('Access-Control-Allow-Origin'=> '*'));
        return $myresponse;
        // $content = $this->renderView('@HamzaBundle/Default/index.html.twig',
        //                              array('error' => 'Username doesnt exists','login' => $form1->createView(),
        //                                    'inscription' => $form2->createView())
        //                             );
        //
        // return new Response($content);
// $content = $this->renderView('@HamzaBundle/Default/index.html.twig',
//                                      array('error' => 'Username doesnt exists')
//                                     );
//                                     return new Response($content);
//     }


}

    public function RegisterAction(Request $request){
      $data = json_decode(file_get_contents('php://input'),true);
      $username = $data['user'];
      $password = $data['password'];
      $name = $data['name'];
      $email = $data['email'];
      $age = $data['age'];
      $race = $data['race'];
      $family = $data['famille'];
      $food = $data['food'];


        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $user->setUsername($username);
        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, $password);
        $user->setPassword($encoded);
        $user->setName($name);
        $user->setAge($age);
        $user->setRace($race);
        $user->setEmail($email);
        $user->setFamille($family);
        $user->setFood($food);

        $tokenGenerator = $this->get('fos_user.util.token_generator');
        $user->setConfirmationToken($tokenGenerator->generateToken());


        $test1=$userManager->findUserByUsername($username);
        $test2=$this->getDoctrine()->getManager()->getRepository("HamzaBundle:Insect")
            ->findOneBy(array('email' => $email));

        if($test1){ // not unique username
          $response = array('status' => 'failed','message' => 'User Already exists, Choose another username',);
          return new JsonResponse($response, 200, array('Access-Control-Allow-Origin'=> '*'));

        } else if ($test2){  // not unique email
          $response = array('status' => 'failed','message' => 'Email Already exists, choose another email',);
          return new JsonResponse($response, 200, array('Access-Control-Allow-Origin'=> '*'));

        }




        //        $friend->addMyFriend($user);

        $userManager->updateUser($user);
        $response = array('status' => 'sucess','message' => 'User Created',
                          'id' => $user->getId(),'token' => $user->getConfirmationToken(),
                          'user' => $user->getUsername());
        return new JsonResponse($response, 200, array('Access-Control-Allow-Origin'=> '*'));


        // return new user
    }



}
