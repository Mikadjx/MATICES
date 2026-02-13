<?php

namespace App\Command;

use App\Entity\Photo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(
    name: 'app:import-photos',
    description: 'Importer les photos depuis assets/images vers la galerie',
)]
class ImportPhotosCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        #[Autowire('%kernel.project_dir%')]
        private string $projectDir,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Import des photos MATICES');

        $sourceDir = $this->projectDir . '/assets/images';
        $uploadDir = $this->projectDir . '/public/uploads/photos';

        $filesystem = new Filesystem();
        $filesystem->mkdir($uploadDir);

        // Mapping des images vers les evenements (depuis l'ancien site HTML)
        $photoData = [
            // Concert chez Antoinette - Juin 2024
            'Image17.jpg' => ['event' => 'Concert chez Antoinette Orleans', 'date' => '2024-06-15', 'position' => 1],
            // Festival JANE - Septembre 2025
            'Image12.jpg' => ['event' => 'Festival JANE', 'date' => '2025-09-13', 'position' => 2],
            'Image15.jpg' => ['event' => 'Festival JANE', 'date' => '2025-09-13', 'position' => 3],
            'Image16.jpg' => ['event' => 'Festival JANE', 'date' => '2025-09-13', 'position' => 4],
            'Image11.jpg' => ['event' => 'Festival JANE', 'date' => '2025-09-13', 'position' => 5],
            'Image13.jpg' => ['event' => 'Festival JANE', 'date' => '2025-09-13', 'position' => 6],
            'Image2.jpg'  => ['event' => 'Festival JANE', 'date' => '2025-09-13', 'position' => 7],
            'Image7.jpg'  => ['event' => 'Festival JANE', 'date' => '2025-09-13', 'position' => 8],
            'Image14.jpg' => ['event' => 'Festival JANE', 'date' => '2025-09-13', 'position' => 9],
            // Autres photos de concerts
            'Image1.jpg'  => ['event' => 'MATICES en concert', 'date' => '2024-06-15', 'position' => 10],
            'Image3.jpg'  => ['event' => 'MATICES en concert', 'date' => '2024-06-15', 'position' => 11],
            'Image4.jpg'  => ['event' => 'MATICES en concert', 'date' => '2024-06-15', 'position' => 12],
            'Image5.jpg'  => ['event' => 'MATICES en concert', 'date' => '2024-06-15', 'position' => 13],
            'Image6.jpg'  => ['event' => 'MATICES en concert', 'date' => '2024-06-15', 'position' => 14],
            'Image8.jpg'  => ['event' => 'MATICES en concert', 'date' => '2024-06-15', 'position' => 15],
            'Image9.jpg'  => ['event' => 'MATICES en concert', 'date' => '2024-06-15', 'position' => 16],
            'Image10.jpg' => ['event' => 'MATICES en concert', 'date' => '2024-06-15', 'position' => 17],
            // Photos Facebook - 2023
            '355875752_106334775846701_9106880025713981085_n.jpg'              => ['event' => 'MATICES 2023', 'date' => '2023-07-01', 'position' => 18],
            '356881466_10229467044767914_5886892167337597107_n.jpg'            => ['event' => 'MATICES 2023', 'date' => '2023-07-01', 'position' => 19],
            '469018645_17926999868988152_7558610729275431209_n.jpg'            => ['event' => 'MATICES en concert', 'date' => '2024-10-01', 'position' => 20],
            '469018645_17926999868988152_7558610729275431209_n (1).jpg'        => ['event' => 'MATICES en concert', 'date' => '2024-10-01', 'position' => 21],
        ];

        $imported = 0;
        $skipped = 0;

        foreach ($photoData as $filename => $data) {
            $sourcePath = $sourceDir . '/' . $filename;

            if (!file_exists($sourcePath)) {
                $io->warning("Fichier introuvable: $filename");
                $skipped++;
                continue;
            }

            // Verifier si la photo existe deja en base
            $existing = $this->entityManager->getRepository(Photo::class)
                ->findOneBy(['imageName' => $filename]);

            if ($existing) {
                $io->text("  Deja en base: $filename");
                $skipped++;
                continue;
            }

            // Copier vers le dossier d'upload si pas deja present
            $destPath = $uploadDir . '/' . $filename;
            if (!file_exists($destPath)) {
                $filesystem->copy($sourcePath, $destPath);
            }

            // Creer l'entite Photo
            $photo = new Photo();
            $photo->setTitle($data['event'] . ' - ' . ($imported + 1));
            $photo->setImageName($filename);
            $photo->setEventName($data['event']);
            $photo->setEventDate(new \DateTime($data['date']));
            $photo->setPosition($data['position']);
            $photo->setIsVisible(true);
            $photo->setUpdatedAt(new \DateTimeImmutable());

            $this->entityManager->persist($photo);
            $imported++;
        }

        $this->entityManager->flush();

        $io->success("Import termine : $imported photos importees, $skipped ignorees.");

        return Command::SUCCESS;
    }
}
