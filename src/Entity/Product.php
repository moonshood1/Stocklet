<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks()
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le nom du produit doit etre renseigné")
     */
    private $productName;

    /**
     * @ORM\Column(type="text")
     */
    private $productDescription1;

    /**
     * @ORM\Column(type="text")
     */
    private $productDescription2;

    /**
     * @ORM\Column(type="float")
     */
    private $unitPrice;

    /**
     * @ORM\Column(type="boolean")
     */
    private $productAvailable;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $brand;

    /**
     * @ORM\Column(type="integer")
     */
    private $initialStock;

    /**
     * @ORM\Column(type="integer")
     */
    private $currentStock;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $spec1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $spec1Title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $spec2;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $spec2Title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $spec3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $spec3Title;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $leftPic1URL;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $leftPic2URL;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $leftPic3URL;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rightPic1Url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rightPic2Url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rightPic3Url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rightPic4Url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rightPic5Url;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="products")
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="product")
     */
    private $comments;

    /**
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $leftPic1Name;


    /**
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    
    private $leftPic2Name;


    /**
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $leftPic3Name;


    /**
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $rightPic1Name;


    /**
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $rightPic2Name;


    /**
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $rightPic3Name;


    /**
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $rightPic4Name;


    /**
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $rightPic5Name;

    /**
     * @Vich\UploadableField(mapping="products_left", fileNameProperty="leftPic1Name")
     * @var File
     */
    private $leftPic1File;


    /**
     * @Vich\UploadableField(mapping="products_left", fileNameProperty="leftPic2Name")
     * @var File
     */
    private $leftPic2File;


    /**
     * @Vich\UploadableField(mapping="products_left", fileNameProperty="leftPic3Name")
     * @var File
     */
    private $leftPic3File;


    /**
     * @Vich\UploadableField(mapping="products_right", fileNameProperty="rightPic1Name")
     * @var File
     */
    private $rightPic1File;


    /**
     * @Vich\UploadableField(mapping="products_right", fileNameProperty="rightPic2Name")
     * @var File
     */
    private $rightPic2File;


    /**
     * @Vich\UploadableField(mapping="products_right", fileNameProperty="rightPic3Name")
     * @var File
     */
    private $rightPic3File;


    /**
     * @Vich\UploadableField(mapping="products_right", fileNameProperty="rightPic4Name")
     * @var File
     */
    private $rightPic4File;


    /**
     * @Vich\UploadableField(mapping="products_right", fileNameProperty="rightPic5Name")
     * @var File
     */
    private $rightPic5File;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $oldUnitPrice;


    // Produit gauche 1
    public function setleftPic1File(File $leftPic1Name = null)
    {
        $this->leftPic1File = $leftPic1Name;

        if ($leftPic1Name) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;

    }

    public function getleftPic1File()
    {
        return $this->leftPic1File;
    }

    public function setleftPic1Name($leftPic1Name)
    {
        $this->leftPic1Name = $leftPic1Name;
    }

    public function getleftPic1Name()
    {
        return $this->leftPic1Name;
    } 
    
    // Produit gauche 2
    public function setleftPic2File(File $leftPic2Name = null)
    {
        $this->leftPic2File = $leftPic2Name;

        if ($leftPic2Name) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;

    }

    public function getleftPic2File()
    {
        return $this->leftPic2File;
    }

    public function setleftPic2Name($leftPic2Name)
    {
        $this->leftPic2Name = $leftPic2Name;
    }

    public function getleftPic2Name()
    {
        return $this->leftPic2Name;
    }

    // Produit gauche 3
    public function setleftPic3File(File $leftPic3Name = null)
    {
        $this->leftPic3File = $leftPic3Name;

        if ($leftPic3Name) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;

    }

    public function getleftPic3File()
    {
        return $this->leftPic3File;
    }

    public function setleftPic3Name($leftPic3Name)
    {
        $this->leftPic3Name = $leftPic3Name;
    }

    public function getleftPic3Name()
    {
        return $this->leftPic3Name;
    }

    // Produit droite 1
    public function setrightPic1File(File $rightPic1Name = null)
    {
        $this->rightPic1File = $rightPic1Name;

        if ($rightPic1Name) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;

    }

    public function getrightPic1File()
    {
        return $this->rightPic1File;
    }

    public function setrightPic1Name($rightPic1Name)
    {
        $this->rightPic1Name = $rightPic1Name;
    }

    public function getrightPic1Name()
    {
        return $this->rightPic1Name;
    }

    // Produit droite 2
    public function setrightPic2File(File $rightPic2Name = null)
    {
        $this->rightPic2File = $rightPic2Name;

        if ($rightPic2Name) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;

    }

    public function getrightPic2File()
    {
        return $this->rightPic2File;
    }

    public function setrightPic2Name($rightPic2Name)
    {
        $this->rightPic2Name = $rightPic2Name;
    }

    public function getrightPic2Name()
    {
        return $this->rightPic2Name;
    }

    // Produit droite 3
    public function setrightPic3File(File $rightPic3Name = null)
    {
        $this->rightPic3File = $rightPic3Name;

        if ($rightPic3Name) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;

    }

    public function getrightPic3File()
    {
        return $this->rightPic3File;
    }

    public function setrightPic3Name($rightPic3Name)
    {
        $this->rightPic3Name = $rightPic3Name;
    }

    public function getrightPic3Name()
    {
        return $this->rightPic3Name;
    }    

    // Produit droite 4
    public function setrightPic4File(File $rightPic4Name = null)
    {
        $this->rightPic4File = $rightPic4Name;

        if ($rightPic4Name) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;

    }

    public function getrightPic4File()
    {
        return $this->rightPic4File;
    }

    public function setrightPic4Name($rightPic4Name)
    {
        $this->rightPic4Name = $rightPic4Name;
    }

    public function getrightPic4Name()
    {
        return $this->rightPic4Name;
    }    

    // Produit droite 5
    public function setrightPic5File(File $rightPic5Name = null)
    {
        $this->rightPic5File = $rightPic5Name;

        if ($rightPic5Name) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;

    }

    public function getrightPic5File()
    {
        return $this->rightPic5File;
    }

    public function setrightPic5Name($rightPic5Name)
    {
        $this->rightPic5Name = $rightPic5Name;
    }

    public function getrightPic5Name()
    {
        return $this->rightPic5Name;
    }    
        
    /**
     * 
     * Permet de mettre en place un date de creation par default
     * @ORM\PrePersist
     */
    public function prePersist() 
    {
        if (empty($this->createdAt)) {
            $this->createdAt = new \DateTime();
        }
    }

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getProductDescription1(): ?string
    {
        return $this->productDescription1;
    }

    public function setProductDescription1(string $productDescription1): self
    {
        $this->productDescription1 = $productDescription1;

        return $this;
    }

    public function getProductDescription2(): ?string
    {
        return $this->productDescription2;
    }

    public function setProductDescription2(string $productDescription2): self
    {
        $this->productDescription2 = $productDescription2;

        return $this;
    }

    public function getUnitPrice(): ?float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(float $unitPrice): self
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getProductAvailable(): ?bool
    {
        return $this->productAvailable;
    }

    public function setProductAvailable(bool $productAvailable): self
    {
        $this->productAvailable = $productAvailable;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getInitialStock(): ?int
    {
        return $this->initialStock;
    }

    public function setInitialStock(int $initialStock): self
    {
        $this->initialStock = $initialStock;

        return $this;
    }

    public function getCurrentStock(): ?int
    {
        return $this->currentStock;
    }

    public function setCurrentStock(int $currentStock): self
    {
        $this->currentStock = $currentStock;

        return $this;
    }

    public function getSpec1(): ?string
    {
        return $this->spec1;
    }

    public function setSpec1(?string $spec1): self
    {
        $this->spec1 = $spec1;

        return $this;
    }

    public function getSpec1Title(): ?string
    {
        return $this->spec1Title;
    }

    public function setSpec1Title(?string $spec1Title): self
    {
        $this->spec1Title = $spec1Title;

        return $this;
    }

    public function getSpec2(): ?string
    {
        return $this->spec2;
    }

    public function setSpec2(?string $spec2): self
    {
        $this->spec2 = $spec2;

        return $this;
    }

    public function getSpec2Title(): ?string
    {
        return $this->spec2Title;
    }

    public function setSpec2Title(?string $spec2Title): self
    {
        $this->spec2Title = $spec2Title;

        return $this;
    }

    public function getSpec3(): ?string
    {
        return $this->spec3;
    }

    public function setSpec3(?string $spec3): self
    {
        $this->spec3 = $spec3;

        return $this;
    }

    public function getSpec3Title(): ?string
    {
        return $this->spec3Title;
    }

    public function setSpec3Title(?string $spec3Title): self
    {
        $this->spec3Title = $spec3Title;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
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

    public function getLeftPic1URL(): ?string
    {
        return $this->leftPic1URL;
    }

    public function setLeftPic1URL(?string $leftPic1URL): self
    {
        $this->leftPic1URL = $leftPic1URL;

        return $this;
    }

    public function getLeftPic2URL(): ?string
    {
        return $this->leftPic2URL;
    }

    public function setLeftPic2URL(?string $leftPic2URL): self
    {
        $this->leftPic2URL = $leftPic2URL;

        return $this;
    }

    public function getLeftPic3URL(): ?string
    {
        return $this->leftPic3URL;
    }

    public function setLeftPic3URL(?string $leftPic3URL): self
    {
        $this->leftPic3URL = $leftPic3URL;

        return $this;
    }

    public function getRightPic1Url(): ?string
    {
        return $this->rightPic1Url;
    }

    public function setRightPic1Url(?string $rightPic1Url): self
    {
        $this->rightPic1Url = $rightPic1Url;

        return $this;
    }

    public function getRightPic2Url(): ?string
    {
        return $this->rightPic2Url;
    }

    public function setRightPic2Url(?string $rightPic2Url): self
    {
        $this->rightPic2Url = $rightPic2Url;

        return $this;
    }

    public function getRightPic3Url(): ?string
    {
        return $this->rightPic3Url;
    }

    public function setRightPic3Url(?string $rightPic3Url): self
    {
        $this->rightPic3Url = $rightPic3Url;

        return $this;
    }

    public function getRightPic4Url(): ?string
    {
        return $this->rightPic4Url;
    }

    public function setRightPic4Url(?string $rightPic4Url): self
    {
        $this->rightPic4Url = $rightPic4Url;

        return $this;
    }

    public function getRightPic5Url(): ?string
    {
        return $this->rightPic5Url;
    }

    public function setRightPic5Url(?string $rightPic5Url): self
    {
        $this->rightPic5Url = $rightPic5Url;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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
            $order->setProducts($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getProducts() === $this) {
                $order->setProducts(null);
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
            $comment->setProduct($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getProduct() === $this) {
                $comment->setProduct(null);
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

    public function getOldUnitPrice(): ?float
    {
        return $this->oldUnitPrice;
    }

    public function setOldUnitPrice(?float $oldUnitPrice): self
    {
        $this->oldUnitPrice = $oldUnitPrice;

        return $this;
    }
}
