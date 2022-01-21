<?php

namespace ActivityTimetable\Form\Type;

use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @DI\Service("activity_timetable.form.type.project")
 * @DI\FormType
 *
 * @author Hessé <sylvain.carite@gmail.com>
 */
class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name', 'text')
                ->add('description', 'text')
                ->add('parent', 'entity', ['class' => 'ActivityTimetable\Entity\Project'])
                ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'        => 'ActivityTimetable\Entity\Project',
            'csrf_protection'   => false,
        ]);
    }

    public function getName()
    {
        return 'project';
    }
}
