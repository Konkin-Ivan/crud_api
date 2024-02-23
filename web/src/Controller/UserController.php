<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    #[Route('/api/v.1/user/{id}', name: 'product_show', methods: 'GET')]
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $product = $doctrine->getRepository(User::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return new Response('Check out this great product: '.$product->getName());
    }
    #[Route('/api/v.1/user/create', name: 'create_user', methods: 'POST')]
    public function createUser(ManagerRegistry $doctrine, Request $request, ValidatorInterface $validator): JsonResponse
    {
        $user = new User();
        $data = json_decode($request->getContent(), true);

        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $user->setAge($data['age']);
        $user->setSex($data['sex']);
//        $user->setBirthday(new \DateTime($data['birthday']));
        $user->setPhone($data['phone']);
        $user->setCreatedAt(new \DateTime());
        $user->setUpdatedAt(new \DateTime());

        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new JsonResponse(['error' => $errorsString], Response::HTTP_BAD_REQUEST);
        }

        $entityManager = $doctrine->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'User created'], Response::HTTP_CREATED);
    }

    #[Route('/api/v.1/user/{id}', name: 'update_user', methods: 'PUT')]
    public function updateUser(ManagerRegistry $doctrine, int $id, Request $request): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->find($id);

        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        $data = json_decode($request->getContent(), true);
        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $user->setAge($data['age']);
        $user->setSex($data['sex']);
//        $user->setBirthday(new \DateTime($data['birthday']));
        $user->setPhone($data['phone']);

        $entityManager->flush();

        return new JsonResponse(['message' => 'User updated'], Response::HTTP_OK);
    }

    #[Route('/api/v.1/user/{id}', name: 'delete_user', methods: 'DELETE')]
    public function deleteUser(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->find($id);

        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $entityManager->remove($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'User deleted'], Response::HTTP_OK);
    }
}
