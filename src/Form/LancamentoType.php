<?php

namespace App\Form;

use App\Entity\Aluno;
use App\Enum\MoedaEnum;
use App\Entity\Contrato;
use App\Entity\Lancamento;
use App\Enum\SituacaoEnum;
use App\Enum\FormaPagamentoEnum;
use App\Enum\TipoLancamentoEnum;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class LancamentoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tipoLancamento', ChoiceType::class, [
                'label' => 'Tipo de Lançamento',
                'choices' => TipoLancamentoEnum::getChoices(),
                'placeholder' => 'Selecione o tipo de lançamento',
                'attr' => [
                    'class' => 'js-choice',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, selecione o tipo de lançamento',
                    ]),
                ],
            ])
            ->add('moeda', ChoiceType::class, [
                'label' => 'Moeda',
                'choices' => MoedaEnum::getChoices(),
                'placeholder' => 'Selecione uma moeda',
                'attr' => [
                    'class' => 'js-choice',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, selecione a moeda',
                    ]),
                ],
            ])
            ->add('formaPagamento', ChoiceType::class, [
                'label' => 'Forma de Pagamento',
                'choices' => FormaPagamentoEnum::getChoices(),
                'placeholder' => 'Selecione a forma de pagamento',
                'attr' => [
                    'class' => 'js-choice'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, selecione a forma de pagamento',
                    ]),
                ],
            ])
            ->add('descricao', TextType::class, [
                'label' => 'Descrição',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, informe a descrição',
                    ]),
                ],
            ])
            ->add('vencimento', DateType::class, [
                'label' => 'Vencimento',
                'format' => 'ddMMyyyy',
                'widget' => 'choice',
                'days' => range(1, 31),
                'months' => range(1, 12),
                'years' => range(date('Y') - 123, date('Y')),
                'data' => new \DateTime('now'),
                'constraints' => [
                    new GreaterThan([
                        'value' => new \DateTime('-1 day'),
                        'message' => 'A data de vencimento deve ser maior que o dia atual',
                    ]),
                ],
            ])
            ->add('valor', NumberType::class, [
                'label' => 'Valor',
                'scale' => 3,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, informe o valor',
                    ]),
                    new GreaterThan([
                        'value' => 0,
                        'message' => 'O valor deve ser maior que zero',
                    ]),
                ],
            ])
            ->add('aluno', EntityType::class, [
                'label' => 'Aluno',
                'class' => Aluno::class,
                'choice_label' => function ($aluno) {
                    return $aluno->getNomeCompleto() . ' - ' . (null != $aluno->getDocumentoCpf() ? 'CPF: ' . $aluno->getDocumentoCpf() : 'C.I / RG: ' . $aluno->getDocumentoRg());
                },
                'query_builder' => function ($alunoRepository) {
                    return $alunoRepository->createQueryBuilder('aluno')
                        ->andWhere('aluno.situacao = :situacao')
                        ->setParameter('situacao', SituacaoEnum::ATIVO)
                        ->orderBy('aluno.nomeCompleto', 'ASC')
                    ;
                },
                'placeholder' => 'Selecione uma opção',
                'attr' => [
                    'class' => 'js-choice'
                ],
            ])
            ->add('observacao', TextType::class, [
                'label' => 'Observação',
            ])
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                [$this, 'onPreSetData']
            )
        ;
    }

    public function onPreSetData(FormEvent $event): void
    {
        $lancamento = $event->getData();
        $form = $event->getForm();

        if ($lancamento->getId() && $lancamento->getTipoLancamento()) {
            $form->add('tipoLancamento', ChoiceType::class, [
                'choices' => TipoLancamentoEnum::getChoices(),
                'attr' => [
                    'class' => 'js-choice',
                ],
                'disabled' => true,
            ]);
        }

        if ($lancamento->getId() && $lancamento->getMoeda()) {
            $form->add('moeda', ChoiceType::class, [
                'choices' => MoedaEnum::getChoices(),
                'attr' => [
                    'class' => 'js-choice',
                ],
                'disabled' => true,
            ]);
        }

        if ($lancamento->getId() && $lancamento->getContrato()) {
            $form->add('moeda', ChoiceType::class, [
                'choices' => MoedaEnum::getChoices(),
                'attr' => [
                    'class' => 'js-choice',
                ],
                'disabled' => true,
            ]);
        }

        if ($lancamento->getId() && $lancamento->getVencimento()) {
            $form->add('vencimento', DateType::class, [
                'disabled' => true,
            ]);
        }

        if ($lancamento->getId() && $lancamento->getContrato()) {
            $form->add('descricao', TextType::class, [
                'disabled' => true,
            ]);
        }

        if ($lancamento->getId() && $lancamento->getValor()) {
            $form->add('valor', NumberType::class, [
                'scale' => $lancamento->getMoeda() === MoedaEnum::BRL ? 2 : 3,
                'disabled' => true,
            ]);
        }

        if ($lancamento->getId() && $lancamento->getAluno()) {
            $form->add('aluno', EntityType::class, [
                'class' => Aluno::class,
                'choice_label' => function ($aluno) {
                    return $aluno->getNomeCompleto() . ' - ' . (null != $aluno->getDocumentoCpf() ? 'CPF: ' . $aluno->getDocumentoCpf() : 'C.I / RG: ' . $aluno->getDocumentoRg());
                },
                'placeholder' => 'Selecione uma opção',
                'attr' => [
                    'class' => 'js-choice'
                ],
                'disabled' => true,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lancamento::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ],
        ]);
    }
}
