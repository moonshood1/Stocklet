<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $password;
    
    /**
     * @Assert\EqualTo(propertyPath="password", message="Les mots de passe sont différents"))
     */
    public $confirmPassword;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $pictureName;    

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $userPhone;

    /**
     * @ORM\ManyToMany(targetEntity=Role::class, mappedBy="users")
     */
    private $userRoles;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="users")
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="author")
     */
    private $comments;

    /**
     * @Vich\UploadableField(mapping="avatar", fileNameProperty="pictureName")
     * @var File
     */
    private $imageFile;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=CommentLike::class, mappedBy="user")
     */
    private $likes;

    /**
     * @ORM\OneToMany(targetEntity=CommentDisLike::class, mappedBy="user")
     */
    private $dislikes;

    /**
     * @ORM\OneToMany(targetEntity=PaymentCard::class, mappedBy="users")
     */
    private $paymentCards;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $RegisteredAt;

    /**
     * @ORM\ManyToMany(targetEntity=Promo::class, mappedBy="users")
     */
    private $promos;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $chrono;

    /**
     * 
     * Permet de mettre en place un date d'inscription par default
     * @ORM\PrePersist
     */
    public function prePersist() 
    {
        if (empty($this->RegisteredAt)) {
            $this->RegisteredAt = new \DateTime();
        }
    }

    /**
     * 
     * Permet d'initialiser le chrono
     * @ORM\PrePersist
     */
    public function prePersistChrono() 
    {
        if (empty($this->chrono)) {
            $this->chrono = 1;
        }
    }

    public function setImageFile(File $pictureName = null)
    {
        $this->imageFile = $pictureName;

        if ($pictureName) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;

    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setpictureName($pictureName)
    {
        $this->pictureName = $pictureName;
    }

    public function getpictureName()
    {
        return $this->pictureName;
    }    

    public function __construct()
    {
        $this->userRoles = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->dislikes = new ArrayCollection();
        $this->paymentCards = new ArrayCollection();
        $this->promos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getUserPhone(): ?string
    {
        return $this->userPhone;
    }

    public function setUserPhone(string $userPhone): self
    {
        $this->userPhone = $userPhone;

        return $this;
    }
    public function getRoles()
    {
        $roles = $this->userRoles->map(function($role){
            return $role->getTitle();
        })->toArray();

        $roles[] = 'ROLE_USER';
        
        return $roles;
    }

    public function getSalt()
    {
        
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
        
    }

    /**
     * @return Collection|Role[]
     */
    public function getUserRoles(): Collection
    {
        return $this->userRoles;
    }

    public function addUserRole(Role $userRole): self
    {
        if (!$this->userRoles->contains($userRole)) {
            $this->userRoles[] = $userRole;
            $userRole->addUser($this);
        }

        return $this;
    }

    public function removeUserRole(Role $userRole): self
    {
        if ($this->userRoles->contains($userRole)) {
            $this->userRoles->removeElement($userRole);
            $userRole->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setUsers($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getUsers() === $this) {
                $order->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|CommentLike[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(CommentLike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setUser($this);
        }

        return $this;
    }

    public function removeLike(CommentLike $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getUser() === $this) {
                $like->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CommentDisLike[]
     */
    public function getDislikes(): Collection
    {
        return $this->dislikes;
    }

    public function addDislike(CommentDisLike $dislike): self
    {
        if (!$this->dislikes->contains($dislike)) {
            $this->dislikes[] = $dislike;
            $dislike->setUser($this);
        }

        return $this;
    }

    public function removeDislike(CommentDisLike $dislike): self
    {
        if ($this->dislikes->contains($dislike)) {
            $this->dislikes->removeElement($dislike);
            // set the owning side to null (unless already changed)
            if ($dislike->getUser() === $this) {
                $dislike->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PaymentCard[]
     */
    public function getPaymentCards(): Collection
    {
        return $this->paymentCards;
    }

    public function addPaymentCard(PaymentCard $paymentCard): self
    {
        if (!$this->paymentCards->contains($paymentCard)) {
            $this->paymentCards[] = $paymentCard;
            $paymentCard->setUsers($this);
        }

        return $this;
    }

    public function removePaymentCard(PaymentCard $paymentCard): self
    {
        if ($this->paymentCards->contains($paymentCard)) {
            $this->paymentCards->removeElement($paymentCard);
            // set the owning side to null (unless already changed)
            if ($paymentCard->getUsers() === $this) {
                $paymentCard->setUsers(null);
            }
        }

        return $this;
    }

    public function getRegisteredAt(): ?\DateTimeInterface
    {
        return $this->RegisteredAt;
    }

    public function setRegisteredAt(?\DateTimeInterface $RegisteredAt): self
    {
        $this->RegisteredAt = $RegisteredAt;

        return $this;
    }

    /**
     * @return Collection|Promo[]
     */
    public function getPromos(): Collection
    {
        return $this->promos;
    }

    public function addPromo(Promo $promo): self
    {
        if (!$this->promos->contains($promo)) {
            $this->promos[] = $promo;
            $promo->addUser($this);
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promos->contains($promo)) {
            $this->promos->removeElement($promo);
            $promo->removeUser($this);
        }

        return $this;
    }

    public function getChrono(): ?int
    {
        return $this->chrono;
    }

    public function setChrono(?int $chrono): self
    {
        $this->chrono = $chrono;

        return $this;
    }    
}
