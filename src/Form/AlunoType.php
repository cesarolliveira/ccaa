<?php

namespace App\Form;

use App\Entity\Aluno;
use App\Enum\SituacaoEnum;
use App\Enum\NaturalidadeEnum;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class AlunoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomeCompleto', TextType::class, [
                'label' => 'Nome Completo',
                'required' => true,
            ])
            ->add('dataNascimento', DateType::class, [
                'label' => 'Data de Nascimento',
                'format' => 'ddMMyyyy',
                'widget' => 'choice',
                'days' => range(1, 31),
                'months' => range(1, 12),
                'years' => range(date('Y') - 123, date('Y')),
                'data' => new \DateTime('now'),
                'required' => true,
            ])
            ->add('documentoCpf', NumberType::class, [
                'label' => 'CPF',
                'required' => true,
            ])
            ->add('documentoRg', TextType::class, [
                'label' => 'RG',
                'required' => true,
            ])
            ->add('naturalidade', ChoiceType::class, [
                'label' => 'Naturalidade',
                'choices' => NaturalidadeEnum::getChoices(),
                'required' => true,
            ])
            ->add('nomePai', TextType::class, [
                'label' => 'Nome do Pai',
                'required' => false,
            ])
            ->add('nomeMae', TextType::class, [
                'label' => 'Nome da Mãe',
                'required' => true,
            ])
            ->add('nomeResponsavel', TextType::class, [
                'label' => 'Nome do Responsável',
                'required' => true,
            ])
            ->add('responsavelCpf', NumberType::class, [
                'label' => 'CPF do Responsável',
                'required' => true,
            ])
            ->add('responsavelRg', TextType::class, [
                'label' => 'RG do Responsável',
                'required' => true,
            ])
            ->add('endereco', EnderecoType::class, [
                'label' => false,
            ])
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                [$this, 'onPreSetData']
            )

        ;
    }

    public function onPreSetData(FormEvent $event): void
    {
        $aluno = $event->getData();
        $form = $event->getForm();

        if (null !== $aluno->getDataNascimento()) {
            $form->add('dataNascimento', DateType::class, [
                'label' => 'Data de Nascimento',
                'format' => 'ddMMyyyy',
                'widget' => 'choice',
                'days' => range(1, 31),
                'months' => range(1, 12),
                'years' => range(date('Y') - 123, date('Y')),
                'data' => $aluno->getDataNascimento(),
                'required' => true,
            ]);
        }

        if (null !== $aluno->getId()) {
            $form->add('situacao', ChoiceType::class, [
                'label' => 'Situação',
                'choices' => SituacaoEnum::getChoices(),
                'required' => true,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Aluno::class,
        ]);
    }
}
