<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CartRepository")
 * THE CART ENTITY `
 */
class Cart
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="carts")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CartProduct", mappedBy="cart", orphanRemoval=true)
     */
    private $cartProducts;

    /**
     * @ORM\OneToOne(targetEntity="Indent", mappedBy="cart", cascade={"persist", "remove"})
     */
    private $indent;

    public function __construct()
    {
        $this->cartProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|CartProduct[]
     */
    public function getCartProducts(): Collection
    {
        return $this->cartProducts;
    }

    public function addCartProduct(CartProduct $cartProduct): self
    {
        if (!$this->cartProducts->contains($cartProduct)) {
            $this->cartProducts[] = $cartProduct;
            $cartProduct->setCart($this);
        }

        return $this;
    }

    public function removeCartProduct(CartProduct $cartProduct): self
    {
        if ($this->cartProducts->contains($cartProduct)) {
            $this->cartProducts->removeElement($cartProduct);
            // set the owning side to null (unless already changed)
            if ($cartProduct->getCart() === $this) {
                $cartProduct->setCart(null);
            }
        }

        return $this;
    }

    public function getTotal()
    {
        $total = 0;
        foreach ($this->getCartProducts() as $cartProduct) {
            $total += ($cartProduct->getQuantity() * $cartProduct->getProduct()->getPrice());
        }

        return $total;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getId();
    }

    public function getIndent(): ?Indent
    {
        return $this->indent;
    }

    public function setIndent(Indent $indent): self
    {
        $this->indent = $indent;

        // set the owning side of the relation if necessary
        if ($this !== $indent->getCart()) {
            $indent->setCart($this);
        }

        return $this;
    }
}
