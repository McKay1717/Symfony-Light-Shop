<?php

namespace TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use ZipCodeValidator\Constraints\ZipCode;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;

class UsersType extends AbstractType {
	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add ( 'email' )->add ( 'password', PasswordType::class )->add ( 'login' )->add ( 'nom' )->add ( 'codePostal', TextType::class, array (
				'constraints' => array (
						new ZipCode ( array (
								'iso' => 'FR' 
						) ) 
				) 
		) )->add ( 'ville' )->add ( 'adresse' )->add ( 'valide' )->

		add ( 'droit', ChoiceType::class, array (
				'choices' => array (
						'' => null,
						'Admin' => "ROLE_ADMIN",
						'Client' => "ROLE_CLIENT" 
				) 
		) )->add('recaptcha', EWZRecaptchaType::class);
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults ( array (
				'data_class' => 'TestBundle\Entity\Users' 
		) );
	}


	
	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function getBlockPrefix() {
		return 'testbundle_users';
	}
}
