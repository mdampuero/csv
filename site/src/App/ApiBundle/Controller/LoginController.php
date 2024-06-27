<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com>.
//  Copyright. All rights reserved.
//

namespace App\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\BackEndBundle\Entity\User;
use App\BackEndBundle\Form\Login\LoginApiType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Firebase\JWT\JWT;

class LoginController extends BaseController
{

    /**
     *
     * @ApiDoc(
     *     section="Login",
     *     description="Method to generate the access token",
     *     parameters={
     *         {"name"="email", "dataType"="String", "required"=true, "description"="Valid email address"},
     *         {"name"="password", "dataType"="String", "required"=true, "description"="Valid password"},
     *     },
     *     tags={"public"},
     *     statusCodes={
     *         200="Access Token generated",
     *         400="Bad Request",
     *         500="Internal Server error",
     *     }
     * )
     */
    public function indexAction(Request $request)
    {
        try {
            $form = $this->createForm(LoginApiType::class);
            $content = json_decode($request->getContent(), true);
            $form->submit($content);
            if (!$form->isSubmitted() || !$form->isValid())
                throw new \Exception("email or password is required");
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy([
                "email" => $content["email"],
                "role" => User::ROLE_API,
                "isDelete" => false
            ]);
            if (!$user)
                throw new \Exception("email or password invalid");

            $encoder = $this->get('security.password_encoder');
            $isPasswordValid = $encoder->isPasswordValid($user, $content["password"]);
            if (!$isPasswordValid)
                throw new \Exception("email or password invalid");

            $jwt = JWT::encode([
                'user_id' => $user->getId(),
                'exp' => time() + 3600
            ], $this->getParameter('secret'), 'HS256');

            return $this->handleView($this->view(["accessToken" => $jwt]));
        } catch (\Exception $e) {
            return $this->handleView($this->view(["message" => $e->getMessage()], Response::HTTP_BAD_REQUEST));
        }
    }
}