<?php

namespace App\Controller;

use App\Form\UserLoginForm;
use App\Form\UserRegisterForm;
use App\Entity\User;
use App\Service\SecurityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Traits\ApiResponser;

class SecurityController extends AbstractController
{
    use ApiResponser;

    /**
     * @Route("/register", name="register", methods={"POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param SecurityService $securityService
     * @return JsonResponse
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, SecurityService $securityService): JsonResponse
    {
        $form = $this->createForm(UserRegisterForm::class, new User());
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $password = $form->get('password')->getData();
            $encodedPassword = $passwordEncoder->encodePassword($user, $password);
            $user->setPassword($encodedPassword);

            $securityService->registerUser($user);
            return $this->successResponse(null, Response::HTTP_CREATED);
        }
        return $this->formErrorResponse($form);
    }

    /**
     * @Route("/login", name="login", methods={"POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param SecurityService $securityService
     * @return JsonResponse
     */
    public function login(Request $request, UserPasswordEncoderInterface $passwordEncoder, SecurityService $securityService): JsonResponse
    {
        $form = $this->createForm(UserLoginForm::class);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $user = $securityService->getUserByEmail($email);
            if (!$user) {
                $form->get('email')->addError(new FormError('User not found'));
                return $this->formErrorResponse($form);
            }

            $password = $form->get('password')->getData();
            $isPasswordValid = $passwordEncoder->isPasswordValid($user, $password);
            if (!$isPasswordValid) {
                $form->get('password')->addError(new FormError('Password is incorrect'));
                return $this->formErrorResponse($form);
            }

            $apiToken = $securityService->createApiToken($user);
            return $this->successResponse($apiToken, Response::HTTP_CREATED);
        }
        return $this->formErrorResponse($form);
    }
}