<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       /* $builder
            ->add('name', TextType::class, [
                'label' => 'form.username'
            ])
            ->add('slug', null, [
                'required' => false,
                'label' => 'form.slug'
            ])
            ->add('content', null, [
                'label' => 'form.content'
            ])
            ->add('user', null, [
                'label' => 'form.user'
            ]);
		*/	
			/*$builder
			
            ->add('content', null, [
                'label' => 'New Post'
            ]);*/
			
			
			$builder->add('content', null, array(
				'attr' => array('maxlength' => 140),'label' => 'New Post',
			));
			
						
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Post'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return null;
    }


}
