<?php

class Movie 
{
	
    private $title;
	private $pricing;
	private $classification;

    public function __construct(string $title, string $classification, Pricing $pricing )
    {
        $this->title = $title;
		$this->classification = $classification;
		$this->pricing = $pricing;
    }

	public function getClassification()
	{
		return $this->classification;
	}
	
    public function getPrice(int $daysRented): float
    {
		
		if( $daysRented <= $this->pricing->getDaysIncluded() )
			return $this->pricing->getInitialPrice();
		
		$extendedPrice = ( $daysRented - $this->pricing->getDaysIncluded() ) * $this->pricing->getExtendedPrice();
		
		return ( $this->pricing->getInitialPrice() + $extendedPrice );
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
