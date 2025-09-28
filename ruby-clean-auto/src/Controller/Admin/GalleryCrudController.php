<?php

namespace App\Controller\Admin;

use App\Entity\Gallery;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FileUploadField;
use Symfony\Component\Validator\Constraints\File;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints\Choice;

class GalleryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Gallery::class;
    }

    public function configureFields(string $pageName): iterable
    {
      
        yield ImageField::new('imageFilename', 'Aperçu')
            ->setBasePath('uploads/gallery')
            ->setTemplatePath('admin/fields/gallery_preview.html.twig')
            ->onlyOnIndex(); 
        yield TextField::new('title');
        yield TextareaField::new('description')->hideOnIndex();

        yield ChoiceField::new('type')
            ->setChoices(array_combine(Gallery::TYPES, Gallery::TYPES));

        yield ChoiceField::new('category')
            ->setChoices(array_combine(Gallery::CATEGORIES, Gallery::CATEGORIES))
            ->setRequired(true);


        yield Field::new('videoFile')
            ->setLabel('Vidéo MP4')
            ->setFormType(FileType::class)
            ->setRequired(false)
            ->setFormTypeOptions([
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '50M',
                        'mimeTypes' => ['video/mp4'],
                        'mimeTypesMessage' => 'Merci de télécharger une vidéo au format MP4 uniquement.',
                    ]),
                ],
                'attr' => [
                'accept' => 'video/mp4',
                'class' => 'field-video', // pour JS
                ],
            ]);

        // Champ pour uploader l'image (non mappé)
        yield Field::new('imageFile')
            ->setLabel('Image WebP')
            ->setFormType(FileType::class)
            ->setRequired(false)
            ->setFormTypeOptions([
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => ['image/webp'],
                        'mimeTypesMessage' => 'Merci de télécharger une image au format WebP uniquement.',
                    ]),
                ],
                'attr' => [
                'accept' => 'image/webp',
                'onchange' => 'previewImage(this)', // Appelle la fonction JS
                ],
            ]);

            yield ChoiceField::new('nettoyageNumber')
                ->setLabel('Réalisation')
                ->setChoices([
                    'Réalisation 1' => 1,
                    'Réalisation 2' => 2,
                    'Réalisation 3' => 3,
                    'Réalisation 4' => 4,
                ])
                ->setRequired(false);

            yield ChoiceField::new('photoType')
                ->setLabel('Type de photo/vidéo')
                ->setChoices([
                    'Avant' => 'avant',
                    'Après' => 'apres',
                ])
                ->setRequired(false);

        yield DateTimeField::new('createdAt')->onlyOnIndex();

       
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
{
    if (!$entityInstance instanceof Gallery) return;

    $entityInstance->setCreatedAt(new \DateTime());

    $request = $this->getContext()->getRequest();
    $type = $entityInstance->getType();

    $uploadedImage = $request->files->get('Gallery')['imageFile'] ?? null;
    $uploadedVideo = $request->files->get('Gallery')['videoFile'] ?? null;

    if ($type === 'photo' && $uploadedImage) {
        $newFilename = uniqid() . '.webp';
        $uploadedImage->move(
            $this->getParameter('kernel.project_dir') . '/public/uploads/gallery',
            $newFilename
        );
        $entityInstance->setImageFilename($newFilename);
    }

    if ($type === 'video' && $uploadedVideo) {
        $newFilename = uniqid() . '.mp4';
        $uploadedVideo->move(
            $this->getParameter('kernel.project_dir') . '/public/uploads/gallery',
            $newFilename
        );
        $entityInstance->setImageFilename($newFilename);
    }

    parent::persistEntity($entityManager, $entityInstance);
}

public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
{
    if (!$entityInstance instanceof Gallery) return;

    $request = $this->getContext()->getRequest();
    $type = $entityInstance->getType();

    $uploadedImage = $request->files->get('Gallery')['imageFile'] ?? null;
    $uploadedVideo = $request->files->get('Gallery')['videoFile'] ?? null;

    if ($type === 'photo' && $uploadedImage) {
        $newFilename = uniqid() . '.webp';
        $uploadedImage->move(
            $this->getParameter('kernel.project_dir') . '/public/uploads/gallery',
            $newFilename
        );

        $oldFilename = $entityInstance->getImageFilename();
        if ($oldFilename) {
            $oldFilePath = $this->getParameter('kernel.project_dir') . '/public/uploads/gallery/' . $oldFilename;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        $entityInstance->setImageFilename($newFilename);
    }

    if ($type === 'video' && $uploadedVideo) {
        $newFilename = uniqid() . '.mp4';
        $uploadedVideo->move(
            $this->getParameter('kernel.project_dir') . '/public/uploads/gallery',
            $newFilename
        );

        $oldFilename = $entityInstance->getImageFilename();
        if ($oldFilename) {
            $oldFilePath = $this->getParameter('kernel.project_dir') . '/public/uploads/gallery/' . $oldFilename;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        $entityInstance->setImageFilename($newFilename);
    }

    parent::updateEntity($entityManager, $entityInstance);
}
}
