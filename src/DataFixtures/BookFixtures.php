<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $book1 = new Book();
        $book1->setTitle('TitleBookOne');
        $book1->setAuthor('AuthorBookOne');
        $manager->persist($book1);

        $book2 = new Book();
        $book2->setTitle('TitleBookTwo');
        $book2->setAuthor('AuthorBookTwo');
        $manager->persist($book2);

        $book3 = new Book();
        $book3->setTitle('TitleBookThree');
        $book3->setAuthor('AuthorBookThree');
        $manager->persist($book3);

        $book4 = new Book();
        $book4->setTitle('AnotherBookFour');
        $book4->setAuthor('AuthorBookFour');
        $manager->persist($book4);

        $book5 = new Book();
        $book5->setTitle('AnotherBookFive');
        $book5->setAuthor('AuthorBookFive');
        $manager->persist($book5);

        $book6 = new Book();
        $book6->setTitle('AnotherBookSix');
        $book6->setAuthor('AuthorBookSix');
        $manager->persist($book6);

        $manager->flush();
    }
}
