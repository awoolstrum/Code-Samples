<?PHP

class Points
{
	
	private $i = 0;
	
	public function calculatePoints( Rental $rental )
	{
		
		$this->i++;
		
		// Held my nose while hard coding this one. 
		if( $rental->getMovie()->getClassification() == "NEW_RELEASES" 
			&& $rental->getDaysRented() > 1 
		)
			$this->i++;
		
		return $this->getPoints();
	}
	
	public function getPoints()
	{
		$n = $this->i;
		$this->i = 0;
		return $n;
	}
	
}

?>