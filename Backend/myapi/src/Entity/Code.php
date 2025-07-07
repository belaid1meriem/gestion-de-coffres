<?php

namespace App\Entity;

use App\Repository\CodeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CodeRepository::class)]
class Code
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 36)]
    private ?string $code = null;

    #[ORM\OneToOne(mappedBy: 'codeId', cascade: ['persist', 'remove'])]
    private ?Historique $historique = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getHistorique(): ?Historique
    {
        return $this->historique;
    }

    public function setHistorique(Historique $historique): static
    {
        // set the owning side of the relation if necessary
        if ($historique->getCodeId() !== $this) {
            $historique->setCodeId($this);
        }

        $this->historique = $historique;

        return $this;
    }
}
