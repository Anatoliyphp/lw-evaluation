<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\User\Model\User;

class UserController extends AbstractController
{
    /**
     * @Route("/api/logged_user", methods={"GET"}, name="getLoggedUserData")
     * @return Response
     */
    public function getLoggedUserData(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        /** @var User $user */
        $user = $this->getUser();
        $role = $user->getRole();
        if ($role == User::ROLE_STUDENT) {
            $roleStr = 'student';
        } else {
            $roleStr = 'teacher';
        }

        $data = [
            'email' => $user->getEmail(),
            'id' => (string) $user->getId(),
            'role' => $roleStr,
            'firstname' => $user->getFirstName(),
            'lastname' => $user->getLastName()
        ];

        return $this->json($data);
    }
}
