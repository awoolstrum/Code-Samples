<?php

class HTMLStatement extends Statement
{
		
	public function print( $encode = true )
	{
		$this->italic = true;
		
		$result .= "<h1>" . $this->getHeader() . "</h1>";

		// determine amounts for each line
		foreach ($this->customer->getRentals() as $rental) {
			$result .= str_repeat( "&nbsp", 3 ) . $this->getMovie( $rental ) . "<br />";
		}

		// add footer lines
		$result .= "<p>" . $this->getBalance() . "</p>";
		$result .= "<p>" . $this->getFrequentRenterPoints() . "</p>";
		
		echo ( $encode ) ? htmlentities($result) : $result;
		
	}	
}
