<?php

namespace App\Form;

use App\Entity\Endereco;
use App\Enum\CidadeEnum;
use App\Service\UserService;
use App\Enum\NaturalidadeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\NotBlank;

class EnderecoType extends AbstractType
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
            ->add('bairro', TextType::class, [
                'label' => $this->translator->trans(
                    'entity.endereco.bairro',
                    [],
                    null,
                    'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                ),
                'constraints' => [
                    new notBlank([
                        'message' => $this->translator->trans(
                            'message.error.endereco.bairro',
                            [],
                            null,
                            'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                        )
                    ]),
                ],
            ])
            ->add('cidade', ChoiceType::class, [
                'label' => $this->translator->trans(
                    'entity.endereco.cidade',
                    [],
                    null,
                    'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                ),
                'choices' => CidadeEnum::getChoices(),
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
                    new notBlank([
                        'message' => $this->translator->trans(
                            'message.error.endereco.cidade',
                            [],
                            null,
                            'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                        )
                    ]),
                ],
            ])
            ->add('pais', ChoiceType::class, [
                'label' => $this->translator->trans(
                    'entity.endereco.pais',
                    [],
                    null,
                    'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                ),
                'placeholder' => $this->translator->trans(
                    'message.select_option',
                    [],
                    null,
                    'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                ),
                'choices' => NaturalidadeEnum::getChoices(),
                'attr' => [
                    'class' => 'js-choice',
                ],
                'constraints' => [
                    new notBlank([
                        'message' => $this->translator->trans(
                            'message.error.endereco.pais',
                            [],
                            null,
                            'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                        )
                    ]),
                ],
            ])
        ;

        if ($options['use_logradouro']) {
            $builder->add('logradouro', TextType::class, [
                'label' => $this->translator->trans(
                    'entity.endereco.logradouro',
                    [],
                    null,
                    'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                ),
                'constraints' => [
                    new notBlank([
                        'message' => $this->translator->trans(
                            'message.error.endereco.logradouro',
                            [],
                            null,
                            'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                        )
                    ]),
                ],
            ]);
        }

        if ($options['use_numero']) {
            $builder->add('numero', TextType::class, [
                'label' => $this->translator->trans(
                    'entity.endereco.numero',
                    [],
                    null,
                    'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                ),
                'constraints' => [
                    new notBlank([
                        'message' => $this->translator->trans(
                            'message.error.endereco.numero',
                            [],
                            null,
                            'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                        )
                    ]),
                ],
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Endereco::class,
            'use_logradouro' => true,
            'use_numero' => true,
        ]);
    }
}
