<?php
namespace Arnm\ContentBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
/**
 * Template form use to manage Templates as well as gets embedded into page form
 *
 * @author Alex Agulyansky <alex@iibspro.com>
 */
class TextType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('text', 'textarea', array(
            'label' => 'text_widget.form.text.label',
            'attr' => array(
                'data-toggle' => 'popover',
                'content' => 'text_widget.form.text.help',
                'class' => 'form-control vertial-resize',
                'rows' => '15',
                'ng-model' => 'wConfigForm.text',
                'translation_domain' => 'text_widget'
            ),
            'translation_domain' => 'text_widget',
            'required' => false
        ));
    }

    /**
     * {@inheritdoc}
     * @see Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'text_widget';
    }

    /**
     * {@inheritdoc}
     * @see Symfony\Component\Form.AbstractType::setDefaultOptions()
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Arnm\ContentBundle\Model\TextWidget',
            'csrf_protection' => false
        ));
    }
}
