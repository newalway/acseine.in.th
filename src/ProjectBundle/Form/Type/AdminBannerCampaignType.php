<?php

namespace ProjectBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

use ProjectBundle\Entity\BannerCampaign;
use Doctrine\ORM\EntityRepository;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdminBannerCampaignType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, array(
                        'attr' => array('class' => 'form-control'),
                        'required' => false,
                        'constraints' => array(
                            new NotBlank(array('message' => 'Please enter title')))
        ));

        $builder->add('image', TextType::class, array(
                        'attr' => array('class' => 'form-control'),
                        'required' => false,
                        'constraints' => array(
                            new NotBlank(array('message' => 'Please enter image')))
        ));

        $builder->add('image_mobile', TextType::class, array(
                        'attr' => array('class' => 'form-control'),
                        'required' => false,
                        'constraints' => array(
                            new NotBlank(array('message' => 'Please enter image mobile')))
        ));

        $builder->add('website', TextType::class, array(
                        'attr' => array('class' => 'form-control'),
                        'required' => false,
                        'attr' => array('placeholder' => 'https://www.acseine.in.th'),
        ));

        $builder->add('public_date', DateType::class, array(
                        'required' => true,
                        'input'  => 'datetime',
                        'widget' => 'single_text',
                        'attr' => array('class' => 'form-control-static'),
                        'constraints' => array(
                            new NotBlank(array('message' => 'Enter a publish date')))
        ));

        $builder->add('status', ChoiceType::class, array(
                        'choices' => array('Publish' => '1', 'Unpublish' => '0'),
                        'expanded' => true,
                        'multiple' => false,
                        'attr' => array('class' => 'form-control-static'),
                        'constraints' => array(
                            new NotBlank(array('message' => 'Enter a status')))
        ));

        $builder->add('save_and_add', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
        $builder->add('save_and_edit', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
        $builder->add('save', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
    }

}
