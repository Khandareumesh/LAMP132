<?php

namespace ActivityTimetable\Form\Type;

use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @DI\Service("activity_timetable.form.type.project_get")
 * @DI\FormType
 *
 * @author Hessé <sylvain.carite@gmail.com>
 */
class ProjectGetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'        => 'ActivityTimetable\Form\Model\ProjectGet',
            'csrf_protection'   => false
        ]);
    }

    public function getName()
    {
        return 'project_get';
    }
}
