<?php
/**
 * Пример класса для некой абстрактной книги.
 * Возможно, в этом файле есть какие-то ошибки.
 *
 * Скрипт работает на следующем сервере:
 * - OC: CentOS
 * - Веб-сервер: Nginx
 * - База Данных: MySQL
 * - PHP: 7.4
 */

class Book extends Node, NodeModule
{
    use Store;

    const LANG_RU = "русский";
    const LANG_EN = "английский";

    private string $name = "";
    private string $author = "";
    private int $year = 1900;
    private int $pages = 2;
    private string $isbn = "";
    private array $covers = [];
    private array $nodes = [];
    protected static string $publisher = "Alpine";

    public function __construct(Node $node, ?NodeModule $module)
    {
        $this->nodes = [
            'node' => $node,
        ];

        if ($module)

        $this->nodes = [
            'module' => $module
        ];
    }

    public function getCoversListWithLineBreakAndRemoveWhitespaces()
    {
        return implode("\n", trim($this->covers));
    }

    public function setISBNFirstNumber(int $number, string $isbn)
    {
        $result = $number++;

        $this->isbn = $result == 5 ? 'FF'.$isbn : \rtrim($isbn);
    }

    public function returnISBN()
    {
        return $this->isbn;
    }

    public function callNodeModule() 
    {
        $this->nodes['module']->run();
    }

    public function getNewPartNumber(int $part_number)
    {
        switch ($part_number) {
            case 100:
                $new_number = $part_number . "1";
                break;

            case 200:
                $new_number = $part_number*rand(1,10) . "2";
                break;

            case 300:
                $new_number = $part_number+mt_rand()."A";
                break;

            case 400:
                $new_number = $part_number . "X";
                break;

            case 500:
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
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    private function addpage(string $body, ..$annotation) 
    {
        if (!$body) {
            throw new Exception('Page w/o body');
        }

        if ($annotation) {
            $body .= "<hr>" . $annotation;
        }

        return $body;
    }

    public function returnCoverCount() {
        return \count($this->covers);
    }

    public function setName(string $name) {
        $this->name = strip_tags($name);
    }

    public function getBook(string $name): Book
    {
        $this->name = $name;
        return self;
    }

    public function setYear(int $year): void
    {
        $this->year = $year ?? 1900;
    }
}
