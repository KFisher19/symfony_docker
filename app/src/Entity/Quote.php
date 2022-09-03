<?php

namespace App\Entity;  //шлях по якому можна получити доступ до файлу

use App\Repository\QuoteRepository;     //підключення зовнішніх файлів/класів/функцій
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\Traits\IdentifierTrait;

#[ORM\Entity(repositoryClass: QuoteRepository::class)]  //ормна анотація, позначає клас як сутність і відмічає
                                                        //хто буде управляти цією сутністю (QuoteRepository)
class Quote
{
    use IdentifierTrait;

    #[ORM\Id]       // назва колонки в таблиці
    #[ORM\GeneratedValue]   // значення автоматично генерується
    #[ORM\Column()]     //особливості даної колонки
    public ?int $id = null;   //ініціалізація властивості класу типу інт

    #[ORM\Column(type: Types::TEXT)]    //колонка типу текст
    #[Groups(['quotes', 'authors'])]   //колонка відноситься до груп 'quotes' і 'author' (пригодиться при виводі)
    public ?string $quote = null;

    #[ORM\Column(type: Types::TEXT)]
    public ?string $historian = null;

    #[ORM\Column(length: 5)]    //колонка розміром до 5 елементів (включно)
    #[Groups(['quotes', 'authors'])]
    public ?int $year = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['quotes'])]
    public ?string $address = null;

    #[ORM\ManyToOne(inversedBy: 'quotes', cascade:['persist'])]     //асоціативна колонка, містить в собі посилання на
    #[Groups(['quotes'])]                                           //обєкт іншої таблиці
    public ?DeathNote $quoteAuthor = null; //властивіть типу class, приймає обєкти класу DeathNote


    public function __construct(   //магічна функція конструктор, викликається при створенні нового обєкту,
                                string $quote = " ",    // в даному випадку приймає 4 параметра
                                string $historian = " ",    //від генератора (QuoteFixture)
                                int $year = 0,
                                string $address = " "
    )
    {
        $this->quote = $quote;  //присвоєння властивості quote обєкту який створюється(this) значення параметра quote
        $this->historian = $historian;
        $this->year = $year;
        $this->address = $address;
    }

    public function getQuote(): ?string
    {
        return $this->quote;
    }

    public function setQuote(string $quote): self //функція сеттер, встановлює значення параметра властивості quote
    {       //обєкта від якого викликається. Повертає цей же обєкт
        $this->quote = $quote;

        return $this;
    }

    public function getHistorian(): ?string
    {
        return $this->historian;
    }

    public function setHistorian(string $historian): self
    {
        $this->historian = $historian;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }


    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getQuoteAuthor(): ?DeathNote
    {
        return $this->quoteAuthor;
    }

    public function setQuoteAuthor(?DeathNote $quoteAuthor): self
    {
        $this->quoteAuthor = $quoteAuthor;

        return $this;
    }

   public function __toString(): string
   {
       return $this->id;
   }
}
