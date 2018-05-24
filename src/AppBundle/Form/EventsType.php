<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var User */
        $user = $options['user'];

        dump($user->getRoles());

        $builder->add('name')
            ->add('location')
            ->add('description', TextareaType::class)
            ->add('dateOpen', DateTimeType::class, [
                'years' => (function() {
                    $currentYear = date('Y');
                    $validYear = [];
                    for ($i = $currentYear-1; $i < $currentYear +5; $i++) {
                        $validYear[] = $i;
                    }
                    return $validYear;
                })()
            ]);
        if (in_array('ROLE_GROUP', $user->getRoles())) {
            $builder->add('standsMaxNumber')
                ->add('duration');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Events',
            'user' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_events';
    }


}
