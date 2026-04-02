<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            EmailField::new('email', 'Email'),
            TextField::new('firstName', 'Prénom')->setRequired(false),
            TextField::new('lastName', 'Nom')->setRequired(false),
            TextField::new('instrument', 'Instrument')->setRequired(false),
            ChoiceField::new('roles', 'Rôles')
                ->setChoices(['Administrateur' => 'ROLE_ADMIN', 'Membre' => 'ROLE_USER'])
                ->allowMultipleChoices()
                ->renderExpanded(false),
        ];
    }
}
