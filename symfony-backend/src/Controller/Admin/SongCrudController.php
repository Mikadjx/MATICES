<?php

namespace App\Controller\Admin;

use App\Entity\Song;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichFileType;

class SongCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Song::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('title', 'Titre'),
            TextField::new('artist', 'Artiste / Groupe original'),
            ChoiceField::new('status', 'Statut')->setChoices([
                'En apprentissage' => 'learning',
                'Prêt' => 'ready',
                'Au répertoire' => 'repertoire',
            ]),
            Field::new('musicFile', 'Fichier MP3')
                ->setFormType(VichFileType::class)
                ->onlyOnForms(),
            TextField::new('filePath', 'Fichier audio')->onlyOnIndex(),
            IntegerField::new('duration', 'Durée (secondes)')->setRequired(false)->hideOnIndex(),
            TextareaField::new('notes', 'Notes')->setRequired(false)->hideOnIndex(),
            IntegerField::new('position', 'Position'),
            BooleanField::new('isVisible', 'Visible'),
        ];
    }
}
