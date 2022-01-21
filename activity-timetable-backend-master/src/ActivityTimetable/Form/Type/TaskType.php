<?php

namespace ActivityTimetable\Form\Type;

use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @DI\Service("activity_timetable.form.type.task")
 * @DI\FormType
 *
 * @author Hessé <sylvain.carite@gmail.com>
 */
class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('project', 'entity', [ 'class' => 'ActivityTimetable\Entity\Project', 'property' => 'getId' ])
                ->add('duration', 'text')
                ->add('day', 'date', ['input'  => 'datetime', 'format' => 'yyyy-MM-dd', 'widget' => 'single_text'])
                ->add('description', 'text')
                ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'        => 'ActivityTimetable\Entity\Task',
            'csrf_protection'   => false,
        ]);
    }

    public function getName()
    {
        return 'task';
    }
}
