<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use FOS\CKEditorBundle\Config\CKEditorConfiguration;
use App\Form\Type\TagsInputType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditPostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                'attr' => ['autofocus' => true],
                'label' => 'Title',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('content', null, [
                'attr' => ['rows' => 20],
                'label' => 'Contents',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('tags', TagsInputType::class, [
                'label' => 'Tags',

                'required' => false,
                'attr'=>[
                    'data-role'=>'tagsinput',
                    'class'=>'form-control'
                ]
            ])
            ->add('Signup', SubmitType::class,
                ['label'=>'Save',
                    'attr'=>[
                        'class'=>'form-submit btn btn-success'
                    ]])
        ;
    }



    /**
     * {@inheritdoc}
     */

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>'App\Entity\Post']);

    }
}