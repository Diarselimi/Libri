<?php

namespace AppBundle\Form;

use AppBundle\Entity\UserBook;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('forSale')
            ->add('forExchange');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserBook::class
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_user_book_type';
    }
}
