<?php

namespace KejawenLab\Application\SemartHris\Component\Company\Model;

use KejawenLab\Application\SemartHris\Component\Address\Model\Addressable;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@kejawenlab.com>
 */
interface CompanyInterface extends Addressable
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return null|CompanyInterface
     */
    public function getParent(): ? CompanyInterface;

    /**
     * @param CompanyInterface $company
     */
    public function setParent(?CompanyInterface $company): void;

    /**
     * @return string
     */
    public function getCode(): string;

    /**
     * @return \DateTimeInterface
     */
    public function getBirthDay(): ? \DateTimeInterface;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @return string
     */
    public function getTaxNumber(): string;
}
