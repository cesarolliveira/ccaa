<?php

namespace App\Form;

use App\Entity\Endereco;
use App\Enum\CidadeEnum;
use App\Enum\NaturalidadeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EnderecoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('logradouro', TextType::class, [
                'label' => 'Logradouro',
                'required' => true,
            ])
            ->add('numero', TextType::class, [
                'label' => 'Numero',
                'required' => true,
            ])
            ->add('bairro', TextType::class, [
                'label' => 'Bairro',
                'required' => true,
            ])
            ->add('cidade', ChoiceType::class, [
                'label' => 'Cidade',
                'choices' => CidadeEnum::getChoices(),
                'required' => true,
            ])
            ->add('pais', ChoiceType::class, [
                'label' => 'País',
                'choices' => NaturalidadeEnum::getChoices(),
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Endereco::class,
        ]);
    }
}
