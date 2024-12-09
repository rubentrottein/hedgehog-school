<?php

namespace App\Form;

use http\Env\Request;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerInterface;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => ["placeholder" => "Titre du tutoriel"]
            ])
            ->add('image', TextType::class, [
                'attr' => ["placeholder" => "Adresse de l'image"]
            ])
            ->add('alt', TextType::class, [
                'attr' => ["placeholder" => "Description de l'image"]
            ])
            ->add('intro', TextareaType::class, [
                'attr' => ["placeholder" => "Introduction du chapitre"]
            ])
            ->add('content', TextareaType::class, [
                'attr' => ["placeholder" => "Contenu général (WIP)"]
            ])
            ->add('category', TextType::class, [
                'attr' => ["placeholder" => "Catégorie"]
            ])
            ->add('chapters', IntegerType::class, [
                'attr' => ["placeholder" => "Chapitres"],
            ])
            ->add('chaptersTitles', CollectionType::class, [
                'entry_options' => [
                    'attr' => ["placeholder" => "Titre des chapitres"]
                ],
                'entry_type' => TextType::class,
                'allow_add' => true,
            ])
            ->add('chaptersContent', CollectionType::class, [
                'entry_options' => [
                    'attr' => ["placeholder" => "Contenu des chapitres"]
                ],
                'entry_type' => TextareaType::class,
                'allow_add' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Pas de modèle de données pour ce formulaire
            'data_class' => null,
        ]);
    }

    // ...

    public function createArticle(HtmlSanitizerInterface $htmlSanitizer, Request $request): Response
    {
        $unsafeContents = $request->getPayload()->get('post_contents');

        $safeContents = $htmlSanitizer->sanitize($unsafeContents);
        // ... proceed using the safe HTML
    }
}