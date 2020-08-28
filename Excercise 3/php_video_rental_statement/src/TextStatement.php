<?php

class TextStatement extends Statement
{
		
	public function print()
	{
		
		echo $this->getHeader() . "\n";

        // determine amounts for each line
        foreach ($this->customer->getRentals() as $rental) {
			echo "\t" . $this->getMovie( $rental ) . "\n";
        }

        // add footer lines
        echo $this->getBalance() . "\n";
		echo $this->getFrequentRenterPoints() . "\n";
		
    }
}
