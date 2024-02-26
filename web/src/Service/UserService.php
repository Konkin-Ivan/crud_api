<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserService
{
    private ManagerRegistry $doctrine;
    private ValidatorInterface $validator;

    public function __construct(
        ManagerRegistry $doctrine,
        ValidatorInterface $validator
    )
    {
        $this->doctrine = $doctrine;
        $this->validator = $validator;
    }

    public function getProductById(int $id)
    {
        return $this->doctrine->getRepository(User::class)->find($id);
    }

    public function createUser($requestData): array
    {
        $user = new User();
        $user->setName($requestData['name']);
        $user->setEmail($requestData['email']);
        $user->setAge($requestData['age']);
        $user->setSex($requestData['sex']);
        $user->setPhone($requestData['phone']);
        $user->setCreatedAt(new \DateTime());
        $user->setUpdatedAt(new \DateTime());

        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return ['error' => $errorsString];
        }

        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return ['message' => 'User created'];
    }

    public function updateUser(int $userId, $requestData): array
    {
        $entityManager = $this->doctrine->getManager();
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->find($userId);

        if (!$user) {
            return ['error' => 'User not found'];
        }

        $user->setName($requestData['name']);
        $user->setEmail($requestData['email']);
        $user->setAge($requestData['age']);
        $user->setSex($requestData['sex']);
        $user->setPhone($requestData['phone']);

        $entityManager->flush();

        return ['message' => 'User updated'];
    }

    public function deleteUser(int $userId): array
    {
        $entityManager = $this->doctrine->getManager();
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->find($userId);

        if (!$user) {
            return ['error' => 'User not found'];
        }

        $entityManager->remove($user);
        $entityManager->flush();

        return ['message' => 'User deleted'];
    }
}