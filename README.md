## Installation

* Configure the .env file changing the following line for a PostgreSQL database for example:
```bash
DATABASE_URL="postgresql://postgres:your-postgresql-local-password@127.0.0.1:5432/bugcompletiondb?serverVersion=16&charset=utf8"
```

* Create the database and load the fixtures: 
```bash
php bin/console doctrine:database:create
php bin/console doctrine:database:load
```

## To reproduce the bug

* Test the command to see that the command works well with existing titles like TitleBookOne or AnotherBookFour:
```bash
php bin/console app:show-book TitleBookOne
```

* Test the command to see that the suggested titles don't appear:
```bash
php bin/console app:show-book Title
```
then type the TAB button twice. Nothing appear.

## Note

The suggested book that must appear depending on the starting title you enter:

* For Title

```php
$suggestedBook = $this->entityManager->getRepository(Book::class)->findBookStartingWith('Title');
dd($suggestedBook);
=>
^ array:3 [
  0 => "TitleBookOne"
  1 => "TitleBookTwo"
  2 => "TitleBookThree"
]
```

* For Another

```php
$suggestedBook = $this->entityManager->getRepository(Book::class)->findBookStartingWith('Another');
dd($suggestedBook);
=>
^ array:3 [
  0 => "AnotherBookFour"
  1 => "AnotherBookFive"
  2 => "AnotherBookSix"
]
```