PRAGMA foreign_keys = on;

--Drop Tables
DROP TABLE IF EXISTS BelongsToOrder;
DROP TABLE IF EXISTS Order_;
DROP TABLE IF EXISTS RestaurantReview;
DROP TABLE IF EXISTS DishReview;
DROP TABLE IF EXISTS Rating;
DROP TABLE IF EXISTS State;
DROP TABLE IF EXISTS FavouriteRestaurant;
DROP TABLE IF EXISTS FavouriteDish;
DROP TABLE IF EXISTS Review;
DROP TABLE IF EXISTS DishBelongsToCategory;
DROP TABLE IF EXISTS ResBelongsToCategory;
DROP TABLE IF EXISTS DishCategory;
DROP TABLE IF EXISTS RestaurantCategory;
DROP TABLE IF EXISTS Dish;
DROP TABLE IF EXISTS Owns;
DROP TABLE IF EXISTS Restaurant;
DROP TABLE IF EXISTS Customer;
DROP TABLE IF EXISTS RestaurantOwner;
DROP TABLE IF EXISTS User;


--Table User
CREATE TABLE User(
    idUser INTEGER PRIMARY KEY,
    username NVCHAR(40)         CONSTRAINT user_username_nn NOT NULL
                          CONSTRAINT user_username_user_unique UNIQUE,
    password NVCHAR(40)         CONSTRAINT user_password_nn NOT NULL,
                          --CONSTRAINT user_password_lenght CHECK (lenght(password) >= 8),
    address_ NVCHAR(300)           CONSTRAINT user_address_user_nn NOT NULL,
    phoneNumber NVCHAR(20)  CONSTRAINT user_phoneNumber_nn NOT NULL
);  

--Table Customer
CREATE TABLE Customer(
    idCustomer INTEGER PRIMARY KEY
                CONSTRAINT fk_customer_user REFERENCES User (idUser) ON UPDATE CASCADE   
);  


--Table RestaurantOwner
CREATE TABLE RestaurantOwner(
    idRestaurantOwner INTEGER PRIMARY KEY
                CONSTRAINT fk_restaurantOwner_user REFERENCES User (idUser) ON UPDATE CASCADE   
);  

--Table Restaurant
CREATE TABLE Restaurant(
    idRestaurant INTEGER PRIMARY KEY,
    name_ NVCHAR(40) CONSTRAINT restaurant_name_nn NOT NULL, 
    address_ NVCHAR(300) CONSTRAINT restaurant_address_nn NOT NULL,
    photo NVCHAR(500),
    rating REAL
);

--Table Owns
CREATE TABLE Owns(
    idOwner INTEGER CONSTRAINT fk_owner_owns REFERENCES RestaurantOwner (idRestaurantOwner) ON UPDATE CASCADE,
    idRestaurant INTEGER CONSTRAINT fk_restaurant_owns REFERENCES Restaurant (idRestaurant) ON UPDATE CASCADE,
    PRIMARY KEY(idOwner, idRestaurant)
); 

--Table RestaurantCategory
CREATE TABLE RestaurantCategory(
    idResCategory INTEGER PRIMARY KEY,
    name NVCHAR(40) CONSTRAINT restaurant_category_text_nn NOT NULL
);

--Table ResBelongsToCategory
CREATE TABLE ResBelongsToCategory(
    idRestaurant INTEGER CONSTRAINT fk_restaurant_belongs REFERENCES Restaurant (idRestaurant) ON UPDATE CASCADE,
    idResCategory INTEGER CONSTRAINT fk_res_category_belongs REFERENCES RestaurantCategory (idResCategory) ON UPDATE CASCADE,
    PRIMARY KEY(idRestaurant, idResCategory)  
); 

--Table Dish
CREATE TABLE Dish(
    idDish INTEGER PRIMARY KEY,
    idRestaurant INTEGER 
                CONSTRAINT fk_restaurant_dish REFERENCES Restaurant (idRestaurant) ON UPDATE CASCADE,
    name_ NVCHAR(40) CONSTRAINT dish_name_nn NOT NULL,
    price REAL CONSTRAINT dish_price_nn NOT NULL,
    rating REAL,
    photo NVCHAR(500)
);

