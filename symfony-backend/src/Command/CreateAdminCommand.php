<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-admin',
    description: 'Créer un utilisateur administrateur pour MATICES',
)]
class CreateAdminCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('🎸 Création d\'un administrateur MATICES');

        $email = $io->ask('Email de l\'administrateur', 'admin@matices.com');
        $password = $io->askHidden('Mot de passe (min 8 caractères)');
        
        if (strlen($password) < 8) {
            $io->error('Le mot de passe doit contenir au moins 8 caractères !');
            return Command::FAILURE;
        }

        $firstName = $io->ask('Prénom (optionnel)', null);
        $lastName = $io->ask('Nom (optionnel)', null);
        $instrument = $io->ask('Instrument (optionnel)', null);

        // Vérifier si l'email existe déjà
        $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
        
        if ($existingUser) {
            $io->warning('Un utilisateur avec cet email existe déjà !');
            $overwrite = $io->confirm('Voulez-vous le remplacer ?', false);
            
            if ($overwrite) {
                $this->entityManager->remove($existingUser);
                $this->entityManager->flush();
            } else {
                $io->info('Opération annulée.');
                return Command::SUCCESS;
            }
        }

        $user = new User();
        $user->setEmail($email);
        $user->setRoles(['ROLE_ADMIN']);
        
        if ($firstName) {
            $user->setFirstName($firstName);
        }
        
        if ($lastName) {
            $user->setLastName($lastName);
        }
        
        if ($instrument) {
            $user->setInstrument($instrument);
        }
        
        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success([
            'Administrateur créé avec succès !',
            '',
            'Email: ' . $email,
            'Rôle: ADMIN',
            '',
            'Vous pouvez maintenant vous connecter sur /admin'
        ]);

        return Command::SUCCESS;
    }
}