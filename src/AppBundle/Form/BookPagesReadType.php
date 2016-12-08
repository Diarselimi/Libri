<?php

namespace AppBundle\Form;

use AppBundle\Entity\UserBookShelf;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookPagesReadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('pages', NumberType::class, [
            'attr' => [
                'class' => 'form-control'
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserBookShelf::class
        ]);
    }

    public function getName()
    {
        return 'app_bundle_book_pages_read_type';
    }
}
