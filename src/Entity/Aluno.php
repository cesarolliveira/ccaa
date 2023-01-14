<?php

namespace App\Entity;

use App\Enum\SituacaoEnum;
use App\Repository\AlunoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlunoRepository::class)]
class Aluno
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomeCompleto = null;

    #[ORM\Column(length: 255)]
    private ?string $documentoCpf = null;

    #[ORM\Column(length: 255)]
    private ?string $documentoRg = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dataNascimento = null;

    #[ORM\Column(length: 255)]
    private ?string $naturalidade = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomePai = null;

    #[ORM\Column(length: 255)]
    private ?string $nomeMae = null;

    #[ORM\Column(length: 255)]
    private ?string $nomeResponsavel = null;

    #[ORM\Column]
    private ?int $responsavelCpf = null;

    #[ORM\Column(length: 255)]
    private ?string $responsavelRg = null;

    #[ORM\Column(length: 10)]
    private ?string $situacao = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Endereco $endereco = null;

    #[ORM\OneToMany(mappedBy: 'aluno', targetEntity: Contrato::class, cascade: ['remove'])]
    private Collection $contratos;

    #[ORM\OneToMany(mappedBy: 'aluno', targetEntity: Lancamento::class)]
    private Collection $lancamentos;

    public function __construct()
    {
        $this->situacao = SituacaoEnum::ATIVO;
        $this->contratos = new ArrayCollection();
        $this->lancamentos = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nomeCompleto;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomeCompleto(): ?string
    {
        return $this->nomeCompleto;
    }

    public function setNomeCompleto(string $nomeCompleto): self
    {
        $this->nomeCompleto = $nomeCompleto;

        return $this;
    }

    public function getDocumentoCpf(): ?string
    {
        return $this->documentoCpf;
    }

    public function setDocumentoCpf(string $documentoCpf): self
    {
        $this->documentoCpf = str_pad($documentoCpf, 11, '0', STR_PAD_LEFT);

        return $this;
    }

    public function getDocumentoRg(): ?string
    {
        return $this->documentoRg;
    }

    public function setDocumentoRg(string $documentoRg): self
    {
        $this->documentoRg = $documentoRg;

        return $this;
    }

    public function getDataNascimento(): ?\DateTimeInterface
    {
        return $this->dataNascimento;
    }

    public function setDataNascimento(\DateTimeInterface $dataNascimento): self
    {
        $this->dataNascimento = $dataNascimento;

        return $this;
    }

    public function getNaturalidade(): ?string
    {
        return $this->naturalidade;
    }

    public function setNaturalidade(string $naturalidade): self
    {
        $this->naturalidade = $naturalidade;

        return $this;
    }

    public function getNomePai(): ?string
    {
        return $this->nomePai;
    }

    public function setNomePai(?string $nomePai): self
    {
        $this->nomePai = $nomePai;

        return $this;
    }

    public function getNomeMae(): ?string
    {
        return $this->nomeMae;
    }

    public function setNomeMae(string $nomeMae): self
    {
        $this->nomeMae = $nomeMae;

        return $this;
    }

    public function getNomeResponsavel(): ?string
    {
        return $this->nomeResponsavel;
    }

    public function setNomeResponsavel(string $nomeResponsavel): self
    {
        $this->nomeResponsavel = $nomeResponsavel;

        return $this;
    }

    public function getResponsavelCpf(): ?int
    {
        return $this->responsavelCpf;
    }

    public function setResponsavelCpf(int $responsavelCpf): self
    {
        $this->responsavelCpf = $responsavelCpf;

        return $this;
    }

    public function getResponsavelRg(): ?string
    {
        return $this->responsavelRg;
    }

    public function setResponsavelRg(string $responsavelRg): self
    {
        $this->responsavelRg = $responsavelRg;

        return $this;
    }

    public function getSituacao(): ?string
    {
        return $this->situacao;
    }

    public function setSituacao(string $situacao): self
    {
        $this->situacao = $situacao;

        return $this;
    }

    public function getEndereco(): ?Endereco
    {
        return $this->endereco;
    }

    public function setEndereco(?Endereco $endereco): self
    {
        $this->endereco = $endereco;

        return $this;
    }

    /**
     * @return Collection<int, Contrato>
     */
    public function getContratos(): Collection
    {
        return $this->contratos;
    }

    public function addContrato(Contrato $contrato): self
    {
        if (!$this->contratos->contains($contrato)) {
            $this->contratos->add($contrato);
            $contrato->setAluno($this);
        }

        return $this;
    }

    public function removeContrato(Contrato $contrato): self
    {
        if ($this->contratos->removeElement($contrato)) {
            // set the owning side to null (unless already changed)
            if ($contrato->getAluno() === $this) {
                $contrato->setAluno(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Lancamento>
     */
    public function getLancamentos(): Collection
    {
        return $this->lancamentos;
    }

    public function addLancamento(Lancamento $lancamento): self
    {
        if (!$this->lancamentos->contains($lancamento)) {
            $this->lancamentos->add($lancamento);
            $lancamento->setAluno($this);
        }

        return $this;
    }

    public function removeLancamento(Lancamento $lancamento): self
    {
        if ($this->lancamentos->removeElement($lancamento)) {
            // set the owning side to null (unless already changed)
            if ($lancamento->getAluno() === $this) {
                $lancamento->setAluno(null);
            }
        }

        return $this;
    }
}
