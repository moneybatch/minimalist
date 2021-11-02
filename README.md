# Money batch for minimalist
Working with one currency? Need easy, affective and stable way to work with Money?
Pick the Minimalist.

## Installation 
`composer require moneybatch/minimalist`

## Usage 

1. Make some money:
`$money = new Money(100)`

2. Add more money:
`$money->add(new Money(500))`
   
3. Multiply that:
`$money->multiplyBy(2)`
   
4. Calculate 10% 
`$money->percent(10)->get()`
   
5. Get in Units
`$money->inUnits()`
   
All together:
`Money::fromSubunits(1000)->add(Money::fromUnits(5))->multiplyBy(2)->percent(10)->get()->inUnits()`
will result in `3.0` Units.