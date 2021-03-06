<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $productQuantity;

    /**
     * @ORM\Column(type="float")
     */
    private $productUnitPrice;

    /**
     * @ORM\Column(type="float")
     */
    private $orderTotalAmount;

    /**
     * @ORM\Column(type="datetime")
     */
    private $orderDate;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $products;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $users;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $shippingCity;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     * @Assert\Length(
     *      min = 3,
     *      max = 15,
     *      minMessage = "Le nom du quartier est trop court",
     *      maxMessage = "Le nom du quartier est trop long")
     * @Assert\Regex("/^\w+/")
     */
    private $shippingDistrict;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     * @Assert\Length(
     *      min = 10,
     *      max = 45,
     *      minMessage = "L'adresse complète est trop courte",
     *      maxMessage = "L'adresse complète est trop longue")
     * @Assert\Regex("/^\w+/")
     */
    private $shippingAddress1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min = 10,
     *      max = 45,
     *      minMessage = "L'adresse complète est trop courte",
     *      maxMessage = "L'adresse complète est trop longue")
     * @Assert\Regex("/^\w+/")
     */
    private $shippingAddress2;

    /**
     * @ORM\OneToMany(targetEntity=Payment::class, mappedBy="orders")
     */
    private $payments;

    /**
     * @ORM\ManyToMany(targetEntity=Promo::class, mappedBy="orders")
     */
    private $promos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $invoiceNumber;

    public function __construct()
    {
        $this->payments = new ArrayCollection();
        $this->promos = new ArrayCollection();
    }

    /**
     * 
     * Permet de mettre en place un date de creation par default
     * @ORM\PrePersist
     */
    public function prePersist() 
    {
        if (empty($this->orderDate)) {
            $this->orderDate = new \DateTime();
        }
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductQuantity(): ?int
    {
        return $this->productQuantity;
    }

    public function setProductQuantity(int $productQuantity): self
    {
        $this->productQuantity = $productQuantity;

        return $this;
    }

    public function getProductUnitPrice(): ?float
    {
        return $this->productUnitPrice;
    }

    public function setProductUnitPrice(float $productUnitPrice): self
    {
        $this->productUnitPrice = $productUnitPrice;

        return $this;
    }

    public function getOrderTotalAmount(): ?float
    {
        return $this->orderTotalAmount;
    }

    public function setOrderTotalAmount(float $orderTotalAmount): self
    {
        $this->orderTotalAmount = $orderTotalAmount;

        return $this;
    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->orderDate;
    }

    public function setOrderDate(\DateTimeInterface $orderDate): self
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    public function getProducts(): ?Product
    {
        return $this->products;
    }

    public function setProducts(?Product $products): self
    {
        $this->products = $products;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getShippingCity(): ?string
    {
        return $this->shippingCity;
    }

    public function setShippingCity(string $shippingCity): self
    {
        $this->shippingCity = $shippingCity;

        return $this;
    }

    public function getShippingDistrict(): ?string
    {
        return $this->shippingDistrict;
    }

    public function setShippingDistrict(string $shippingDistrict): self
    {
        $this->shippingDistrict = $shippingDistrict;

        return $this;
    }

    public function getShippingAddress1(): ?string
    {
        return $this->shippingAddress1;
    }

    public function setShippingAddress1(string $shippingAddress1): self
    {
        $this->shippingAddress1 = $shippingAddress1;

        return $this;
    }

    public function getShippingAddress2(): ?string
    {
        return $this->shippingAddress2;
    }

    public function setShippingAddress2(?string $shippingAddress2): self
    {
        $this->shippingAddress2 = $shippingAddress2;

        return $this;
    }

    /**
     * @return Collection|Payment[]
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): self
    {
        if (!$this->payments->contains($payment)) {
            $this->payments[] = $payment;
            $payment->setOrders($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): self
    {
        if ($this->payments->contains($payment)) {
            $this->payments->removeElement($payment);
            // set the owning side to null (unless already changed)
            if ($payment->getOrders() === $this) {
                $payment->setOrders(null);
            }
        }

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
            $promo->addOrder($this);
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promos->contains($promo)) {
            $this->promos->removeElement($promo);
            $promo->removeOrder($this);
        }

        return $this;
    }

    public function getInvoiceNumber(): ?string
    {
        return $this->invoiceNumber;
    }

    public function setInvoiceNumber(?string $invoiceNumber): self
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }
}
