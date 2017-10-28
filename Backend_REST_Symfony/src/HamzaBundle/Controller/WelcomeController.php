<?php

namespace HamzaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;

class WelcomeController extends Controller
{


  // list my friends
  public function listAction(Request $request){
    $data = json_decode(file_get_contents('php://input'),true);
    $id = $data['id'];
    $username = $data['user'];
    $token = $data['token'];

    // first verification of user login
    $user = $this->getDoctrine()
    ->getRepository('HamzaBundle:Insect')
    ->findOneBy(array('id' => $id,'username' => $username ));

    if($user){
      // everything good so far
    }else {
      // return error that user doesn't exist
      $response = array(
        'status' => 'failed',
        'message' => 'user does not exist',
      );
      return new JsonResponse($response, 200, array('Access-Control-Allow-Origin'=> '*'));
    }

    // Second Verification by token
    if($user->getConfirmationToken() == $token ){ // user logged in !


      $friends=$user->getMyFriends();

      // serializing friends to JSON object
      $test= array();
      $serializer = $this->get('jms_serializer');
      $response = $serializer->toArray($friends);

      // creating json object for better manipulation
      foreach($response as $key=>$value) {
        $test[$key]['id'] = $value['id'];
        $test[$key]['username'] = $value['username'];
      }

      return new JsonResponse($test, 200, array('Access-Control-Allow-Origin'=> '*'));

    } else { // in case of error

      $response = array('status' => 'failed','message' => 'something',);
      return new JsonResponse($response, 200, array('Access-Control-Allow-Origin'=> '*'));

    } // in case of error

    $response = array('status' => 'failed','message' => 'something2',);
    return new JsonResponse($response, 200, array('Access-Control-Allow-Origin'=> '*'));

  }





  // list everyone
  public function listallAction(Request $request){

    $data = json_decode(file_get_contents('php://input'),true);
    $username = $data['user'];
    $token = $data['token'];


    // get everyone
    $users = $this->getDoctrine()
    ->getRepository('HamzaBundle:Insect')->findAll();

    // serializer
    $test= array();
    $serializer = $this->get('jms_serializer');
    $response = $serializer->toArray($users);

    foreach($response as $key=>$value) {
      $test[$key]['id'] = $value['id'];
      $test[$key]['username'] = $value['username'];
    }

    // debug
    // var_dump($users);

    $myresponse =new JsonResponse($test, 200, array('Access-Control-Allow-Origin'=> '*'));
    return $myresponse;


  }

  public function addfriendAction(){

    //getting parametrs from json post to php
    $data = json_decode(file_get_contents('php://input'),true);
    $id = $data['id'];
    $username = $data['user'];
    $token = $data['token'];
    $friendToAddId =  $data['friendId'];
    $friendToAddusername =  $data['friendUsername'];

    //debug
    // return new JsonResponse($username, 200, array('Access-Control-Allow-Origin'=> '*'));


    // first verification of user login
    $user = $this->getDoctrine()
    ->getRepository('HamzaBundle:Insect')
    ->findOneBy(array('id' => $id,'username' => $username ));

    if($user){
      // everything good so far
    }else {

      $response = array('status' => 'failed','message' => 'user does not exist',);
      return new JsonResponse($response, 200, array('Access-Control-Allow-Origin'=> '*'));
    }

    // debug
    // return new JsonResponse($test, 200, array('Access-Control-Allow-Origin'=> '*'));

    // Second Verification by token
    if($user->getConfirmationToken() == $token ){ // user logged in !



      // get the friend
      $friendToAdd = $this->getDoctrine()
      ->getRepository('HamzaBundle:Insect')
      ->findOneBy(array('id' => $friendToAddId,'username' => $friendToAddusername ));

      // check if friends already in list
      $test=$user->getMyFriends()->contains($friendToAdd);
      if($test){
        $response = array('status' => 'failed','message' => 'Oops Already Friends',);
        return new JsonResponse($response, 200, array('Access-Control-Allow-Origin'=> '*'));

      } else {

        $user->addMyFriend($friendToAdd);
        $userManager = $this->getDoctrine()->getManager();
        $userManager->persist($user);
        $userManager->flush();

        $response = array('status' => 'sucess','message' => 'adding friends suceeded',);

        //return
        return new JsonResponse($response, 200, array('Access-Control-Allow-Origin'=> '*'));

      }



    } else {
      $response = array(
        'status' => 'failed',
        'message' => 'something',
      );
      return new JsonResponse($response, 200, array('Access-Control-Allow-Origin'=> '*'));
    }

    $response = array(
      'status' => 'failed',
      'message' => 'something2',
    );
    return new JsonResponse($response, 200, array('Access-Control-Allow-Origin'=> '*'));


  }


