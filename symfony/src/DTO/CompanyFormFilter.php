<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CompanyFormFilter
{
    /**
     * @Assert\NotBlank
     * @App\Validation\Constraints\ExistsInDatabase
     */
    private $symbol;

    /**
     * @Assert\NotBlank
     * @Assert\Date()
     */
    protected $start_date;

    /**
     * @Assert\NotBlank
     * @Assert\Date()
     */
    protected $end_date;


    /**
     * @Assert\NotBlank
     * @Assert\Email
     */
    private $email;

    /**
     * @return mixed
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $symbol
     */
    public function setSymbol($symbol): void
    {
        $this->symbol = $symbol;
    }

    /**
     * @param mixed $start_date
     */
    public function setStartDate($start_date): void
    {
        $this->start_date = $start_date;
    }

    /**
     * @param mixed $end_date
     */
    public function setEndDate($end_date): void
    {
        $this->end_date = $end_date;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }
}
