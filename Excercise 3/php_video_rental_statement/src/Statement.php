<?php

class Statement
{
	
	protected $italic = false;
	protected $customer;
	
	public function __construct( Customer $customer )
	{
		$this->customer = $customer;
	}
	
	public function getHeader()
	{
		if( $this->italic )
			return sprintf( "Rentals for <i>%s</i>", $this->customer->getName() );
		return sprintf( "Rentals for %s", $this->customer->getName() );
	}
	
	public function getMovie( Rental $rental )
	{
		return sprintf( "%s: %5s %01.2f", $rental->getMovie()->getTitle(), "$", $rental->getPrice() );
	}
	
	public function getBalance()
	{
		if( $this->italic )
			return sprintf( "Amount owed is <i>$%01.2f</i>.", $this->customer->getBalance() );
		return sprintf( "Amount owed is $%01.2f.", $this->customer->getBalance() );
	}
	
	public function getFrequentRenterPoints()
	{
		if( $this->italic )
			return sprintf( "You earned <i>%d</i> frequent renter points.", $this->customer->getFrequentRenterPoints() );
		return sprintf( "You earned %d frequent renter points.", $this->customer->getFrequentRenterPoints() );
	}
	
}