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

class CommentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comment', TextType::class, [
                'attr' => ['autofocus' => true],
                'label' => 'Escribe aqui tu comentario',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('publicar', SubmitType::class,
                ['label'=>'Publicar',
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
        $resolver->setDefaults(['data_class'=>'App\Entity\Comment']);

    }
}