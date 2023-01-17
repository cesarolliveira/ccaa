<?php

namespace App\Form;

use App\Entity\User;
use App\Enum\TraducaoEnum;
use App\Enum\PermissaoEnum;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'E-mail',
                'attr' => [
                    'placeholder' => 'E-mail'
                ],
                'required' => true,
                'constraints' => [
                    new Email([
                        'message' => 'Por favor, informe um e-mail válido',
                    ]),
                ],
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Tipo de usuário',
                'choices' => PermissaoEnum::getChoices(),
                'multiple' => true,
                'expanded' => true,
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, informe o tipo de usuário',
                    ]),
                ],
            ])
            ->add('locate', ChoiceType::class, [
                'label' => 'Tradução',
                'choices' => TraducaoEnum::getChoices(),
                'placeholder' => 'Selecione uma opção',
                'attr' => [
                    'class' => 'js-choice',
                ],
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
        $user = $event->getData();
        $form = $event->getForm();

        if (null === $user->getId()) {
            $form->add('password', PasswordType::class, [
                'label' => 'Senha',
                'attr' => [
                    'placeholder' => 'Senha'
                ],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, informe a senha',
                    ]),
                ],
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
