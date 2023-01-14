<?php

namespace App\Form;

use App\Entity\Aluno;
use App\Entity\Curso;
use App\Entity\Contrato;
use App\Enum\SituacaoEnum;
use App\Enum\FormaPagamentoEnum;
use App\Enum\QuantidadeParcelasEnum;
use App\Enum\SituacaoContratoEnum;
use App\Enum\VencimentoContratoEnum;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

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
                    return $aluno->getNomeCompleto() . ' - ' . $aluno->getDocumentoCpf();
                },
                'placeholder' => 'Selecione um aluno',
                'attr' => [
                    'class' => 'js-choice',
                ],
                'required' => true,
                'query_builder' => function ($alunoRepository) {
                    return $alunoRepository->createQueryBuilder('aluno')
                        ->andWhere('aluno.situacao = :situacao')
                        ->setParameter('situacao', SituacaoEnum::ATIVO)
                        ->orderBy('aluno.nomeCompleto', 'ASC')
                    ;
                },
            ])
            ->add('descricao', TextType::class, [
                'label' => 'Descrição',
                'required' => true,
            ])
            ->add('curso', EntityType::class, [
                'label' => 'Curso',
                'class' => Curso::class,
                'choice_label' => 'descricao',
                'placeholder' => 'Selecione um curso',
                'attr' => [
                    'class' => 'js-choice',
                ],
                'required' => true,
                'query_builder' => function ($cursoRepository) {
                    return $cursoRepository->createQueryBuilder('curso')
                        ->andWhere('curso.situacao = :situacao')
                        ->setParameter('situacao', SituacaoEnum::ATIVO)
                        ->orderBy('curso.descricao', 'ASC')
                    ;
                },
            ])
            ->add('parcelas', ChoiceType::class, [
                'label' => 'Quantidade de Parcelas',
                'choices' => QuantidadeParcelasEnum::getChoices(),
                'placeholder' => 'Selecione uma opção',
                'attr' => [
                    'class' => 'js-choice'
                ],
                'required' => true,
            ])
            ->add('vencimento', ChoiceType::class, [
                'label' => 'Vencimento',
                'choices' => VencimentoContratoEnum::getChoices(),
                'placeholder' => 'Selecione um vencimento',
                'attr' => [
                    'class' => 'js-choice'
                ],
                'required' => true,
            ])
            ->add('formaPagamento', ChoiceType::class, [
                'label' => 'Forma de Pagamento',
                'choices' => FormaPagamentoEnum::getChoices(),
                'placeholder' => 'Selecione a forma de pagamento',
                'attr' => [
                    'class' => 'js-choice'
                ],
                'required' => true,
            ])
            ->add('desconto', NumberType::class, [
                'label' => 'Desconto',
                'required' => false,
            ])
            ->add('valor', NumberType::class, [
                'label' => 'Valor',
                'required' => true,

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

        if (null !== $contrato->getAluno()) {
            $form->add('aluno', EntityType::class, [
                'label' => 'Aluno',
                'class' => Aluno::class,
                'choice_label' => function ($aluno) {
                    return $aluno->getNomeCompleto() . ' - ' . $aluno->getDocumentoCpf();
                },
                'attr' => [
                    'class' => 'js-choice',
                ],
                'disabled' => true,
                'required' => true,
            ]);
        }

        if (null !== $contrato->getId()) {
            $form->add('situacao', ChoiceType::class, [
                'label' => 'Situação',
                'choices' => SituacaoContratoEnum::getChoices(),
                'required' => true,
                'attr' => [
                    'class' => 'js-choice'
                ],
            ]);
        }
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contrato::class,
        ]);
    }
}
