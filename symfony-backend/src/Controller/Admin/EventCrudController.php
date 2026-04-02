<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name', 'Nom de l\'événement'),
            DateField::new('eventDate', 'Date'),
            TextField::new('location', 'Lieu'),
            ChoiceField::new('type', 'Type')->setChoices([
                'Concert' => 'concert',
                'Répétition' => 'repetition',
                'Festival' => 'festival',
                'Privé' => 'prive',
                'Autre' => 'autre',
            ]),
            TextareaField::new('description', 'Description')->setRequired(false)->hideOnIndex(),
            IntegerField::new('position', 'Position'),
            BooleanField::new('isVisible', 'Visible'),
        ];
    }
}
