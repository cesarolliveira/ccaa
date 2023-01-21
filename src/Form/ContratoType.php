<?php

namespace App\Form;

use App\Entity\Aluno;
use App\Entity\Curso;
use App\Entity\Contrato;
use App\Enum\SituacaoEnum;
use App\Enum\FormaPagamentoEnum;
use App\Enum\SituacaoContratoEnum;
use App\Enum\QuantidadeParcelasEnum;
use App\Enum\VencimentoContratoEnum;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\GreaterThan;

class ContratoType extends AbstractType
{
    private $em;

    public function __construct(
        EntityManagerInterface $em
    ) {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('aluno', EntityType::class, [
                'label' => 'Aluno',
                'class' => Aluno::class,
                'choice_label' => function ($aluno) {
                    return
                        $aluno->getNomeCompleto() .
                        ' - ' .
                        (null !== $aluno->getDocumentoCpf() ? $aluno->getDocumentoCpf() : $aluno->getDocumentoRg()) .
                        ' | ' .
                        $aluno->getNacionalidade()
                    ;
                },
                'placeholder' => 'Selecione um aluno',
                'attr' => [
                    'class' => 'js-choice',
                ],
                'query_builder' => function ($alunoRepository) {
                    return $alunoRepository->createQueryBuilder('aluno')
                        ->andWhere('aluno.situacao = :situacao')
                        ->setParameter('situacao', SituacaoEnum::ATIVO)
                        ->orderBy('aluno.nomeCompleto', 'ASC')
                    ;
                },
                'constraints' => [
                    new NotNull([
                        'message' => 'O campo aluno é obrigatório',
                    ]),
                ],
            ])
            ->add('descricao', TextType::class, [
                'label' => 'Descrição',
                'constraints' => [
                    new NotNull([
                        'message' => 'O campo descrição é obrigatório',
                    ]),
                ],
            ])
            ->add('curso', EntityType::class, [
                'label' => 'Curso',
                'class' => Curso::class,
                'choice_label' => 'descricao',
                'placeholder' => 'Selecione um curso',
                'attr' => [
                    'class' => 'js-choice',
                ],
                'query_builder' => function ($cursoRepository) {
                    return $cursoRepository->createQueryBuilder('curso')
                        ->andWhere('curso.situacao = :situacao')
                        ->setParameter('situacao', SituacaoEnum::ATIVO)
                        ->orderBy('curso.descricao', 'ASC')
                    ;
                },
                'constraints' => [
                    new NotNull([
                        'message' => 'O campo curso é obrigatório',
                    ]),
                ],
            ])
            ->add('parcelas', ChoiceType::class, [
                'label' => 'Quantidade de Parcelas',
                'choices' => QuantidadeParcelasEnum::getChoices(),
                'placeholder' => 'Selecione uma opção',
                'attr' => [
                    'class' => 'js-choice'
                ],
                'constraints' => [
                    new NotNull([
                        'message' => 'O campo quantidade de parcelas é obrigatório',
                    ]),
                ],
            ])
            ->add('vencimento', ChoiceType::class, [
                'label' => 'Vencimento',
                'choices' => VencimentoContratoEnum::getChoices(),
                'placeholder' => 'Selecione um vencimento',
                'attr' => [
                    'class' => 'js-choice'
                ],
                'constraints' => [
                    new NotNull([
                        'message' => 'O campo vencimento é obrigatório',
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
                    new NotNull([
                        'message' => 'O campo forma de pagamento é obrigatório',
                    ]),
                ],
            ])
            ->add('desconto', NumberType::class, [
                'label' => 'Desconto',
            ])
            ->add('valor', NumberType::class, [
                'label' => 'Valor',
                'constraints' => [
                    new NotNull([
                        'message' => 'O campo valor é obrigatório',
                    ]),
                    new GreaterThan([
                        'value' => 0,
                        'message' => 'O campo valor deve ser maior que 0',
                    ]),
                ],
            ])
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                [$this, 'onPreSetData']
            )
        ;
    }

    public function onPreSetData(FormEvent $event): void
    {
        $contrato = $event->getData();
        $form = $event->getForm();

        if ($contrato->getId() && null !== $contrato->getAluno()) {
            $form->add('aluno', EntityType::class, [
                'label' => 'Aluno',
                'class' => Aluno::class,
                'choice_label' => function ($aluno) {
                    return
                        $aluno->getNomeCompleto() .
                        ' - ' .
                        (null !== $aluno->getDocumentoCpf() ? $aluno->getDocumentoCpf() : $aluno->getDocumentoRg()) .
                        ' | ' .
                        $aluno->getNacionalidade()
                    ;
                },
                'attr' => [
                    'class' => 'js-choice',
                ],
                'disabled' => true,
            ]);
        }

        if ($contrato->getId() && null !== $contrato->getParcelas()) {
            $form->add('parcelas', ChoiceType::class, [
                'label' => 'Quantidade de Parcelas',
                'choices' => QuantidadeParcelasEnum::getChoices(),
                'attr' => [
                    'class' => 'js-choice'
                ],
                'disabled' => true,
            ]);
        }

        if ($contrato->getId() && null !== $contrato->getVencimento()) {
            $form->add('vencimento', ChoiceType::class, [
                'label' => 'Vencimento',
                'choices' => VencimentoContratoEnum::getChoices(),
                'attr' => [
                    'class' => 'js-choice'
                ],
                'disabled' => true,
            ]);
        }

        if ($contrato->getId() && null !== $contrato->getFormaPagamento()) {
            $form->add('formaPagamento', ChoiceType::class, [
                'label' => 'Forma de Pagamento',
                'choices' => FormaPagamentoEnum::getChoices(),
                'attr' => [
                    'class' => 'js-choice'
                ],
                'disabled' => true,
            ]);
        }

        if ($contrato->getId()) {
            $form->add('desconto', NumberType::class, [
                'disabled' => true,
            ]);
        }

        if ($contrato->getId() && null !== $contrato->getValor()) {
            $form->add('valor', NumberType::class, [
                'disabled' => true,
            ]);
        }

        if (null !== $contrato->getId()) {
            $form->add('situacao', ChoiceType::class, [
                'label' => 'Situação',
                'choices' => SituacaoContratoEnum::getChoices(),
                'attr' => [
                    'class' => 'js-choice'
                ],
                'constraints' => [
                    new NotNull([
                        'message' => 'O campo situação é obrigatório',
                    ]),
                ],
                'disabled' => true,
            ]);
        }
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contrato::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ],
        ]);
    }
}
