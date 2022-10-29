PRAGMA foreign_keys = on;

--Table User
INSERT INTO User(idUser, username, password, address_, phoneNumber)
    VALUES(1, 'dinisSousa', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Rua das Flores', '+351987654321');
INSERT INTO User(idUser, username, password, address_, phoneNumber)
    VALUES(2, 'Antunes', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Rua das Flores', '+351987654321');
INSERT INTO User(idUser, username, password, address_, phoneNumber)
    VALUES(3, 'Manafá', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Rua das Flores', '+351987654321');

--Table customer
INSERT INTO Customer(idCustomer)
    VALUES(1);
INSERT INTO Customer(idCustomer)
    VALUES(2);
INSERT INTO Customer(idCustomer)
    VALUES(3);

--Table RestaurantOwner
INSERT INTO RestaurantOwner(idRestaurantOwner)
    VALUES(3);

--Table Restaurant
INSERT INTO Restaurant(idRestaurant, name_, address_, photo, rating)
    VALUES(1, 'Restaurante do Almada', 'Rua do Almada', 'https://media-cdn.tripadvisor.com/media/photo-s/10/2d/e9/9e/img-20170807-165025-largejpg.jpg', 5);
INSERT INTO Restaurant(idRestaurant, name_, address_, photo, rating)
    VALUES(2, 'Taskinha', 'Rua do Pipo', 'https://cdn.website.dish.co/media/0f/e9/1672786/Taskinha-do-Alex-0AC46914-272D-41D5-AB81-FD76325644E8.jpg', 3.5);
    

--Table Owns
INSERT INTO Owns(idOwner, idRestaurant)
    VALUES(3, 1);
INSERT INTO Owns(idOwner, idRestaurant)
    VALUES(3, 2);

--Table RestaurantCategory
INSERT INTO RestaurantCategory(idResCategory, name)
    VALUES(1, 'Bar');
INSERT INTO RestaurantCategory(idResCategory, name)
    VALUES(2, 'Pizza');
INSERT INTO RestaurantCategory(idResCategory, name)
    VALUES(3, 'Sushi');
INSERT INTO RestaurantCategory(idResCategory, name)
    VALUES(4, 'Fast-Food');
INSERT INTO RestaurantCategory(idResCategory, name)
    VALUES(5, 'Gourmet');

--Table ResBelongsToCategory
INSERT INTO ResBelongsToCategory(idRestaurant, idResCategory)
    VALUES(1, 1);
INSERT INTO ResBelongsToCategory(idRestaurant, idResCategory)
    VALUES(1, 2);
INSERT INTO ResBelongsToCategory(idRestaurant, idResCategory)
    VALUES(2, 1);

--Table Dish
INSERT INTO Dish(idDish, idRestaurant, name_, price, rating, photo)
    VALUES(1, 1, 'Posta de Vitela', 4.70, 3, 'https://media-cdn.tripadvisor.com/media/photo-s/10/2d/e9/9e/img-20170807-165025-largejpg.jpg');
INSERT INTO Dish(idDish, idRestaurant, name_, price, rating, photo)
    VALUES(2, 1, 'Prego no Prato', 6.20, 4.2, 'https://www.cozinhatradicional.com/wp-content/uploads/2012/08/prego-no-prato.jpg');
INSERT INTO Dish(idDish, idRestaurant, name_, price, rating, photo)
    VALUES(3, 2, 'Pão com Panado', 2, 3.1, 'https://www.auchan.pt/dw/image/v2/BFRC_PRD/on/demandware.static/-/Sites-auchan-pt-master-catalog/default/dw2b918000/images/hi-res/003059109.jpg?sw=500&sh=500&sm=fit&bgcolor=FFFFFF');

--Table DishCategory
INSERT INTO DishCategory(idDishCategory, name)
    VALUES(1, 'Carne');
INSERT INTO DishCategory(idDishCategory, name)
    VALUES(2, 'Peixe');
INSERT INTO DishCategory(idDishCategory, name)
    VALUES(3, 'Vegetariano');
INSERT INTO DishCategory(idDishCategory, name)
    VALUES(4, 'Sushi');
INSERT INTO DishCategory(idDishCategory, name)
    VALUES(5, 'Lanche');

--Table DishBelongsToCategory
INSERT INTO DishBelongsToCategory(idDish, idDishCategory)
    VALUES(1, 1);
INSERT INTO DishBelongsToCategory(idDish, idDishCategory)
    VALUES(2, 1);
INSERT INTO DishBelongsToCategory(idDish, idDishCategory)
    VALUES(3, 1);

--Table Rating
INSERT INTO Rating(idRating, idcustomer, timestamp, starNum)
    VALUES(1, 1, '2022-05-24 15:36:10', 4);
INSERT INTO Rating(idRating, idcustomer, timestamp, starNum)
    VALUES(2, 2, '2022-04-24 15:36:10', 3);
INSERT INTO Rating(idRating, idcustomer, timestamp, starNum)
    VALUES(3, 2, '2022-05-01 09:36:13', 3);
INSERT INTO Rating(idRating, idcustomer, timestamp, starNum)
    VALUES(4, 2, '2022-01-13 22:36:10', 5);

--Table RestaurantReview
INSERT INTO RestaurantReview(idRating, idRestaurant, reviewText)
    VALUES(1, 1, 'O Almada é top!');
INSERT INTO RestaurantReview(idRating, idRestaurant, reviewText)
    VALUES(2, 2, 'O Taskinha é um sítio fantástico!');

--Table DishReview
INSERT INTO DishReview(idRating, idDish)
    VALUES(3, 1);
INSERT INTO DishReview(idRating, idDish)
    VALUES(4, 3);

--Table FavouriteRestaurant
INSERT INTO FavouriteRestaurant(idRestaurant, idcustomer)
    VALUES(1, 1);
INSERT INTO FavouriteRestaurant(idRestaurant, idcustomer)
    VALUES(2, 2);

--Table FavouriteDish
INSERT INTO FavouriteDish(idDish, idcustomer)
    VALUES(3, 1);
INSERT INTO FavouriteDish(idDish, idcustomer)
    VALUES(1, 2);

--Table State
INSERT INTO State(idState, name)
    VALUES(1, 'Recieved');
INSERT INTO State(idState, name)
    VALUES(2, 'Preparing');
INSERT INTO State(idState, name)
    VALUES(3, 'Ready');
INSERT INTO State(idState, name)
    VALUES(4, 'Delivered');

--Table Order
INSERT INTO Order_(idOrder, idcustomer, idRestaurant, timestamp, idState)
    VALUES(1, 1, 1, '2022-01-13 22:36:10', 4);

--Table BelongsToOrder
INSERT INTO BelongsToOrder(idOrder, idDish, quantity)
    VALUES(1, 1, 1);
    VALUES(1, 2, 3);
    