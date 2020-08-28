<?PHP

/*
When you look at the statement function, each movie classification has different pricing parameters attached to it.  Assuming those parameters need to be adjusted on the fly.
So if we create a standard data model to save each of those pricing levels, then we can change the parameters as needed without being tightly coupled to each classifications name.  
The model then gets injected as needed, so that none of the higher level functions need to know what type of movie it is.  The client level can define the type. 

If this application was live, I'd be creating this pricing model out of an XML file or a MySQL database.  
*/
class Pricing
{
	
	private $initialPrice;
	private $daysIncludedInRental;
	private $extendedPrice;
	
	public function __construct( float $initialPrice, int $daysIncludedInRental, float $extendedPrice )
	{
		$this->initialPrice = $initialPrice;
		$this->daysIncludedInRental = $daysIncludedInRental;
		$this->extendedPrice = $extendedPrice;
	}
	
	public function getDaysIncluded()
	{
		return $this->daysIncludedInRental;
	}
	
	public function getInitialPrice()
	{
		return $this->initialPrice;
	}
	
	public function getExtendedPrice()
	{
		return $this->extendedPrice;
	}
	
}

?>