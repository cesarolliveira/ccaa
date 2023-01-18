<?php

namespace App\Form;

use App\Entity\Aluno;
use App\Enum\SituacaoEnum;
use App\Service\UserService;
use App\Enum\NaturalidadeEnum;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class AlunoBrasilType extends AbstractType
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
                    'entity.aluno.nome_completo',
                    [],
                    null,
                    'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                ),
                'constraints' => [
                    new notBlank([
                        'message' => $this->translator->trans(
                            'message.error.aluno.nome_completo',
                            [],
                            null,
                            'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                        )
                    ]),
                ],
            ])
            ->add('dataNascimento', DateType::class, [
                'label' => $this->translator->trans(
                    'entity.aluno.data_nascimento',
                    [],
                    null,
                    'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                ),
                'format' => 'ddMMyyyy',
                'widget' => 'choice',
                'days' => range(1, 31),
                'months' => range(1, 12),
                'years' => range(date('Y') - 123, date('Y')),
                'data' => new \DateTime('now'),
            ])
            ->add('documentoCpf', NumberType::class, [
                'label' => $this->translator->trans(
                    'entity.aluno.cpf',
                    [],
                    null,
                    'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                ),
                'constraints' => [
                    new notBlank([
                        'message' => $this->translator->trans(
                            'message.error.aluno.cpf',
                            [],
                            null,
                            'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                        )
                    ]),
                ],
            ])
            ->add('documentoRg', TextType::class, [
                'label' => $this->translator->trans(
                    'entity.aluno.rg.br',
                    [],
                    null,
                    'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                ),
                'constraints' => [
                    new notBlank([
                        'message' => $this->translator->trans(
                            'message.error.aluno.rg.br',
                            [],
                            null,
                            'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                        )
                    ]),
                ],
            ])
            ->add('naturalidade', ChoiceType::class, [
                'label' => $this->translator->trans(
                    'entity.aluno.naturalidade',
                    [],
                    null,
                    'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                ),
                'choices' => NaturalidadeEnum::getChoices(),
                'placeholder' => 'Selecione uma opção',
                'attr' => [
                    'class' => 'js-choice',
                ],
                'data' => NaturalidadeEnum::BRAZIL,
                'constraints' => [
                    new notBlank([
                        'message' => $this->translator->trans(
                            'message.error.aluno.naturalidade',
                            [],
                            null,
                            'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                        )
                    ]),
                ],
            ])
            ->add('nomePai', TextType::class, [
                'label' => $this->translator->trans(
                    'entity.aluno.nome_pai',
                    [],
                    null,
                    'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                ),
            ])
            ->add('nomeMae', TextType::class, [
                'label' => $this->translator->trans(
                    'entity.aluno.nome_mae',
                    [],
                    null,
                    'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                ),
                'constraints' => [
                    new notBlank([
                        'message' => $this->translator->trans(
                            'message.error.aluno.nome_mae',
                            [],
                            null,
                            'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                        )
                    ]),
                ],
            ])
            ->add('nomeResponsavel', TextType::class, [
                'label' => $this->translator->trans(
                    'entity.aluno.nome_responsavel',
                    [],
                    null,
                    'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                ),
                'constraints' => [
                    new notBlank([
                        'message' => $this->translator->trans(
                            'message.error.aluno.nome_responsavel',
                            [],
                            null,
                            'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                        )
                    ]),
                ],
            ])
            ->add('responsavelCpf', NumberType::class, [
                'label' => $this->translator->trans(
                    'entity.aluno.cpf_responsavel',
                    [],
                    null,
                    'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                ),
                'constraints' => [
                    new notBlank([
                        'message' => $this->translator->trans(
                            'message.error.aluno.cpf_responsavel',
                            [],
                            null,
                            'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                        )
                    ]),
                ],
            ])
            ->add('responsavelRg', TextType::class, [
                'label' => $this->translator->trans(
                    'entity.aluno.rg_responsavel',
                    [],
                    null,
                    'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                ),
                'constraints' => [
                    new notBlank([
                        'message' => $this->translator->trans(
                            'message.error.aluno.rg_responsavel.br',
                            [],
                            null,
                            'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                        )
                    ]),
                ],
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
                'label' => $this->translator->trans(
                    'entity.aluno.data_nascimento',
                    [],
                    null,
                    'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                ),
                'format' => 'ddMMyyyy',
                'widget' => 'choice',
                'days' => range(1, 31),
                'months' => range(1, 12),
                'years' => range(date('Y') - 123, date('Y')),
                'data' => $aluno->getDataNascimento(),

            ]);
        }

        if (null !== $aluno->getId()) {
            $form->add('situacao', ChoiceType::class, [
                'label' => $this->translator->trans(
                    'grid.columns.situacao',
                    [],
                    null,
                    'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                ),
                'choices' => SituacaoEnum::getChoices(),
                'placeholder' => 'Selecione uma opção',

                'attr' => [
                    'class' => 'js-choice',
                ],
                'constraints' => [
                    new notBlank([
                        'message' => $this->translator->trans(
                            'message.error.situacao',
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
            'data_class' => Aluno::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ],
        ]);
    }
}
