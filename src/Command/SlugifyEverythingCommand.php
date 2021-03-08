<?php

namespace App\Command;

use App\Entity\Car;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SlugifyEverythingCommand extends Command
{
    protected static $defaultName = 'app:slugify-everything';
    protected static $defaultDescription = 'Add slugs for all cars based on make and model';

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $repo = $this->em->getRepository(Car::class);

        $cars = $repo->findAll();

        foreach ($cars as $car){
            $car->setSlug(strtolower(str_replace(" ", "-", $car->getMake() . " " . $car->getModel())) . "-" . uniqid());
            $this->em->persist($car);
        }

        $this->em->flush();

        $io->success('All cars now have slugs!');

        return 0;
    }
}
