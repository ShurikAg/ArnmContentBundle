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
class HtmlType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('html', 'textarea', array(
            'label' => 'text_widget.form.text.label',
            'attr' => array(
                'data-toggle' => 'popover',
                'content' => 'text_widget.form.text.help',
                'class' => 'form-control vertial-resize',
                'data-theme' => 'advanced',
                'rows' => '15',
                'ui-tinymce' => 'tinymceOptions',
                'ng-model' => 'wConfigForm.html',
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
        return 'html_widget';
    }

    /**
     * {@inheritdoc}
     * @see Symfony\Component\Form.AbstractType::setDefaultOptions()
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Arnm\ContentBundle\Model\HtmlWidget',
            'csrf_protection' => false
        ));
    }
}
