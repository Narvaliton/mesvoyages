<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\DateTime;


/**
 * Description of ContactType
 *
 * @author maxco
 */
class ContactType extends AbstractType{
   public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('nom')
                ->add('email')
                ->add('message')
                ->add('submit', SubmitType::class, [
                'label' => 'Envoyer'
            ]);  
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
