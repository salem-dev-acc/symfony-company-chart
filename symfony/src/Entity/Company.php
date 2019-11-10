<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompanyRepository")
 */
class Company implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fin_status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $market_category;

    /**
     * @ORM\Column(type="integer")
     */
    private $round_lot_size;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $security_name;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $symbol;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $test_issue;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFinStatus(): ?string
    {
        return $this->fin_status;
    }

    public function setFinStatus(string $fin_status): self
    {
        $this->fin_status = $fin_status;

        return $this;
    }

    public function getMarketCategory(): ?string
    {
        return $this->market_category;
    }

    public function setMarketCategory(string $market_category): self
    {
        $this->market_category = $market_category;

        return $this;
    }

    public function getRoundLotSize(): ?int
    {
        return $this->round_lot_size;
    }

    public function setRoundLotSize(int $round_lot_size): self
    {
        $this->round_lot_size = $round_lot_size;

        return $this;
    }

    public function getSecurityName(): ?string
    {
        return $this->security_name;
    }

    public function setSecurityName(string $security_name): self
    {
        $this->security_name = $security_name;

        return $this;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function getTestIssue(): ?string
    {
        return $this->test_issue;
    }

    public function setTestIssue(string $test_issue): self
    {
        $this->test_issue = $test_issue;

        return $this;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'name' => $this->getName(),
            'symbol' => $this->getSymbol(),
        ];
    }
}
