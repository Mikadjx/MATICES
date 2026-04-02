<?php

namespace App\Controller\Admin;

use App\Entity\Video;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class VideoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Video::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('title', 'Titre'),
            TextField::new('youtubeId', 'ID YouTube')->setHelp('Ex: dQw4w9WgXcQ (la partie après v= dans l\'URL YouTube)'),
            TextField::new('eventName', 'Nom de l\'événement')->setRequired(false),
            DateField::new('eventDate', 'Date de l\'événement')->setRequired(false),
            TextareaField::new('description', 'Description')->setRequired(false)->hideOnIndex(),
            IntegerField::new('position', 'Position'),
            BooleanField::new('isVisible', 'Visible'),
        ];
    }
}
