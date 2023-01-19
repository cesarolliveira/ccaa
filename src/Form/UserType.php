<?php

namespace App\Form;

use App\Entity\User;
use App\Enum\TraducaoEnum;
use App\Enum\PermissaoEnum;
use App\Service\UserService;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\NotNull;

class UserType extends AbstractType
{
    private $translator;

    private $userService;

    public function __construct(
        TranslatorInterface $translator,
        UserService $userService
    ) {
        $this->translator = $translator;
        $this->userService = $userService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomeCompleto', TextType::class, [
                'label' => $this->translator->trans(
                    'entity.user.nome_completo',
                    [],
                    null,
                    'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                ),
                'constraints' => [
                    new NotNull([
                        'message' => $this->translator->trans(
                            'message.error.user.nome_completo',
                            [],
                            null,
                            'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                        ),
                    ]),
                ],
            ])
            ->add('email', TextType::class, [
                'label' => $this->translator->trans(
                    'entity.user.email',
                    [],
                    null,
                    'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                ),
                'constraints' => [
                    new NotNull([
                        'message' => $this->translator->trans(
                            'message.error.user.email.not_null',
                            [],
                            null,
                            'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                        ),
                    ]),
                    new Email([
                        'message' => $this->translator->trans(
                            'message.error.user.email.invalid',
                            [],
                            null,
                            'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                        ),
                    ]),
                ],
            ])
            ->add('roles', ChoiceType::class, [
                'label' => $this->translator->trans(
                    'entity.user.roles',
                    [],
                    null,
                    'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                ),
                'choices' => PermissaoEnum::getChoices(),
                'multiple' => true,
                'expanded' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => $this->translator->trans(
                            'message.error.user.roles',
                            [],
                            null,
                            'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                        ),
                    ]),
                ],
            ])
            ->add('locate', ChoiceType::class, [
                'label' => $this->translator->trans(
                    'entity.user.locate',
                    [],
                    null,
                    'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                ),
                'choices' => TraducaoEnum::getChoices(),
                'placeholder' => $this->translator->trans(
                    'message.select_option',
                    [],
                    null,
                    'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                ),
                'attr' => [
                    'class' => 'js-choice',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => $this->translator->trans(
                            'message.error.user.locate',
                            [],
                            null,
                            'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                        ),
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
        $user = $event->getData();
        $form = $event->getForm();

        if (null === $user->getId()) {
            $form->add('password', PasswordType::class, [
                'label' => $this->translator->trans(
                    'entity.user.senha',
                    [],
                    null,
                    'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                ),
                'constraints' => [
                    new NotBlank([
                        'message' => $this->translator->trans(
                            'message.error.user.senha',
                            [],
                            null,
                            'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                        ),
                    ]),
                ],
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ],
        ]);
    }
}
