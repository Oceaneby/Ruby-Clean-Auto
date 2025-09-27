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
        yield ImageField::new('imageFilename')
            ->setBasePath('uploads/gallery')
            ->onlyOnIndex(); // ou ->onlyOnDetail() pour l’affichage dans la page de détails
        yield TextField::new('title');
        yield TextareaField::new('description')->hideOnIndex();

        yield ChoiceField::new('type')
            ->setChoices(array_combine(Gallery::TYPES, Gallery::TYPES));

        yield ChoiceField::new('category')
            ->setChoices(array_combine(Gallery::CATEGORIES, Gallery::CATEGORIES))
            ->setRequired(true);

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
                ->setRequired(true);

            yield ChoiceField::new('photoType')
                ->setLabel('Type de photo')
                ->setChoices([
                    'Avant' => 'avant',
                    'Après' => 'apres',
                ])
                ->setRequired(true);

        yield DateTimeField::new('createdAt')->onlyOnIndex();
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Gallery) return;

        $entityInstance->setCreatedAt(new \DateTime());

        // Gérer le fichier uploadé manuellement
        $uploadedFile = $this->getContext()->getRequest()->files->get('Gallery')['imageFile'] ?? null;

        if ($uploadedFile) {
            $originalName = $uploadedFile->getClientOriginalName();
            $newFilename = uniqid().'.webp';

            $uploadedFile->move(
                $this->getParameter('kernel.project_dir').'/public/uploads/gallery',
                $newFilename
            );

            $entityInstance->setImageFilename($newFilename);
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
{
    if (!$entityInstance instanceof Gallery) return;

    // Récupérer le fichier uploadé (si présent)
    $uploadedFile = $this->getContext()->getRequest()->files->get('Gallery')['imageFile'] ?? null;

    if ($uploadedFile) {
        $newFilename = uniqid().'.webp';

        $uploadedFile->move(
            $this->getParameter('kernel.project_dir').'/public/uploads/gallery',
            $newFilename
        );

        // Supprimer l'ancienne image si besoin (optionnel)
        $oldFilename = $entityInstance->getImageFilename();
        if ($oldFilename) {
            $oldFilePath = $this->getParameter('kernel.project_dir').'/public/uploads/gallery/'.$oldFilename;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        $entityInstance->setImageFilename($newFilename);
    }

    parent::updateEntity($entityManager, $entityInstance);
}
}
