<?php

namespace ActivityTimetable\Form\Type;

use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @DI\Service("activity_timetable.form.type.task_get")
 * @DI\FormType
 *
 * @author Hessé <sylvain.carite@gmail.com>
 */
class TaskGetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('tasks', 'text')
                ->add('projects', 'text')
                ->add('dayStart', 'date', ['input'  => 'datetime', 'format' => 'yyyy-MM-dd', 'widget' => 'single_text'])
                ->add('dayEnd', 'date', ['input'  => 'datetime', 'format' => 'yyyy-MM-dd', 'widget' => 'single_text'])
                ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'        => 'ActivityTimetable\Form\Model\TaskGet',
            'csrf_protection'   => false
        ]);
    }

    public function getName()
    {
        return 'task_get';
    }
}
