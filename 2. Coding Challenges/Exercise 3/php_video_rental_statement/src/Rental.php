<?php

class Rental
{
    private $movie;
    private $daysRented;
	private $price; 

    public function __construct(Movie $movie, int $daysRented)
    {
        $this->movie = $movie;
        $this->daysRented = $daysRented;
		
		$this->price = $this->movie->getPrice( $daysRented );
		
		return $this;
    }

    public function getDaysRented(): int
    {
        return $this->daysRented;
    }

    public function getMovie(): Movie
    {
        return $this->movie;
    }
	
	public function getPrice(): float
	{
		return $this->price;
	}
}
