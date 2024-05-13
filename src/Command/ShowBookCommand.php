<?php

namespace App\Command;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Completion\CompletionInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:show-book',
    description: 'Show details of a book',
)]
class ShowBookCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument(
                'title', 
                InputArgument::IS_ARRAY|InputArgument::REQUIRED, 
                'Book\'s title',
                null,
                function (CompletionInput $input): array {
                    $completionValue = $input->getCompletionValue();

                    $suggestedBooksTitle = $this->entityManager
                        ->getRepository(Book::class)
                        ->findBookStartingWith($completionValue)
                    ;

                    return $suggestedBooksTitle;
                }
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $title = $input->getArgument('title');

        if ($title) {
            $io->note(sprintf('You passed the title: %s', $title[0]));
        }

        $book = $this->entityManager->getRepository(Book::class)->findOneBy([
            'title' => $title[0]
        ]);

        if (null === $book) {
            $io->error('The book does not exist.');
            return Command::FAILURE;
        }

        $title = $book->getTitle();
        $author = $book->getAuthor();

        $output->writeln(sprintf(
            'The book\'s title is %s and his author is %s', 
            $title, 
            $author
        ));

        $io->success('You successfully retrieved the book\'s details');

        return Command::SUCCESS;
    }
}
