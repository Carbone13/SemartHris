<?php

namespace KejawenLab\Application\SemartHris\Component\Skill\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@kejawenlab.com>
 */
interface SkillInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return null|SkillGroupInterface
     */
    public function getSkillGroup(): ? SkillGroupInterface;

    /**
     * @param SkillGroupInterface|null $group
     */
    public function setSkillGroup(?SkillGroupInterface $group): void;

    /**
     * @return string
     */
    public function getName(): string;
}
