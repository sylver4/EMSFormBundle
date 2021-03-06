<?php

namespace EMS\FormBundle\Components\Form;

use EMS\FormBundle\Components\EventSubscriber\NestedChoiceEventSubscriber;
use EMS\FormBundle\Components\Field\ChoiceSelect;
use EMS\FormBundle\Components\Form;
use EMS\FormBundle\FormConfig\FieldConfig;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NestedChoiceType extends Form
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var FieldConfig $config */
        $config = $this->getFieldConfig($options);
        $config->setClassName(ChoiceSelect::class);
        $choices = $config->getChoices();
        $field = $this->createField($config);

        $builder->add('level_0', $field->getFieldClass(), $field->getOptions());

        if (null === $choices) {
            return;
        }
        $builder->addEventSubscriber(new NestedChoiceEventSubscriber($field, $choices));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['field_config'] = $options['field_config'];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired(['field_config'])
            ->setAllowedTypes('field_config', FieldConfig::class)
        ;
    }

    private function getFieldConfig(array $options): FieldConfig
    {
        if (isset($options['field_config'])) {
            return $options['field_config'];
        }

        throw new \Exception('Could not build form, nested choice field config missing!');
    }

    public function getParent()
    {
        return FormType::class;
    }

    public function getBlockPrefix()
    {
        return 'ems_nested_choice';
    }
}
