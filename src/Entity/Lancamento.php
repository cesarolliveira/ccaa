<?php

namespace App\Entity;

use App\Enum\SituacaoEnum;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\SituacaoLancamentoEnum;
use App\Repository\LancamentoRepository;

#[ORM\Entity(repositoryClass: LancamentoRepository::class)]
class Lancamento
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'lancamentos', cascade: ['persist'])]
    private ?Contrato $contrato = null;

    #[ORM\Column(length: 10)]
    private ?string $tipoLancamento = null;

    #[ORM\Column(length: 255)]
    private ?string $formaPagamento = null;

    #[ORM\Column(length: 255)]
    private ?string $descricao = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $parcela = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $vencimento = null;

    #[ORM\Column(length: 10)]
    private ?string $moeda = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 3)]
    private ?string $valor = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observacao = null;

    #[ORM\Column(length: 255)]
    private ?string $situacao = null;

    #[ORM\ManyToOne(inversedBy: 'lancamentos')]
    private ?Aluno $aluno = null;

    public function __construct()
    {
        $this->situacao = SituacaoLancamentoEnum::PENDENTE;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContrato(): ?Contrato
    {
        return $this->contrato;
    }

    public function setContrato(?Contrato $contrato): self
    {
        $this->contrato = $contrato;

        return $this;
    }

    public function getTipoLancamento(): ?string
    {
        return $this->tipoLancamento;
    }

    public function setTipoLancamento(string $tipoLancamento): self
    {
        $this->tipoLancamento = $tipoLancamento;

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

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getParcela(): ?int
    {
        return $this->parcela;
    }

    public function setParcela(int $parcela): self
    {
        $this->parcela = $parcela;

        return $this;
    }

    public function getVencimento(): ?\DateTimeInterface
    {
        return $this->vencimento;
    }

    public function setVencimento(\DateTimeInterface $vencimento): self
    {
        $this->vencimento = $vencimento;

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

    public function getObservacao(): ?string
    {
        return $this->observacao;
    }

    public function setObservacao(?string $observacao): self
    {
        $this->observacao = $observacao;

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

    public function getAluno(): ?Aluno
    {
        return $this->aluno;
    }

    public function setAluno(?Aluno $aluno): self
    {
        $this->aluno = $aluno;

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
