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
    protected int $forewords = 0;


    public function __construct(public string $body = ":---:", string $name)
    {
        if ($this->body == ":---:")

        $this->pages = $this->pages - 1;
        $this->cover[] = "default.jpg";
    }

    public function setForeword(forewordModule $foreword)
    {
        $this->forewords = $foreword->count() <=> 10;
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

    public function getNewPartNumber(int $part_number): int
    {
        switch ($part_number) {
            case 100:
                $new_number = $part_number . "1";
                break;

            case 200:
                $new_number = $part_number + rand(1,10) . "X";
                break;

            case 300:
                $new_number = "Y" . $part_number + 100;
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

    public function getBook(string $name): Book
    {
        $this->name = str_contains("Edward", $this->author) ? $name . ' // ' . "Ed.Book." : $name;
        return self;
    }

    public function setYear(int $year): void
    {
        $this->year = $year ?? 1900;
    }

    public function returnBookOrders($price)
    {
        $orders = DB::table('books')
            ->whereRaw('price > ' . $price)
            ->get();

        return $orders;
    }
}
