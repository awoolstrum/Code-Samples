# Customer Statement for a Video Rental Store

Requires PHP 7.1+

## Overview

This sample project is a program to calculate and print the statement of a customer's charges at a video rental store.

It's an example that approximates many of the issues we must work through on a regular basis. The code works and accomplishes the needs of the business, but it's not flexible. Altering the code to add new features is a scary task.

The program is heavily inspired by an example from the first edition of Martin's Fowler's Refactoring. While you are of course welcome to use almost any resource at your disposal during this code challenge, **you may not reference the book or any resources that discuss this example from the book**.

## The Job to be Done

As it is, the program only spits out a plain-text statement. Your job is to get the program to produce an HTML version of the customer statement as well, with the following requirements:

- The header must be an `H1` element with the customer's name in italics, with the language "Rentals for _Customer Name_".
- Each movie rental listing must be on a new line with a colon after the movie name, like so:
  > Gone with the Wind: 5
- The footer lines should each be in their own `<p>` elements, with the total charge amount and the total frequent renter points each in italics.

In addition, our client told us that they plan on introducing several new movie classifications next year. We don't have them yet, so there's nothing to implement, but we need to make sure the program is ready to handle it when they're given to us. All we know so far is that while a movie can only have one classification at a time, that classification can change over time. (A "New Release" won't be a new release forever.)

The code can be brittle and obscure, so while you're working to meet the requirements above, make the code more flexible and easier to work with.

This is an open-ended challenge. There are no hidden gotchas or requirements here. After you return this to us, we'll sit down and go through a code review with you, so please be prepared to share your thinking on your work.
