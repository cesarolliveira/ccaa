<?php

namespace App\Entity;

use App\Enum\SituacaoContratoEnum;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ContratoRepository;

#[ORM\Entity(repositoryClass: ContratoRepository::class)]
class Contrato
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'contratos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Aluno $aluno = null;

    #[ORM\ManyToOne(inversedBy: 'contratos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Curso $curso = null;

    #[ORM\Column]
    private ?int $parcelas = null;

    #[ORM\Column(length: 10)]
    private ?string $moeda = null;

    #[ORM\Column(length: 255)]
    private ?string $formaPagamento = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 3)]
    private ?string $desconto = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 3)]
    private ?string $valor = null;

    #[ORM\Column(length: 10)]
    private ?string $situacao;

    #[ORM\Column]
    private ?int $vencimento = null;

    #[ORM\OneToMany(mappedBy: 'contrato', targetEntity: Lancamento::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $lancamento;

    #[ORM\Column(length: 255)]
    private ?string $descricao = null;

    public function __construct()
    {
        $this->situacao = SituacaoContratoEnum::ATIVO;
        $this->lancamento = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAluno(): ?Aluno
    {
        return $this->aluno;
    }

    public function setAluno(?Aluno $aluno): self
    {
        $this->aluno = $aluno;

        return $this;
    }

    public function getCurso(): ?Curso
    {
        return $this->curso;
    }

    public function setCurso(?Curso $curso): self
    {
        $this->curso = $curso;

        return $this;
    }

    public function getParcelas(): ?int
    {
        return $this->parcelas;
    }

    public function setParcelas(int $parcelas): self
    {
        $this->parcelas = $parcelas;

        return $this;
    }

    public function getFormaPagamento(): ?string
    {
        return $this->formaPagamento;
    }

    public function setFormaPagamento(string $formaPagamento): self
    {
        $this->formaPagamento = $formaPagamento;

        return $this;
    }

    public function getDesconto(): ?string
    {
        return $this->desconto;
    }

    public function setDesconto(string $desconto): self
    {
        $this->desconto = $desconto;

        return $this;
    }

    public function getValor(): ?string
    {
        return $this->valor;
    }

    public function setValor(string $valor): self
    {
        $this->valor = $valor;

        return $this;
    }

    public function getSituacao(): string
    {
        return $this->situacao;
    }

    public function setSituacao($situacao): self
    {
        $this->situacao = $situacao;

        return $this;
    }

    public function getVencimento(): ?int
    {
        return $this->vencimento;
    }

    public function setVencimento(int $vencimento): self
    {
        $this->vencimento = $vencimento;

        return $this;
    }

    /**
     * @return Collection<int, Lancamento>
     */
    public function getLancamento(): Collection
    {
        return $this->lancamento;
    }

    public function addLancamento(Lancamento $lancamento): self
    {
        if (!$this->lancamento->contains($lancamento)) {
            $this->lancamento->add($lancamento);
            $lancamento->setContrato($this);
        }

        return $this;
    }

    public function removeLancamento(Lancamento $lancamento): self
    {
        if ($this->lancamento->removeElement($lancamento)) {
            // set the owning side to null (unless already changed)
            if ($lancamento->getContrato() === $this) {
                $lancamento->setContrato(null);
            }
        }

        return $this;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(?string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getMoeda(): ?string
    {
        return $this->moeda;
    }

    public function setMoeda(?string $moeda): self
    {
        $this->moeda = $moeda;

        return $this;
    }
}
