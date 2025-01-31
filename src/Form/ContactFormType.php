<?php

namespace App\Form;

use App\Model\MailMessage as ModelMailMessage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('sender', TextType::class, ['label' => 'Email'])
        ->add('object', TextType::class, [
            'label' => 'Objet'
        ])
        ->add('message', TextareaType::class, [
            'label' => 'Message',  
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ModelMailMessage::class
        ]);
    }
}
