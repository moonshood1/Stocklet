<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity=CommentLike::class, mappedBy="comment")
     */
    private $likes;

    /**
     * @ORM\OneToMany(targetEntity=CommentDisLike::class, mappedBy="comment")
     */
    private $dislikes;

    public function __construct()
    {
        $this->likes = new ArrayCollection();
        $this->dislikes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

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
            $like->setComment($this);
        }

        return $this;
    }

    public function removeLike(CommentLike $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getComment() === $this) {
                $like->setComment(null);
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
            $dislike->setComment($this);
        }

        return $this;
    }

    public function removeDislike(CommentDisLike $dislike): self
    {
        if ($this->dislikes->contains($dislike)) {
            $this->dislikes->removeElement($dislike);
            // set the owning side to null (unless already changed)
            if ($dislike->getComment() === $this) {
                $dislike->setComment(null);
            }
        }

        return $this;
    }

    /**
     * Fonction de verification de l'utilisateur connecté pour un like
     *
     * @param User $user
     * @return boolean
     */
    public function isLikedByUser(User $user):bool
    {
        foreach ($this->likes as $like) {
            if ($like->getUser() === $user) return true;
        } return false;
    }

    /**
     * Fonction de verification de l'utilisateur connecté pour un dislike
     *
     * @param User $user
     * @return boolean
     */
    public function isDislikedByUser(User $user):bool
    {
        foreach ($this->dislikes as $dislike) {
            if ($dislike->getUser() === $user) return true;
        } return false;
    }
}
