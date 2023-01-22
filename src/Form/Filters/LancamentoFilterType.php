<?php

namespace App\Form\Filters;

use App\Entity\Aluno;
use App\Enum\SituacaoEnum;
use App\Enum\SituacaoLancamentoEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;

class LancamentoFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('aluno', Filters\EntityFilterType::class, [
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
            ->add('descricao', Filters\TextFilterType::class, [
                'label' => 'Descrição',
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
            ])
            ->add('vencimento', Filters\DateFilterType::class, [
                'label' => 'Vencimento',
                'format' => 'ddMMyyyy',
                'widget' => 'choice',
                'days' => range(1, 31),
                'months' => range(1, 12),
                'years' => range(
                    date('Y'),
                    date('Y') - 123
                ),
                'data' => null,
            ])
            ->add('situacao', Filters\ChoiceFilterType::class, [
                'label' => 'Situação',
                'choices' => SituacaoLancamentoEnum::getChoices(),
                'placeholder' => 'Selecione uma opção',
                'attr' => [
                    'class' => 'js-choice',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection'   => false,
            'validation_groups' => array('filtering')
        ]);
    }
}