--Table DishCategory
CREATE TABLE DishCategory(
    idDishCategory INTEGER PRIMARY KEY,
    name NVCHAR(40) CONSTRAINT dish_category_text_nn NOT NULL
);

--Table DishBelongsToCategory
CREATE TABLE DishBelongsToCategory(
    idDish INTEGER CONSTRAINT fk_dish_belongs REFERENCES Dish (idDish) ON UPDATE CASCADE, 
    idDishCategory INTEGER CONSTRAINT fk_dish_category_belongs REFERENCES DishCategory (idDishCategory) ON UPDATE CASCADE,
    PRIMARY KEY(idDish, idDishCategory)
); 

--Table Rating
CREATE TABLE Rating(
    idRating INTEGER PRIMARY KEY,
    idCustomer INTEGER CONSTRAINT fk_customer_rating REFERENCES Customer (idCustomer) ON UPDATE CASCADE,
    timestamp NVCHAR(40),
    starNum INTEGER CONSTRAINT rating_star_nn NOT NULL
);

--Table RestaurantReview
CREATE TABLE RestaurantReview(
    idRating INTEGER CONSTRAINT fk_rating_restaurant_review REFERENCES Rating (idRating) ON UPDATE CASCADE,
    idRestaurant INTEGER CONSTRAINT fk_restaurant_review REFERENCES Restaurant (idRestaurant) ON UPDATE CASCADE,
    reviewText NVCHAR(400)
);

--Table DishReview
CREATE TABLE DishReview(
    idRating INTEGER CONSTRAINT fk_rating_dish_review REFERENCES Rating (idRating) ON UPDATE CASCADE,
    idDish INTEGER CONSTRAINT fk_dish_review REFERENCES Dish (idDish) ON UPDATE CASCADE
);


--Table FavouriteRestaurant
CREATE TABLE FavouriteRestaurant(
    idRestaurant INTEGER CONSTRAINT fk_favourite_restaurant REFERENCES Restaurant (idRestaurant) ON UPDATE CASCADE,   
    idCustomer INTEGER CONSTRAINT fk_customer_favourite_restaurant REFERENCES customer (idcustomer) ON UPDATE CASCADE,
    PRIMARY KEY(idRestaurant, idCustomer)  
); 

--Table FavouriteDish
CREATE TABLE FavouriteDish(
    idDish INTEGER CONSTRAINT fk_favourite_dish REFERENCES Dish (idDish) ON UPDATE CASCADE,   
    idCustomer INTEGER CONSTRAINT fk_customer_favourite_restaurant REFERENCES customer (idcustomer) ON UPDATE CASCADE,
    PRIMARY KEY(idDish, idcustomer)
); 

--Table State
CREATE TABLE State(
    idState INTEGER PRIMARY KEY,
    name NVCHAR(40) CONSTRAINT state_text_nn NOT NULL
);

--Table Order
CREATE TABLE Order_(
    idOrder INTEGER PRIMARY KEY,
    idCustomer INTEGER CONSTRAINT fk_customer_order REFERENCES Customer (idCustomer) ON UPDATE CASCADE,
    idRestaurant INTEGER CONSTRAINT fk_restaurant_order REFERENCES Restaurant (idRestaurant) ON UPDATE CASCADE,
    timestamp NVCHAR(40),
    idState INTEGER  CONSTRAINT fk_state_order REFERENCES State (idState) ON UPDATE CASCADE
                    CONSTRAINT order_state_nn NOT NULL
);

--Table BelongsToOrder
CREATE TABLE BelongsToOrder(
    idOrder INTEGER CONSTRAINT fk_order_belongs REFERENCES Order_ (idOrder) ON UPDATE CASCADE,   
    idDish INTEGER CONSTRAINT fk_dish_belongs_order REFERENCES Dish (idDish) ON UPDATE CASCADE,
    quantity INTEGER CONSTRAINT belongs_order_positive CHECK (quantity > 0),
    PRIMARY KEY(idOrder, idDish)
); 
