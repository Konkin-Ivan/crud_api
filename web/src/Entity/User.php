<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[Assert\Email]
    #[Assert\NotBlank]
    #[ORM\Column(type: "string", length: 255)]
    private ?string $email;

    #[Assert\NotBlank]
    #[ORM\Column(type: "string", length: 255)]
    private ?string $name;

    #[Assert\NotBlank]
    #[ORM\Column(type: "integer")]
    private ?int $age;

    #[Assert\NotBlank]
    #[ORM\Column(type: "string", length: 10)]
    private ?string $sex;

//    #[Assert\Date]
//    #[Assert\NotBlank]
//    #[ORM\Column(type: "date")]
//    private \DateTimeInterface|null $birthday;

    #[Assert\NotBlank]
    #[ORM\Column(type: "string", length: 15)]
    private string|null $phone;

    #[ORM\Column(type: "datetime")]
    private ?\DateTimeInterface $created_at;

    #[ORM\Column(type: "datetime")]
    private ?\DateTimeInterface $updated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(?string $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

//    public function getBirthday(): ?\DateTimeInterface
//    {
//        return $this->birthday;
//    }
//
//    public function setBirthday(?\DateTimeInterface $birthday): self
//    {
//        $this->birthday = $birthday;
//
//        return $this;
//    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
