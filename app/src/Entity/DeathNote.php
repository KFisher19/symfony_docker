<?php

namespace App\Entity;

use App\Entity\Traits\IdentifierTrait;
use App\Repository\DeathNoteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DeathNoteRepository::class)]
class DeathNote
{
    use IdentifierTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    public ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['quotes', 'authors'])]
    public ?string $name = null;

    #[ORM\Column(length: 5)]
    #[Groups(['quotes', 'authors'])]
    public ?int $bornYear = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['authors'])]
    public ?string $cityOfBorn = null;

    #[ORM\Column(length: 5)]
    #[Groups(['authors'])]
    public ?int $deadYear = null;

    #[ORM\Column(type: Types::TEXT)]
    public ?string $cityOfDead = null;

    #[ORM\Column(length: 5)]
    #[Groups(['authors'])]
    public ?int $age = null;

    #[ORM\Column(length: 5)]
    #[Groups(['authors'])]
    public ?int $deadNYearsAgo = null;

    #[ORM\Column(length: 5)]
    public ?int $now = null;

    #[ORM\OneToMany(mappedBy: 'quoteAuthor', targetEntity: Quote::class)]
    #[Groups(['authors'])]
    public Collection $quotes;  //змінна типу колекція, шось типу масива но крутіше

    #[Pure]
    public function __construct(
        string $Name,
        int $born_year,
        string $city_of_born,
        int $dead_year,
        string $city_of_dead
    )
    {
        $this->name         = $Name;
        $this->cityOfBorn = $city_of_born;
        $this->cityOfDead = $city_of_dead;
        $this->bornYear    = $born_year;

        if ($born_year > $dead_year){  //якщо при генерації час смерті наступив до народження, то приймаємо що чєл
            $this->age       = 0;      // помер при народженні
            $this->deadYear = $born_year;
        }
        else{
            $this->deadYear = $dead_year;
            $this->age       = $dead_year - $born_year;
        }

        $this->now = date('Y');  //властивість принімає час серверу у форматі 'Y', тобто тільки рік
        $this->deadNYearsAgo = $this->now - $this->deadYear;
        $this->quotes = new ArrayCollection();
    }


    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBornYear(): ?int
    {
        return $this->bornYear;
    }

    public function setBornYear(int $bornYear): self
    {
        $this->bornYear = $bornYear;

        return $this;
    }

    public function getCityOfBorn(): ?string
    {
        return $this->cityOfBorn;
    }

    public function setCityOfBorn(string $cityOfBorn): self
    {
        $this->cityOfBorn = $cityOfBorn;

        return $this;
    }

    public function getDeadYear(): ?int
    {
        return $this->deadYear;
    }

    public function setDeadYear(int $deadYear): self
    {
        $this->deadYear = $deadYear;

        return $this;
    }

    public function getCityOfDead(): ?string
    {
        return $this->cityOfDead;
    }

    public function setCityOfDead(string $cityOfDead): self
    {
        $this->cityOfDead = $cityOfDead;

        return $this;
    }

    public function getAge(): ?int
    {
        if ($this->bornYear > $this->deadYear)
            $this->age = 0;
        else
            $this->age = $this->deadYear - $this->bornYear;
        return $this->age;
    }

    public function setAge(int $born_year, int $dead_year): self
    {
        if ($born_year > $dead_year)
            $this->age = 0;
        else
            $this->age = $dead_year - $born_year;

        return $this;
    }
    public function getDeadNYearsAgo(): ?int
    {
        $this->deadNYearsAgo = (int)date('Y') - $this->deadYear;
        return $this->deadNYearsAgo;
    }

    public function getNow(): ?int
    {
        $this->now = date('Y');
        return $this->now;
    }


    /**
     * @return Collection<int, Quote>
     */
    public function getQuotes(): Collection
    {
        return $this->quotes;
    }

    public function addQuote(Quote $quote): self//функція додавання посилань на цитати, які відносяться до даного автора
    {                                           //крім випадків коли вона вже є в колекції
        if (!$this->quotes->contains($quote)) {
            $this->quotes->add($quote);
            $quote->setQuoteAuthor($this);
        }

        return $this;
    }

    public function removeQuote(Quote $quote): self //видалення елементу з колекції і видалення посилання на цей обєкт
    {                           //в обєкті цитати
        if ($this->quotes->removeElement($quote)) {
            // set the owning side to null (unless already changed)
            if ($quote->getQuoteAuthor() === $this) {
                $quote->setQuoteAuthor(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
