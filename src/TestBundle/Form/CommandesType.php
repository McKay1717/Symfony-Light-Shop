<?php

namespace TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class CommandesType extends AbstractType {
	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add ( 'prix' )->add ( 'dateAchat', DateTimeType::class, array (
				'placeholder' => array (
						'year' => 'Year',
						'month' => 'Month',
						'day' => 'Day',
						'hour' => 'Hour',
						'minute' => 'Minute',
						'second' => 'Second' 
				),
				'data' => new \DateTime()
		) )->add ( 'etat' )->add ( 'user' );
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults ( array (
				'data_class' => 'TestBundle\Entity\Commandes' 
		) );
	}

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'testbundle_commandes';
    }


}
