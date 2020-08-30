<?php

class Customer
{
    private $name;
    private $rentals = array();
	private $accountBalance = 0;
	private $frequentRenterPoints = 0;
	private $points;

    public function __construct( string $name, Points $points )
    {
        $this->name = $name;
		$this->points = $points;
    }

	public function adjustBalance( float $price )
	{
		$this->accountBalance += $price;
	}
	
	public function adjustPoints( int $newPoints )
	{
		$this->frequentRenterPoints += $newPoints;
	}
	
    public function addRental(Rental $rental)
    {
		
		$this->adjustBalance( $rental->getPrice() );
		$this->adjustPoints( $this->points->calculatePoints( $rental ) );
		
        array_push($this->rentals, $rental);
		
    }
	
	public function getRentals()
	{
		return $this->rentals;
	}

	public function getBalance()
	{
		return $this->accountBalance;
	}
	
	public function getFrequentRenterPoints()
	{
		return $this->frequentRenterPoints;
	}
	
    public function getName(): string
    {
        return $this->name;
    }
	
}