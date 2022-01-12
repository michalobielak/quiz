<?php

namespace App\Entity;

use App\Repository\SummaryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SummaryRepository::class)
 */
class Summary
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Area::class, inversedBy="summaries")
     */
    private $area;

    /**
     * @ORM\ManyToOne(targetEntity=COmpetence::class, inversedBy="summaries")
     */
    private $Competence;

    /**
     * @ORM\Column(type="integer")
     */
    private $evalution;

    /**
     * @ORM\Column(type="text")
     */
    private $description;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArea(): ?Area
    {
        return $this->area;
    }

    public function setArea(?Area $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getCompetence(): ?COmpetence
    {
        return $this->Competence;
    }

    public function setCompetence(?COmpetence $Competence): self
    {
        $this->Competence = $Competence;

        return $this;
    }

    public function getEvalution(): ?int
    {
        return $this->evalution;
    }

    public function setEvalution(int $evalution): self
    {
        $this->evalution = $evalution;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
