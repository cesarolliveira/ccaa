<?php

namespace App\Form;

use App\Entity\Aluno;
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
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('descricao', TextType::class, [
                'label' => 'Descrição',
                'required' => true,
            ])
            ->add('vencimento', DateType::class, [
                'label' => 'Vencimento',
                'format' => 'ddMMyyyy',
                'widget' => 'choice',
                'days' => range(1, 31),
                'months' => range(1, 12),
                'years' => range(date('Y') - 123, date('Y')),
                'data' => new \DateTime('now'),
                'required' => true,
            ])
            ->add('valor', NumberType::class, [
                'label' => 'Valor',
                'required' => true,

            ])
            ->add('aluno', EntityType::class, [
                'label' => 'Aluno',
                'class' => Aluno::class,
                'choice_label' => function ($aluno) {
                    return $aluno->getNomeCompleto() . ' - ' . $aluno->getDocumentoCpf();
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
                'required' => false,
            ])
            ->add('observacao', TextType::class, [
                'label' => 'Observação',
                'required' => false,
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

        if ($lancamento->getId() && $lancamento->getVencimento()) {
            $form->add('vencimento', DateType::class, [
                'label' => 'Vencimento',
                'format' => 'ddMMyyyy',
                'widget' => 'choice',
                'days' => range(1, 31),
                'months' => range(1, 12),
                'years' => range(date('Y') - 123, date('Y')),
                'data' => $lancamento->getVencimento(),
                'required' => true,
            ]);
        }

        if ($lancamento->getId() && $lancamento->getAluno()) {
            $form->add('aluno', EntityType::class, [
                'label' => 'Aluno',
                'class' => Aluno::class,
                'choice_label' => function ($aluno) {
                    return $aluno->getNomeCompleto() . ' - ' . $aluno->getDocumentoCpf();
                },
                'placeholder' => 'Selecione uma opção',
                'attr' => [
                    'class' => 'js-choice'
                ],
                'required' => true,
                'disabled' => true,
            ]);
        }

        if (null !== $lancamento->getId()) {
            $form->add('tipoLancamento', ChoiceType::class, [
                'label' => 'Tipo de Lançamento',
                'choices' => TipoLancamentoEnum::getChoices(),
                'attr' => [
                    'class' => 'js-choice',
                ],
                'required' => true,
                'disabled' => true,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lancamento::class,
        ]);
    }
}
