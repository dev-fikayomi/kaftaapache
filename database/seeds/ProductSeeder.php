<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        \App\Products::create([ 'name'=>'Hollandia UHT Milk - Full Cream X10 - 1 LTR',
            'quantity'=>20,
            'price'=>900,
            'image'=>'1.jpg',
            'description'=>'HOLLANDIA UHT MILK is also known as ‘fresh milk’. It has a natural milk taste and is easy to drink because it does not require boiling or mixing. As a wholesome, healthy food supplement it is packed with entire essential nutrients like protein, carbohydrates, calcium, minerals & vitamins to give you that wholesome goodness of fresh milk.']);

        \App\Products::create([
            'name'=>'Nestle Milo Hot Chocolate Refill - 400g',
            'quantity'=>10,
            'price'=>1550,
            'image'=>'2.jpg',
            'description'=>'Tasty and trusted, Milo brand is the world’s leading chocolate malt beverage that can be prepared with hot or cold milk or water. It offers essential vitamins and minerals to meet the nutrition and energy demands of young bodies and minds. It has long been known as an energy beverage strongly associated with sports and good health.'
        ]);

        \App\Products::create([
            'name'=>'Nestle Maggi Cubes Chicken Flavour 4g X 100',
            'quantity'=>15,
            'price'=>750,
            'image'=>'3.jpg',
            'description'=>'Maggi Cube is seasoning taste that adds flavour to any recipe requiring cloves. The seasoning is good for all varieties of food. It is good for your local dishes, like egusi soap, ogbono, efo riro and pepper sauce. You can Spice up your fish and meat with Maggi cubes to bring out the wonderful taste that you will enjoy.'
        ]);

        \App\Products::create([
            'name'=>'Malta Guinness Can 330ml x24',
            'quantity'=>30,
            'price'=>6650,
            'image'=>'4.jpg',
            'description'=>'Malta Guinness is Africa’s leading non-alcoholic, adult, premium soft drink, produced by Diageo. It was launched in Cameroon in 1984. Today Malta Guinness is a hugely successful and profitable brand.'
        ]);


    }
}
