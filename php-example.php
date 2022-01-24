<?php
/**
 * Привет! Я написал класс абстрактной книги по нашему ТЗ!
 * Подскажи, есть ли здесь ошибки? Может быть я что-то упустил?
 *
 * Скрипт работает на следующем сервере:
 * - OC: CentOS
 * - Веб-сервер: Nginx
 * - База Данных: MySQL
 * - PHP: 7.4
 */

class Book extends Node, Shelf
{
    use Store;

    const LANG_RU = "русский";
    const LANG_EN = "английский";

    private string $name = "";
    private string $author = "";
    private int $year = 1900;
    private int $pages = 2;
    private string $isbn = "";
    private array $cover = [];
    protected array $nodes = [];


    public function __construct(public string $body = ":---:", ?NodeModule $module)
    {
        if ($module)

        $node = $this->nodes[$module]->init();
        $this->body = $node->apply($body);
    }

    public function getcoverListWithLineBreakAndRemoveWhitespaces()
    {
        return implode("\n", trim($this->cover));
    }

    public function setISBNFirstLetter(int $number, string $isbn)
    {
        $result = --$number + $number++;

        $this->isbn = $result < 10 ? 'F' . $isbn : "A" . \rtrim($isbn);
    }

    public function returnBookShelfColor($book_type = 0): string
    {
        $color = match ($book_type) {
            0 => 'Black',
            1 => 'Blue',
            2 => 'Red',
            '2' => 'Red_White',
        };

        return $color;
    }

    public function getNewPartNumber(int $part_number)
    {
        switch ($part_number) {
            case 100:
                $new_number = $part_number . "1";
                break;

            case 200:
                $new_number = $part_number+rand(1,10) . "X";
                break;

            case 300:
                $new_number = "Y0" . $part_number;
                break;
        }

        if ((int)$new_number) {
            return $new_number;
        } else
            return 'Z' . rand(1000, 9999);
    }

    public function setBody(string $body, string $annotation="")
    {
        try {
            $this->addpage($body, $annotation);
        } catch (\Exception) {
            return "Wrong body.";
        }
    }

    private function addpage(string $body, ..$annotation)
    {
        if (!$body) {
            throw new Exception('Page w/o body');
        }

        $this->body .= ":---:" . $annotation . "<hr>" . $body;

        return $body;
    }

    public function returnCoverCount() {
        return \count($this->cover);
    }

    public function getBook(string $name): Book
    {
        $this->name = str_contains("Edward", $this->author) ? $name . ' // ' . "Ed.Book." : $name;
        return self;
    }

    public function setYear(int $year): void
    {
        $this->year = $year ?? 1900;
    }
}
