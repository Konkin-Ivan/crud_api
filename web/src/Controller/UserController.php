<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    #[Route('/api/v.1/user/{id}', name: 'product_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $product = $this->userService->getProductById($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return new Response('Check out this great product: '.$product->getName());
    }
    #[Route('/api/v.1/user/create', name: 'create_user', methods: 'POST')]
    public function createUser(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $response = $this->userService->createUser($data);

        if (isset($response['error'])) {
            return new JsonResponse(['error' => $response['error']], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['message' => 'User created'], Response::HTTP_CREATED);
    }

    #[Route('/api/v.1/user/{id}', name: 'update_user', methods: 'PUT')]
    public function updateUser(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $response = $this->userService->updateUser($id, $data);

        if (isset($response['error'])) {
            return new JsonResponse(['error' => $response['error']], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['message' => 'User updated'], Response::HTTP_OK);
    }

    #[Route('/api/v.1/user/{id}', name: 'delete_user', methods: 'DELETE')]
    public function deleteUser(int $id): JsonResponse
    {
        $response = $this->userService->deleteUser($id);

        if (isset($response['error'])) {
            return new JsonResponse(['error' => $response['error']], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['message' => 'User deleted'], Response::HTTP_OK);
    }
}
