<?php

namespace App\Form;

use App\Service\UserService;
use App\Enum\NaturalidadeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TipoCadastroAlunoType extends AbstractType
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
        $builder->add('tipoCadastro', ChoiceType::class, [
            'label' => $this->translator->trans(
                'subtitle.cadastro.aluno',
                [],
                null,
                'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
            ),
            'choices' => NaturalidadeEnum::getChoices(),
            'placeholder' => 'Selecione uma opção',
            'attr' => [
                'class' => 'js-choice',
            ],
            'constraints' => [
                new notBlank([
                    'message' => $this->translator->trans(
                        'message.error.subtitle.cadastro.aluno',
                        [],
                        null,
                        'pt_BR' === $this->userService->getUserLocate() ? 'pt_BR' : 'py'
                    )
                ]),
            ],
            'mapped' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attr' => [
                'novalidate' => 'novalidate',
            ],
        ]);
    }
}