  public function removefriendAction(){
    //fetch data
    $data = json_decode(file_get_contents('php://input'),true);
    $id = $data['id'];
    $username = $data['user'];
    $token = $data['token'];
    $friendToRemoveId =  $data['friendId'];
    $friendToRemoveusername =  $data['friendUsername'];
    $response = array();


    // first verification of user login
    $user = $this->getDoctrine()
    ->getRepository('HamzaBundle:Insect')
    ->findOneBy(array('id' => $id,'username' => $username ));

    if($user){
      // everything good so far
    }else {
      // final message
      $response = array('status' => 'failed','message' => 'user does not exist',);
    }


    // Second Verification by token
    if($user->getConfirmationToken() == $token ){ // user logged in !

      // get the friend
      $friendToRemove = $this->getDoctrine()
      ->getRepository('HamzaBundle:Insect')
      ->findOneBy(array('id' => $friendToRemoveId,'username' => $friendToRemoveusername ));

      // get manager
      $userManager = $this->getDoctrine()->getManager();

      //remove friend
      $user->removeMyFriend($friendToRemove);

      //flush
      $userManager->persist($user);
      $userManager->flush();
      $response = array('status' => 'sucess','message' => 'user deleted',);



    } else { // error 1
      $response = array('status' => 'failed','message' => 'something',);
    }

    return new JsonResponse($response, 200, array('Access-Control-Allow-Origin'=> '*'));

  }




  public function profileAction(Request $request){

    // getting data
    $data = json_decode(file_get_contents('php://input'),true);
    $id = $data['id'];
    $username = $data['user'];
    $token = $data['token'];
    $age =  $data['age'];
    $race =  $data['race'];
    $famille =  $data['famille'];
    $food =  $data['food'];
    $choice =  $data['get'];
    // $response = array();

    // get user
    $user = $this->getDoctrine()
    ->getRepository('HamzaBundle:Insect')
    ->findOneBy(array('id' => $id,'username' => $username ));

    // get manager
    $userManager = $this->getDoctrine()->getManager();


    if($choice == 'false'){ // case of update
    // first verification of user login

    if($user){
      // everything good so far
    }else {
      // final message
      $response = array('status' => 'failed','message' => 'user does not exist',);
    }


    // Second Verification by token
    if($user->getConfirmationToken() == $token ){ // user logged in !


      //update info
      $user->setAge($data['age']);
      $user->setRace($data['race']);
      $user->setFamille($data['famille']);
      $user->setFood($data['food']);


      //flush and update user
      $userManager->persist($user);
      $userManager->flush();
        $response = array('status' => 'sucess','message' => 'Info Updated',);



    } else { // error 1
      $response = array('status' => 'failed','message' => 'something',);
    }

    return new JsonResponse($response, 200, array('Access-Control-Allow-Origin'=> '*'));




} else { // case of get info




  // // serializer
  $test=  array();

  $serializer = $this->get('jms_serializer');
  $response = $serializer->toArray($user);




  // debug
  // var_dump($users);

  return new JsonResponse(array("race" => $response['race'] ,
                                "age" => $response['age'] ,
                              "famille" => $response['famille'],
                            "food" => $response['food'] ), 200, array('Access-Control-Allow-Origin'=> '*'));


}

return new JsonResponse("test", 200, array('Access-Control-Allow-Origin'=> '*'));


}
}
