<?php
namespace PHPBestPractices1OOP\Controller;

use PHPBestPractices1OOP\Domain\Users\UserFactory;
use PHPBestPractices1OOP\Domain\Restaurants\RestaurantFactory;
use PHPBestPractices1OOP\Domain\Foods\FoodFactory;

class DisplayUserInformationPage
{
    /**
     * @var array
     */
    private $users;

    /**
     * @var array
     */
    private $restaurants;

    /**
     * @var array
     */
    private $foods;

    /**
     * DisplayUserInformationPage constructor.
     * @param array $users
     * @param array $restaurants
     * @param array $foods
     */
    public function __construct($users, $restaurants, $foods)
    {
        $this->users = $users;
        $this->restaurants = $restaurants;
        $this->foods = $foods;
    }

    public function __invoke()
    {
        // dependencies
        $userObject = UserFactory::createUser();
        $restaurantObject = RestaurantFactory::createResturant();
        $foodObject = FoodFactory::createFood();

        // set user values from db
        $userRowNumber = 1;
        $userObject->setName($this->users[$userRowNumber]["name"]);
        $userObject->setAge($this->users[$userRowNumber]["age"]);

        // get user's resturant and favorite food ids
        $favoriteFoodRowNumber = array_search(
            $this->users[$userRowNumber]["favoriteFood"],
            array_column($this->foods, "id")
        );
        $favoriteResturantRowNumber = array_search(
            $this->users[$userRowNumber]["favoriteRestaurant"],
            array_column($this->restaurants, "id")
        );

        // set favorite resturant values to favorite resturant object
        $restaurantObject->setName($this->restaurants[$favoriteResturantRowNumber]["name"]);

        // set favorite food values to food object
        $foodObject->setName($this->foods[$favoriteFoodRowNumber]["name"]);

        // set values to user using food and resturant objects
        $userObject->setFavoriteRestaurant($restaurantObject->getName());
        $userObject->setFavoriteFood($foodObject->getName());

        // display
        echo "User's name is ".$userObject->getName().", age is ".$userObject->getAge()."<br>";
        echo "Favorite restaurant is ".$userObject->getFavoriteResturant()." favorite food is ".$userObject->getFavoriteFood();

    }
}