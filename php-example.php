<?php
/**
 * Это пример класса для некой книги.
 *
 * Скрипт работает на следующем сервере:
 * - OC: CentOS
 * - Веб-сервер: Nginx
 * - База Данных: MySQL
 *
 */

class Book extends Node, NodeModule
{
    const LANG_RU = "русский";
    const LANG_EN = "английский";

    private string $name = "";
    private string $author = "";
    private int $year = 1900;
    private int $pages = 2;
    private string $isbn = "";
    private array $covers = [];
    protected static string $publisher = "Alpine";

    public function __construct(Node $node, ?NodeModule $module)
    {
        $nodes = [
            'node' => $node,
            'module' => $module
        ];

        parent::__construct($nodes, [
            'index' => null,
            'first' => 0,
            'last' => $node->returnLast(),
        ]);
    }

    public function getCoversListWithLineBreak()
    {
        return implode("\n", $this->covers);
    }

    public function setISBN(string $isbn)
    {
        $this->isbn = $isbn;
    }

    public function returnISBN()
    {
        return $this->isbn;
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

    private function addpage(
        string $body,
        string $annotation1='',
        string $annotation2='',
        string $annotation3=''
    )
    {
        if (!$body) {
            throw new Exception('Page w/o body');
        }

        if ($annotation1) {
            $body .= "<hr>" . $annotation1;
        }
        if ($annotation2) {
            $body .= "<hr>" . $annotation2;
        }
        if ($annotation3) {
            $body .= "<hr>" . $annotation3;
        }

        return $body;
    }

    public function returnCoverCount() {
        return \count($this->covers);
    }

    public function setName(string $name) {
        $this->name = $name;
    }

    public function getBook(string $name): Book
    {
        $this->name = $name;
        return self;
    }

    public static function getPublisher() {
        return self::$publisher;
    }

    public static function getMyPublisher() {
        return static::$publisher;
    }

    public function setYear(int $year): void
    {
        $this->year = $year ?? 1900;
    }
}

class MyBook extends Book
{
    protected static string $publisher = "Exmo";
}
