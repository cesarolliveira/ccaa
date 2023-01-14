<?php

namespace App\Form;

use App\Entity\Curso;
use App\Enum\SituacaoEnum;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CursoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('descricao', TextType::class, [
                'label' => 'Descrição',
                'attr' => [
                    'placeholder' => 'Nome do curso',
                ],
                'required' => true,
            ])
            ->add('ementa', TextareaType::class, [
                'label' => 'Ementa',
                'attr' => [
                    'placeholder' => 'Ementa do curso',
                ],
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
        $curso = $event->getData();
        $form = $event->getForm();

        if (null !== $curso->getId()) {
            $form->add('situacao', ChoiceType::class, [
                'label' => 'Situação',
                'choices' => SituacaoEnum::getChoices(),
                'placeholder' => 'Selecione uma opção',
                'attr' => [
                    'class' => 'js-choice',
                ],
                'required' => true,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Curso::class,
        ]);
    }
}
