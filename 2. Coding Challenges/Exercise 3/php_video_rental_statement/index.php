<?php

//phpinfo();
// Server was on 7.0 -> had to update per the instructions.  

/*
My basic approach to this:
	
1. This all gets easier if classes/methods are more focused (single responsibility) than they were.  That is where I spent
my time. 

2. The reason I set up all classifications in the index file here is for ease of maintenance.
Since we don't have a database driving this project, we don't want to change pricing in one spot, 
classifications in another, and then adjusting our point logic based on new classifications in a different. 

If we had a database, I would have used more models and loaded the DB straight into the models.  It would 
cut out a couple of the dependency injections I think.  

3. There is a lot more refactoring that could be had here.  Namely, I would have liked to get the classifications
into a data set (XML).  Second, I would have liked to introduce layers still.  If this was a real-life assignment,
this is what I would have called the "good enough" state, even though I would have liked to have kept going.  
*/

$codedir = './src';

require_once("$codedir/Points.php");
require_once("$codedir/Pricing.php");
require_once("$codedir/Movie.php");
require_once("$codedir/Rental.php");
require_once("$codedir/Customer.php");
require_once("$codedir/Statement.php");
require_once("$codedir/HTMLStatement.php");
require_once("$codedir/TextStatement.php");

/*///////////////////////
Define our classifications.
*////////////////////////

$pricing = array(
	"CHILDRENS" => new Pricing( 1.5, 3, 1.5),
	"NEW_RELEASES" => new Pricing( 3, 1, 3),
	"REGULAR" => new Pricing( 2, 2, 1.5)
	);

/*////////////////////////
Define our movies
*/////////////////////////

$prognosisNegative = new Movie( "Prognosis Negative", "NEW_RELEASES", $pricing["NEW_RELEASES"] );
$sackLunch = new Movie( "Sack Lunch", "CHILDRENS", $pricing["CHILDRENS"] );
$painAndYearning = new Movie("The Pain and the Yearning", "REGULAR", $pricing["REGULAR"] );

/*////////////////////////
Load up the customer data
*/////////////////////////

// Side comment: I am passing points as a D.I. rather than instantiating in
// the constructor because I believe you shouldn't "secretly" instantiate.  You should pass everything that is 
// needed in through the arguments.  This also helps unit test writing. 
$points = new Points();
$customer = new Customer("Susan Ross", $points); 

$customer->addRental(		new Rental($prognosisNegative, 3)	);
$customer->addRental(		new Rental($painAndYearning, 1)		);
$customer->addRental(		new Rental($sackLunch, 1) 			);

/*////////////////////////
Prepare the output
*/////////////////////////

$statement = new HTMLStatement( $customer );
$statement->print( false );

echo '<br /><br /><pre>';
$statement->print();

echo '<br /><br />';

$statement = new TextStatement( $customer );
$statement->print();
echo '</pre>';