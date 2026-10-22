<?php

declare(strict_types=1);

namespace Pyz\Zed\AntelopeGui\Communication\Form;

use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AntelopeCreateForm extends AbstractType
{
    public const string FIELD_NAME = 'name';
    public const string FIELD_FK_ANTELOPE_LOCATION = 'fkAntelopeLocation';

    public const string OPTION_ANTELOPE_LOCATION_CHOICES = 'antelope_location_choices';

    public function getBlockPrefix(): string
    {
        return 'antelope';
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // The choices are passed in by the factory, so the form itself never queries the database
        $resolver->setDefaults([
            static::OPTION_ANTELOPE_LOCATION_CHOICES => [],
        ]);
        $resolver->setAllowedTypes(static::OPTION_ANTELOPE_LOCATION_CHOICES, 'array');
    }

    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $this->addNameField($builder)
            ->addAntelopeLocationField($builder, $options[static::OPTION_ANTELOPE_LOCATION_CHOICES]);
    }

    protected function addNameField(FormBuilderInterface $builder): static
    {
        $builder->add(static::FIELD_NAME, TextType::class, [
            'label' => 'Name',
            'constraints' => [
                $this->createNotBlankConstraint(),
            ],
        ]);

        return $this;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array<string,int> $antelopeLocationChoices location name => id_location
     *
     * @return static
     */
    protected function addAntelopeLocationField(
        FormBuilderInterface $builder,
        array $antelopeLocationChoices
    ): static {
        $builder->add(static::FIELD_FK_ANTELOPE_LOCATION, ChoiceType::class, [
            'label' => 'Location',
            'choices' => $antelopeLocationChoices,
            'required' => false,
            'placeholder' => 'Select a location',
        ]);

        return $this;
    }

    protected function createNotBlankConstraint(): NotBlank
    {
        return new NotBlank();
    }
}
