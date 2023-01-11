DROP TABLE Inform;
DROP TABLE List;
DROP TABLE Comments;
DROP TABLE Contain;
DROP TABLE Explains;
DROP TABLE Orders;
DROP TABLE OrderAddress;
DROP TABLE GroceryStore;
DROP TABLE MealKit;
DROP TABLE Users;
DROP TABLE UserType;
DROP TABLE Ingredient;
DROP TABLE MealPosts;
DROP TABLE Blog;
DROP TABLE Post;   
DROP SEQUENCE comment_seq;

CREATE TABLE Post (postId INT PRIMARY KEY, title CHAR(200), content CHAR(2000));
CREATE TABLE MealPosts (postId INT PRIMARY KEY,  dietType CHAR(100), instruction CHAR(2000), rate INT); 
CREATE TABLE Ingredient (ingName CHAR(100)	PRIMARY KEY, type CHAR(100));
CREATE TABLE List (postId INT, ingName	CHAR(100), PRIMARY KEY (postId, ingName), FOREIGN KEY (postId) REFERENCES MealPosts(postId) ON DELETE CASCADE, FOREIGN KEY (ingName) REFERENCES Ingredient(ingName) ON DELETE CASCADE);
CREATE TABLE Blog (postId INT PRIMARY KEY, category CHAR(100), FOREIGN KEY (postId) REFERENCES Post(postId) ON DELETE CASCADE);
CREATE TABLE GroceryStore (storeId INT PRIMARY KEY, name CHAR(100), address CHAR(100));
CREATE TABLE Inform (postId INT, storeId INT, PRIMARY KEY (postId, storeId), FOREIGN KEY (postId) REFERENCES MealPosts ON DELETE CASCADE, FOREIGN KEY (storeId) REFERENCES GroceryStore ON DELETE CASCADE);
CREATE TABLE MealKit (SKU INT PRIMARY KEY, name CHAR(100), price INT, instruction CHAR(2000));
CREATE TABLE Users (userId INT PRIMARY KEY, name CHAR(100), email CHAR(100), password CHAR(100));
CREATE TABLE UserType (email CHAR(100) PRIMARY KEY, type CHAR(100));
CREATE TABLE Orders (orderId INT PRIMARY KEY, trackingId CHAR(100) UNIQUE, userId INT, year CHAR(4), month CHAR(2), day CHAR(2), FOREIGN KEY (userId) REFERENCES Users ON DELETE CASCADE);
CREATE TABLE OrderAddress (trackingId CHAR(100) PRIMARY KEY, address CHAR(100));
CREATE TABLE Contain (SKU INT, orderId INT, PRIMARY KEY (SKU, orderId), FOREIGN KEY (SKU) REFERENCES MealKit ON DELETE CASCADE, FOREIGN KEY (orderId) REFERENCES Orders ON DELETE CASCADE);
CREATE TABLE Comments (postId INT, commentId INT, rating INT, content CHAR(2000), userId INT, PRIMARY KEY (postId, commentId), FOREIGN KEY (userId) REFERENCES Users);
CREATE SEQUENCE comment_seq INCREMENT BY 1 START WITH 1 MINVALUE 1 MAXVALUE 9999 NOCYCLE NOCACHE NOORDER;
CREATE TABLE Explains (SKU INT, postId INT, PRIMARY KEY (SKU, postId), FOREIGN KEY (SKU) REFERENCES MealKit ON DELETE CASCADE, FOREIGN KEY (postId) REFERENCES MealPosts ON DELETE CASCADE);
        

--------------- Post  --------------->
INSERT INTO Post(postId, title, content) VALUES (1, 'Tteokbokki', 'Tteokbokki is one of the most popular Korean street foods in Korea. Among other things, today'' s recipe is made with Korean rice cakes, Korean fish cakes, Korean soup stock / dashi stock and gochujang (Korean chili paste)!');
INSERT INTO Post(postId, title, content) VALUES (2, 'Jjajang Tteokbokki', 'Jjajang tteokbokki known as Korean Black Bean Tteokbokki, is a delicious 15 mins recipe made with chewy Korean rice cakes in a black bean sauce!');
INSERT INTO Post(postId, title, content) VALUES (3, 'Curry Tteokbokki', 'Curry Tteokbokki Korean Kare- a hearty, rich and comforting dish made with rice cakes, sausages, potatoes, carrots, onions, and mushrooms; all simmered in a thick and flavorsome curry sauce.');
INSERT INTO Post(postId, title, content) VALUES (4, 'Carbonara Tteokbokki', 'Korean Cream Carbonara Tteokbokki is a fusion rice cake dish, made with smokey bacon, lashings of cream and a generous sprinkling of black pepper.');
INSERT INTO Post(postId, title, content) VALUES (5, 'Gungjung Tteokbokki', 'Gungjung tteokbokki is the traditional version of tteokbokki. Gungjung means ''royal court'' in Korean. Unlike today''s red spicy version, this traditional version is mildly flavored with a soy sauce based sauce.');
INSERT INTO Post(postId, title, content) VALUES (6, 'Fried Chicken', 'Fried chicken, also known as Southern fried chicken, is a dish consisting of chicken pieces that have been coated with seasoned flour or batter and pan-fried, deep fried, pressure fried, or air fried.');
INSERT INTO Post(postId, title, content) VALUES (7, 'Korean Fried Chicken', 'Korean fried chicken, usually called chikin in Korea, refers to a variety of fried chicken dishes created in South Korea, including the basic huraideu-chicken and spicy yangnyeom chicken.');
INSERT INTO Post(postId, title, content) VALUES (8, 'Buffalo Wing', 'A Buffalo Wing in American cuisine is an unbreaded chicken wing section that is generally deep-fried and then coated or dipped in a sauce consisting of a vinegar-based cayenne pepper hot sauce and melted butter prior to serving.');
INSERT INTO Post(postId, title, content) VALUES (9, 'Shoyu Ramen', '''Shoyu'' means soy sauce in Japanese. Shoyu ramen simply refers to ramen served with a soy sauce-based broth that is usually in clear, brown color.');
INSERT INTO Post(postId, title, content) VALUES (10, 'Tonkotsu Ramen', 'Tonkotsu ramen is the king of Japenese soups for a reason. Deeply flavourful broth is in perfect balance with the pork and those wonderful ramen noodles.');

INSERT INTO Post(postId, title, content) VALUES (11, 'Dongdaemun Yupdduk', 'Honestly, Yupdduk is just unbelievable amazing. I get takeout nearly every day, and the sausage just hits differently. Always grab additional sausage with your order; you won''t be sorry. I don''t usually purchase the rice balls since, as I previously said, I usually order takeout and can create the rice balls myself with only rice and seaweed from Costco. However, if I''m out with friends and dining out at a restaurant, I always make sure to get it since the combination is fantastic! If you are a typical eater, the quantities will be more than plenty! My friend and I didn''t eat the remainder of the spicy rice cakes. I don''t know what to say about the eggs since I''ve never eaten them LOL. but my friend would always bring it home for his brother to eat it because apparently he likes it a lot. ANYWAYS LOVE YUPDDUK');
INSERT INTO Post(postId, title, content) VALUES (12, 'Sinjeon Tteokbokki', 'Delicious Korean street food! Ordered takeout at the restaurant and the staff were super friendly. Had to wait a little longer than usual and the staff were very apologetic for it and gave us an extra fried set on the house. Super friendly and super delicious food! The cheese tteokbokki had the cheese pull and the mild wasn''t too spicy. Overall would definitely visit again!');
INSERT INTO Post(postId, title, content) VALUES (13, 'bbq Chicken', 'Absolutely amazing authentic korean fried chicken place! What more can you ask for? You got hot and crispy , saucy, finger-lickin good chicken, cold beer, and sumptuous  cheese balls and tteobokki....wow!! Apparently this chain is very very popular in korea, as per my korean buddy. And of course it did not disappoint! Ive tried the dasarang chicken, but this place is better. Chicken pieces were huge and fried as you order. Sauce was tangy and very flavourful. Love it ! Quality and taste all there. Chicken was not dry. Very juicy. Crispy coating was not overdone. Delicious!! The cheese balls were oozing with mozarella cheese upon being sliced. Inside was still smoking. Service was quick. Covid protocols excellent. Each table had a hand sanitizer bottle. Servers very attentive. Napkins and wet towels readily available. They have beers by the pitcher! Heaven!! Already making plans of going back!! Cheers! Happy eating!');
INSERT INTO Post(postId, title, content) VALUES (14, 'Kokoro', 'We got their chicken from karaage king again and their takoyaki as well. The chicken karaage were ordered with the tartar mayo sauce and although the sauce was delicious, I found the chicken a little bit too salty. The pieces were quite large but the price was also higher so it was understandable. The takoyaki was awesome with a huge plump piece of octopus in each piece, very crispy fried and with the mental mayo, it provided a different flavour that was fishy but in the best way. Overall, I didnt love the chicken today but since this place is so close to home, we will probably return soon.');
INSERT INTO Post(postId, title, content) VALUES (15, 'Kinton', 'UBC''s first ramen restaurant! A nice spot to enjoy a nice hot bowl of ramen to warm up after trekking across campus to class or commuting to school. The ramen is decent and pretty standard. Nothing about it sticks out to me or differentiates it from other ramen places nearby. The broth is flavorful, but a tad on the salty side. The portion sizes were average, and there definitely wasn''t enough toppings to complement the amount of noodles they give. The sides like their gyoza are good, but once again, nothing sticks out about it. Definitely on the pricer side for the quality and amount that you get. They also offer a stamp card challenge where you get a stamp each time you finish the entire bowl, including the soup. The end reward is ramen for a year, but they''re a little stingy on what finishing a bowl looks like. My friends have previously licked the bowl cleaned and were rejected of their stamp, which is a little disappointing. The staff was friendly and efficient until you''re seated, then the service gets really slow and a little pushy. I was rushed to order the moment I sat down and then waited around 30 minutes for my bowl of ramen to come out. This place gets really busy in between classes and during lunch and dinner. I''ve heard of wait times being as long as an hour, so I suggest pre-ordering for take out, or sending someone to grab a table ahead of time.');
 

--------------- MealPost  --------------->
INSERT INTO MealPosts(postId, dietType, instruction) VALUES (1, 'pescatarians', 'Unless your rice cakes are soft already, soak them in warm water for 10 mins. Boil the soup stock in a shallow pot over medium high heat and dissolve the tteokbokki sauce by stirring it with a spatula. Once the seasoned stock is boiling, add the rice cakes, fish cakes and onion. Boil them a further 3 to 5 mins until the rice cakes are fully cooked. Then, to thicken the sauce and to deepen the flavor, simmer it over low heat for a further 2 to 4 mins. Add the sesame oil, sesame seeds, and green onion then quickly stir. Serve warm.');
INSERT INTO MealPosts(postId, dietType, instruction) VALUES (2, 'pescatarians', 'In a small bowl, mix together your water and cornstarch. In a medium size pot set over low heat, add your avocado oil. You want to ensure your oil is warmed. Then add in your roasted black bean paste. Fry it in the oil for 1 minute. Then add in your onion, green onions that are sliced in 1 inch pieces, and fish cakes. Give it a stir until everything is covered in the sauce. Pour in your cornstarch water and dried kelp into the pot. Mix altogether scraping the base of the pot. Allow this to boil and reduce to a simmer for 5 minutes or until sauce has thickened. Add in your rice cakes and mix into the sauce. Season with sugar. Boil this for 10 minutes until rice cakes are soft but chewy or fork tender. Transfer to a plate and sprinkle green onions and sesame seeds over top (optional).');
INSERT INTO MealPosts(postId, dietType, instruction) VALUES (3, 'flextarian', 'Cut 4 sausages into bite-sized pieces using scissors. Fry off in a little oil until browned. Add half thinly sliced onion and sauté until soft. Now add 6 sliced mushrooms and stir. A few minutes later, add 4 minced garlic cloves. Cook for 3-5 minutes. Add chopped potatoes and carrots. Pour in 2 cups water. Place a lid on and allow it to cook for 15-20 minutes until softened. Pour 1 cup of water into the pot. Break up two Golden Curry blocks into smaller pieces and transfer them to the pot. Now add 1.5 cups rice cakes. Stir well until curry blocks have dissolved and rice cakes are submerged. Cook for the rice cakes for 5 minutes. Once the curry sauce has thickened, garnish with chopped green onions or chives. Serve the pan at the table.');
INSERT INTO MealPosts(postId, dietType, instruction) VALUES (4, 'flextarian', 'Slice garlic, onion, bacon and the broccoli to bite-sized pieces. Rice cake is reopened when a hard boil in boiling water for 30 seconds.It''s okay if omitted. Wearing the olive oil in a preheated pan. Put the garlic, onions, broccoli order. Put the bacon and fry it. Put the milk and cream in order with salt and pepper after bacon fried. Put boiled rice cakes. Finish putting the parmesan cheese powder.');
INSERT INTO MealPosts(postId, dietType, instruction) VALUES (5, 'flextarian', 'Combine the meat with the marinade. Set aside while other ingredients are being prepared. In a heated pan (on medium-high heat), add some cooking oil and the onion. Stir lightly until they are wilted. Add the meat and cook briefly (about 30 seconds) until the outer layer is cooked. Add the mushrooms, rice cakes, bell peppers and the seasoning sauce. Stir them well until all are cooked (about 2 to 3 mins). Garnish with the green onion and roasted sesame seeds. Serve.');
INSERT INTO MealPosts(postId, dietType, instruction) VALUES (6, 'flextarian', 'In a large shallow dish, combine 3 cups flour, garlic salt, paprika, 3 teaspoons pepper and poultry seasoning. In another shallow dish, beat eggs and 2 cups water; add salt and the remaining 1 cups flour and 1 teaspoon pepper. Dip chicken in egg mixture, then place in flour mixture, a few pieces at a time. Turn to coat. In a deep-fat fryer, heat oil to 375 degree. Fry chicken, several pieces at a time, until chicken is golden brown and juices run clear, 7-8 minutes on each side. Drain on paper towels.');
INSERT INTO MealPosts(postId, dietType, instruction) VALUES (7, 'flextarian', 'Wash chicken wings, and drain thoroughly. Mix with the salt, pepper, and ginger. Let it sit in the fridge for 2 hours or longer. Combine all the sauce ingredients of your choice and stir well. Boil over medium heat until it thickens slightly, about 4 to 5 minutes. Turn the heat off. Mix the wet batter ingredients in a bowl, and stir well until smooth with no visible lumps. Add the oil to a deep fryer, wok, or large pot. Heat the oil to 320 F. Drop the chicken in the oil, one piece at a time. If using wet batter, dip each piece in the wet batter with tongs and shake off excess batter before dropping the chicken in the oil. Fry them in two batches. Cook until lightly golden, about 6 minutes, depending on the size of the chicken wings. Remove them with a wire skimmer or a slotted spoon. Drain on a wire rack or in a large mesh strainer set on a bowl. Reheat the oil to 350 F. Add the chicken, and deep fry again, for about 5 minutes, until golden brown. Drain on a wire rack or in a large mesh strainer set on a bowl. You can either toss the fried chicken pieces in the sauce or hand-brush them. Sprinkle with the optional sesame seeds or chopped scallion to serve.');
INSERT INTO MealPosts(postId, dietType, instruction) VALUES (8, 'flextarian', 'Preheat oven to 400 F and place a wire rack over a baking sheet. In a large bowl, toss chicken wings with oil and season with garlic powder, salt, and pepper. Transfer to prepared baking sheet. Bake until chicken is golden and skin is crispy, 50 to 60 minutes, flipping the wings halfway through. In a small saucepan, whisk together hot sauce and honey. Bring to simmer then stir in butter. Cook until butter is melted and slightly reduced, about 2 minutes. Heat broiler on low. Transfer baked wings to a bowl and toss with buffalo sauce until completely coated. Return wings to rack and broil—watching carefully!—until sauce caramelizes, 3 minutes. Serve with ranch dressing and vegetables.');
INSERT INTO MealPosts(postId, dietType, instruction) VALUES (9, 'flextarian', 'Ingredients for shoyu ramen recipe gathered. Heat sesame oil in a deep pan over medium heat. Sauté the chopped ginger and garlic in the pan for about a minute. Garlic and ginger frying in oil in a saucepan. Lower the heat and add the chicken soup stock and kombu dashi soup stock to the pan. Bring to a boil. Combined stocks boiling in the saucepan Add the soy sauce, sake, sugar, and salt to the soup and bring to a boil again. Soy sauce and seasonings added to boiling stock. In the meantime, boil water in a large pot. Add the chukamen noodles to the boiling water and cook for a few minutes (follow package directions). Ramen noodles cooking in water in a pot. Place a fine-mesh strainer over a bowl and pour the soup through the strainer. Stock being strained through a metal strainer into a bowl. Pour the hot soup into individual bowls. Clear soup in two bowls Drain the noodles and add to the hot soup. Ramen noodles added to soup in two bowls. Add toppings, such as chopped negi and nori seaweed, if desired. Sprinkle with pepper to taste.');
INSERT INTO MealPosts(postId, dietType, instruction) VALUES (10, 'flextarian', 'Make the pork broth. Transfer the trotters to a large stock pot and cover with cold water. Bring to a boil over high heat, then remove from the heat and drain in a colander, discarding the liquid. Using chopsticks, clean the bones under cold running water to remove any red or brown blood or organ pieces. Transfer the cleaned bones to a clean stock pot. In a large cast iron skillet over medium-high heat, toast the green onions, yellow onion, and ginger, turning occasionally, until the aromatics are charred in places. Add charred aromatics to the stock pot with the cleaned bones and cover with cold water. Bring to a boil over high heat, skimming off any scum that floats to the surface. Continue to boil and skim for 20 minutes, then cover and reduce to a simmer. Continue simmering, adding enough water as needed to keep bones and aromatics covered, until broth is opaque, about 6 hours. Uncover and bring to a boil. Let broth reduce to desired thickness. Strain the broth through a fine-mesh strainer and refrigerate overnight. When cool, bone broth should be very thick and gelatinous, and there should be a layer of fat on top of the broth. In a stock pot, bring pork bone broth and pork fat to a simmer over medium heat. Season to taste with salt and soy sauce. Meanwhile, bring a large pot of water to a boil. Cook ramen noodles in boiling water according to package directions. Divide the ramen noodles between two bowls and ladle the pork broth over the noodles. Top each bowl with two slices of chashu pork, enoki mushrooms, and menma. Tuck a nori sheet in between the side of the bowl and an egg half. Sprinkle the bowls with green onions and sesame seeds, and drizzle with mayu and/or chili oil, as desired.');


--------------- Ingredient  --------------->
INSERT INTO Ingredient(ingName, type) VALUES ('Gochujang', 'Condiment');
INSERT INTO Ingredient(ingName, type) VALUES ('Sugar', 'Sugar');
INSERT INTO Ingredient(ingName, type) VALUES ('Soy Sauce', 'Sauce');
INSERT INTO Ingredient(ingName, type) VALUES ('Gochugaru', 'Spice');
INSERT INTO Ingredient(ingName, type) VALUES ('Sesame Seed', 'Nut');
INSERT INTO Ingredient(ingName, type) VALUES ('Sesame Oil', 'Oil');
INSERT INTO Ingredient(ingName, type) VALUES ('Green Onion', 'Vegetable');
INSERT INTO Ingredient(ingName, type) VALUES ('Black Bean Paste', 'Condiment');
INSERT INTO Ingredient(ingName, type) VALUES ('Rice Cake', 'Cereal Grain');
INSERT INTO Ingredient(ingName, type) VALUES ('Fish Cake', 'Seafood');
INSERT INTO Ingredient(ingName, type) VALUES ('Cornstarch', 'Cereal grain');
INSERT INTO Ingredient(ingName, type) VALUES ('Dried Kelp', 'Seaweed');
INSERT INTO Ingredient(ingName, type) VALUES ('Sausage', 'Meat');
INSERT INTO Ingredient(ingName, type) VALUES ('Olive Oil', 'Oil');
INSERT INTO Ingredient(ingName, type) VALUES ('Onion', 'Vegetable');
INSERT INTO Ingredient(ingName, type) VALUES ('Mushroom', 'Vegetable');
INSERT INTO Ingredient(ingName, type) VALUES ('Garlic', 'Vegetable');
INSERT INTO Ingredient(ingName, type) VALUES ('Potato', 'Vegetable');
INSERT INTO Ingredient(ingName, type) VALUES ('Carrot', 'Vegetable');
INSERT INTO Ingredient(ingName, type) VALUES ('Curry Flake', 'Spice');
INSERT INTO Ingredient(ingName, type) VALUES ('Broccoli', 'Vegetable');
INSERT INTO Ingredient(ingName, type) VALUES ('Bacon', 'Meat');
INSERT INTO Ingredient(ingName, type) VALUES ('Milk', 'Dairy Product');
INSERT INTO Ingredient(ingName, type) VALUES ('Cream', 'Dairy Product');
INSERT INTO Ingredient(ingName, type) VALUES ('Salt', 'Condiment');
INSERT INTO Ingredient(ingName, type) VALUES ('Pepper', 'Condiment');
INSERT INTO Ingredient(ingName, type) VALUES ('Parmesan Cheese', 'Dairy Product');
INSERT INTO Ingredient(ingName, type) VALUES ('Rib Eye Fillet', 'Meat');
INSERT INTO Ingredient(ingName, type) VALUES ('Bell Pepper', 'Vegetable');
INSERT INTO Ingredient(ingName, type) VALUES ('Flour', 'Cereal Grain');
INSERT INTO Ingredient(ingName, type) VALUES ('Paprika', 'Condiment');
INSERT INTO Ingredient(ingName, type) VALUES ('Seasoning', 'Spice');
INSERT INTO Ingredient(ingName, type) VALUES ('Egg', 'Dairy Product');
INSERT INTO Ingredient(ingName, type) VALUES ('Chicken', 'Meat');
INSERT INTO Ingredient(ingName, type) VALUES ('Tomato Sauce', 'Sauce');
INSERT INTO Ingredient(ingName, type) VALUES ('Honey', 'Sugar');
INSERT INTO Ingredient(ingName, type) VALUES ('Ginger', 'Condiment');
INSERT INTO Ingredient(ingName, type) VALUES ('Butter', 'Dairy Product');
INSERT INTO Ingredient(ingName, type) VALUES ('Pork Belly', 'Meat');
INSERT INTO Ingredient(ingName, type) VALUES ('Noodle', 'Cereal Grain');

--------------- List  --------------->
INSERT INTO List(postId, ingName) VALUES (1, 'Gochujang');
INSERT INTO List(postId, ingName) VALUES (1, 'Sugar');
INSERT INTO List(postId, ingName) VALUES (1, 'Rice Cake');
INSERT INTO List(postId, ingName) VALUES (1, 'Fish Cake');
INSERT INTO List(postId, ingName) VALUES (1, 'Soy Sauce');
INSERT INTO List(postId, ingName) VALUES (1, 'Gochugaru');
INSERT INTO List(postId, ingName) VALUES (1, 'Sesame Seed');
INSERT INTO List(postId, ingName) VALUES (1, 'Sesame Oil');
INSERT INTO List(postId, ingName) VALUES (1, 'Green Onion');

INSERT INTO List(postId, ingName) VALUES (2, 'Black Bean Paste');
INSERT INTO List(postId, ingName) VALUES (2, 'Rice Cake');
INSERT INTO List(postId, ingName) VALUES (2, 'Fish Cake');
INSERT INTO List(postId, ingName) VALUES (2, 'Green Onion');
INSERT INTO List(postId, ingName) VALUES (2, 'Carrot');
INSERT INTO List(postId, ingName) VALUES (2, 'Potato');
INSERT INTO List(postId, ingName) VALUES (2, 'Cornstarch');
INSERT INTO List(postId, ingName) VALUES (2, 'Dried Kelp');
INSERT INTO List(postId, ingName) VALUES (2, 'Sugar');
INSERT INTO List(postId, ingName) VALUES (2, 'Soy Sauce');

INSERT INTO List(postId, ingName) VALUES (3, 'Rice Cake');
INSERT INTO List(postId, ingName) VALUES (3, 'Fish Cake');
INSERT INTO List(postId, ingName) VALUES (3, 'Sausage');
INSERT INTO List(postId, ingName) VALUES (3, 'Olive Oil');
INSERT INTO List(postId, ingName) VALUES (3, 'Onion');
INSERT INTO List(postId, ingName) VALUES (3, 'Mushroom');
INSERT INTO List(postId, ingName) VALUES (3, 'Garlic');
INSERT INTO List(postId, ingName) VALUES (3, 'Potato');
INSERT INTO List(postId, ingName) VALUES (3, 'Carrot');
INSERT INTO List(postId, ingName) VALUES (3, 'Curry Flake');

INSERT INTO List(postId, ingName) VALUES (4, 'Rice Cake');
INSERT INTO List(postId, ingName) VALUES (4, 'Fish Cake');
INSERT INTO List(postId, ingName) VALUES (4, 'Garlic');
INSERT INTO List(postId, ingName) VALUES (4, 'Broccoli');
INSERT INTO List(postId, ingName) VALUES (4, 'Onion');
INSERT INTO List(postId, ingName) VALUES (4, 'Bacon');
INSERT INTO List(postId, ingName) VALUES (4, 'Milk');
INSERT INTO List(postId, ingName) VALUES (4, 'Cream');
INSERT INTO List(postId, ingName) VALUES (4, 'Salt');
INSERT INTO List(postId, ingName) VALUES (4, 'Pepper');
INSERT INTO List(postId, ingName) VALUES (4, 'Parmesan Cheese');

INSERT INTO List(postId, ingName) VALUES (5, 'Rice Cake');
INSERT INTO List(postId, ingName) VALUES (5, 'Fish Cake');
INSERT INTO List(postId, ingName) VALUES (5, 'Rib Eye Fillet');
INSERT INTO List(postId, ingName) VALUES (5, 'Mushroom');
INSERT INTO List(postId, ingName) VALUES (5, 'Onion');
INSERT INTO List(postId, ingName) VALUES (5, 'Bell Pepper');
INSERT INTO List(postId, ingName) VALUES (5, 'Olive Oil');

INSERT INTO List(postId, ingName) VALUES (6, 'Flour');
INSERT INTO List(postId, ingName) VALUES (6, 'Salt');
INSERT INTO List(postId, ingName) VALUES (6, 'Paprika');
INSERT INTO List(postId, ingName) VALUES (6, 'Pepper');
INSERT INTO List(postId, ingName) VALUES (6, 'Seasoning');
INSERT INTO List(postId, ingName) VALUES (6, 'Egg');
INSERT INTO List(postId, ingName) VALUES (6, 'Chicken');

INSERT INTO List(postId, ingName) VALUES (7, 'Chicken');
INSERT INTO List(postId, ingName) VALUES (7, 'Flour');
INSERT INTO List(postId, ingName) VALUES (7, 'Salt');
INSERT INTO List(postId, ingName) VALUES (7, 'Paprika');
INSERT INTO List(postId, ingName) VALUES (7, 'Pepper');
INSERT INTO List(postId, ingName) VALUES (7, 'Seasoning');
INSERT INTO List(postId, ingName) VALUES (7, 'Egg');
INSERT INTO List(postId, ingName) VALUES (7, 'Tomato Sauce');
INSERT INTO List(postId, ingName) VALUES (7, 'Gochujang');
INSERT INTO List(postId, ingName) VALUES (7, 'Honey');
INSERT INTO List(postId, ingName) VALUES (7, 'Sugar');
INSERT INTO List(postId, ingName) VALUES (7, 'Soy Sauce');
INSERT INTO List(postId, ingName) VALUES (7, 'Garlic');
INSERT INTO List(postId, ingName) VALUES (7, 'Sesame Oil');

INSERT INTO List(postId, ingName) VALUES (8, 'Chicken');
INSERT INTO List(postId, ingName) VALUES (8, 'Olive Oil');
INSERT INTO List(postId, ingName) VALUES (8, 'Garlic');
INSERT INTO List(postId, ingName) VALUES (8, 'Salt');
INSERT INTO List(postId, ingName) VALUES (8, 'Pepper');
INSERT INTO List(postId, ingName) VALUES (8, 'Honey');
INSERT INTO List(postId, ingName) VALUES (8, 'Butter');

INSERT INTO List(postId, ingName) VALUES (9, 'Dried Kelp');
INSERT INTO List(postId, ingName) VALUES (9, 'Soy Sauce');
INSERT INTO List(postId, ingName) VALUES (9, 'Pork Belly');
INSERT INTO List(postId, ingName) VALUES (9, 'Pepper');
INSERT INTO List(postId, ingName) VALUES (9, 'Olive Oil');
INSERT INTO List(postId, ingName) VALUES (9, 'Carrot');
INSERT INTO List(postId, ingName) VALUES (9, 'Garlic');
INSERT INTO List(postId, ingName) VALUES (9, 'Ginger');
INSERT INTO List(postId, ingName) VALUES (9, 'Egg');
INSERT INTO List(postId, ingName) VALUES (9, 'Noodle');

INSERT INTO List(postId, ingName) VALUES (10, 'Dried Kelp');
INSERT INTO List(postId, ingName) VALUES (10, 'Soy Sauce');
INSERT INTO List(postId, ingName) VALUES (10, 'Pork Belly');
INSERT INTO List(postId, ingName) VALUES (10, 'Pepper');
INSERT INTO List(postId, ingName) VALUES (10, 'Olive Oil');
INSERT INTO List(postId, ingName) VALUES (10, 'Carrot');
INSERT INTO List(postId, ingName) VALUES (10, 'Garlic');
INSERT INTO List(postId, ingName) VALUES (10, 'Ginger');
INSERT INTO List(postId, ingName) VALUES (10, 'Egg');
INSERT INTO List(postId, ingName) VALUES (10, 'Noodle');
INSERT INTO List(postId, ingName) VALUES (10, 'Mushroom');
INSERT INTO List(postId, ingName) VALUES (10, 'Green Onion');
INSERT INTO List(postId, ingName) VALUES (10, 'Onion');
INSERT INTO List(postId, ingName) VALUES (10, 'Salt');


--------------- Blog  --------------->
 INSERT INTO Blog(postId, category) VALUES (11, 'Food Tour');
 INSERT INTO Blog(postId, category) VALUES (12, 'Food Tour');
 INSERT INTO Blog(postId, category) VALUES (13, 'Food Tour');
 INSERT INTO Blog(postId, category) VALUES (14, 'Food Tour');
 INSERT INTO Blog(postId, category) VALUES (15, 'Food Tour');


--------------- Users  --------------->
INSERT INTO Users(userId, name, email, password) VALUES (1, 'Bob', 'bob@ubc.ca', '123456');
INSERT INTO Users(userId, name, email, password) VALUES (2, 'David', 'david@gmail.com', '123456');
INSERT INTO Users(userId, name, email, password) VALUES (3, 'Erin', 'erin@microsoft.com', '123456');
INSERT INTO Users(userId, name, email, password) VALUES (4, 'Huan', 'huan@ubc.ca', '123456');
INSERT INTO Users(userId, name, email, password) VALUES (5, 'Jenny', 'jenny@ubc.ca', '123456');

--------------- UserType  --------------->
INSERT INTO UserType(email, type) VALUES ('bob@ubc.ca', 'student');
INSERT INTO UserType(email, type) VALUES ('david@gmail.com', 'personal');
INSERT INTO UserType(email, type) VALUES ('erin@microsoft.com', 'business');
INSERT INTO UserType(email, type) VALUES ('huan@ubc.ca', 'student');
INSERT INTO UserType(email, type) VALUES ('jenny@ubc.ca', 'student');

--------------- GroceryStore  --------------->
INSERT INTO GroceryStore(storeId, name, address) VALUES (1, 'Walmart', 'Downtown');
INSERT INTO GroceryStore(storeId, name, address) VALUES (2, 'Super Store', 'Richmond');
INSERT INTO GroceryStore(storeId, name, address) VALUES (3, 'Costco', 'Downtown');
INSERT INTO GroceryStore(storeId, name, address) VALUES (4, 'Walmart', 'Burnaby');
INSERT INTO GroceryStore(storeId, name, address) VALUES (5, 'NoFrills', 'West Point Grey');

--------------- Inform  --------------->
INSERT INTO Inform(postId, storeId) VALUES (1, 1);
INSERT INTO Inform(postId, storeId) VALUES (1, 2);
INSERT INTO Inform(postId, storeId) VALUES (1, 3);
INSERT INTO Inform(postId, storeId) VALUES (2, 1);
INSERT INTO Inform(postId, storeId) VALUES (2, 2);
INSERT INTO Inform(postId, storeId) VALUES (3, 3);
INSERT INTO Inform(postId, storeId) VALUES (3, 5);
INSERT INTO Inform(postId, storeId) VALUES (4, 1);
INSERT INTO Inform(postId, storeId) VALUES (4, 4);
INSERT INTO Inform(postId, storeId) VALUES (5, 1);
INSERT INTO Inform(postId, storeId) VALUES (5, 3);
INSERT INTO Inform(postId, storeId) VALUES (5, 5);
INSERT INTO Inform(postId, storeId) VALUES (6, 2);
INSERT INTO Inform(postId, storeId) VALUES (6, 3);
INSERT INTO Inform(postId, storeId) VALUES (6, 4);
INSERT INTO Inform(postId, storeId) VALUES (7, 3);
INSERT INTO Inform(postId, storeId) VALUES (7, 2);
INSERT INTO Inform(postId, storeId) VALUES (8, 1);
INSERT INTO Inform(postId, storeId) VALUES (8, 4);
INSERT INTO Inform(postId, storeId) VALUES (9, 3);
INSERT INTO Inform(postId, storeId) VALUES (9, 5);
INSERT INTO Inform(postId, storeId) VALUES (10, 1);
INSERT INTO Inform(postId, storeId) VALUES (10, 2);

--------------- MealKit  --------------->
INSERT INTO MealKit(SKU, name, price, instruction) VALUES (101, 'Tteokbokki', 20, '1. poor 250ml of water into a pot. 2. put sauce and rice cake. 3. boil for 5 min. 4. enjoy!');
INSERT INTO MealKit(SKU, name, price, instruction) VALUES (102, 'Jjajang Tteokbokki', 30, '1. poor 250ml of water into a pot. 2. put Jjajang sauce and rice cake. 3. boil for 5 min. 4. enjoy!');
INSERT INTO MealKit(SKU, name, price, instruction) VALUES (103, 'Curry Tteokbokki', 25, '1. poor 250ml of water into a pot. 2. put Curry sauce and rice cake. 3. boil for 5 min. 4. enjoy!');
INSERT INTO MealKit(SKU, name, price, instruction) VALUES (104, 'Carbonara Tteokbokki', 30, '1. poor 250ml of water into a pot. 2. put Carbonara sauce and rice cake. 3. boil for 5 min. 4. enjoy!');
INSERT INTO MealKit(SKU, name, price, instruction) VALUES (105, 'Gungjung Tteokbokki', 15, '1. poor 250ml of water into a pot. 2. put Gungjung sauce and rice cake. 3. boil for 5 min. 4. enjoy!');
INSERT INTO MealKit(SKU, name, price, instruction) VALUES (106, 'Fried Chicken', 20, '1. preheat oven. 2. put frozen chicken in the oven. 3. enjoy!');
INSERT INTO MealKit(SKU, name, price, instruction) VALUES (107, 'Korean Fried Chicken', 20, '1. preheat oven. 2. put frozen chicken in the oven. 3. enjoy!');
INSERT INTO MealKit(SKU, name, price, instruction) VALUES (108, 'Buffalo Wing', 22, '1. preheat oven. 2. put frozen wing in the oven. 3. enjoy!');
INSERT INTO MealKit(SKU, name, price, instruction) VALUES (109, 'Shoyu Ramen', 23, '1. boil noodle. 2. microwave soup. 3. put all together and enjoy!');
INSERT INTO MealKit(SKU, name, price, instruction) VALUES (110, 'Tonkotsu Ramen', 24, '1. boil noodle. 2. microwave pork and soup. 3. put all together and enjoy!');

--------------- Explains  --------------->
INSERT INTO Explains(SKU, postId) VALUES (101, 1);
INSERT INTO Explains(SKU, postId) VALUES (102, 2);
INSERT INTO Explains(SKU, postId) VALUES (103, 3);
INSERT INTO Explains(SKU, postId) VALUES (104, 4);
INSERT INTO Explains(SKU, postId) VALUES (105, 5);
INSERT INTO Explains(SKU, postId) VALUES (106, 6);
INSERT INTO Explains(SKU, postId) VALUES (107, 7);
INSERT INTO Explains(SKU, postId) VALUES (108, 8);
INSERT INTO Explains(SKU, postId) VALUES (109, 9);
INSERT INTO Explains(SKU, postId) VALUES (110, 10);

--------------- Orders  --------------->
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (1, '131', 1, '2019', '02', '28');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (2, '132', 1, '2019', '03', '05');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (3, '133', 1, '2019', '03', '13');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (4, '134', 1, '2019', '03', '18');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (5, '135', 1, '2019', '03', '21');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (6, '136', 1, '2019', '04', '02');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (7, '137', 1, '2019', '04', '09');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (8, '138', 1, '2019', '04', '19');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (9, '139', 1, '2019', '04', '27');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (10, '140', 1, '2022', '04', '02');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (11, '141', 1, '2022', '04', '09');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (12, '142', 1, '2022', '04', '19');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (13, '143', 1, '2022', '04', '27');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (14, '144', 1, '2022', '05', '03');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (15, '145', 1, '2022', '05', '11');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (16, '146', 1, '2022', '05', '22');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (17, '147', 1, '2022', '05', '29');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (18, '148', 2, '2019', '02', '21');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (19, '149', 2, '2020', '02', '28');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (20, '150', 2, '2021', '03', '05');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (21, '151', 2, '2022', '03', '13');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (22, '152', 2, '2022', '08', '18');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (23, '153', 3, '2022', '08', '21');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (24, '154', 3, '2022', '08', '28');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (25, '155', 3, '2022', '09', '05');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (26, '156', 3, '2022', '09', '13');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (27, '157', 3, '2022', '09', '18');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (28, '158', 4, '2022', '10', '21');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (29, '159', 4, '2022', '10', '28');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (30, '160', 4, '2022', '12', '05');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (31, '161', 5, '2022', '07', '13');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (32, '162', 5, '2022', '07', '18');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (33, '163', 1, '2022', '05', '15');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (34, '164', 1, '2022', '04', '14');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (35, '165', 1, '2022', '03', '13');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (36, '166', 1, '2022', '02', '12');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (37, '167', 1, '2022', '01', '11');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (38, '168', 2, '2022', '05', '20');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (39, '169', 2, '2022', '04', '22');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (40, '170', 2, '2022', '03', '29');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (41, '171', 3, '2021', '11', '11');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (42, '172', 3, '2022', '10', '22');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (43, '173', 4, '2022', '02', '11');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (44, '174', 5, '2022', '12', '22');
INSERT INTO Orders(orderId, trackingId, userId, year, month, day) VALUES (45, '175', 1, '2019', '02', '21');
--------------- Contain  --------------->
INSERT INTO Contain(SKU, orderId) VALUES (101, 1);
INSERT INTO Contain(SKU, orderId) VALUES (101, 2);
INSERT INTO Contain(SKU, orderId) VALUES (102, 3);
INSERT INTO Contain(SKU, orderId) VALUES (104, 4);
INSERT INTO Contain(SKU, orderId) VALUES (110, 5);
INSERT INTO Contain(SKU, orderId) VALUES (102, 6);
INSERT INTO Contain(SKU, orderId) VALUES (107, 7);
INSERT INTO Contain(SKU, orderId) VALUES (107, 8);
INSERT INTO Contain(SKU, orderId) VALUES (102, 9);
INSERT INTO Contain(SKU, orderId) VALUES (107, 10);
INSERT INTO Contain(SKU, orderId) VALUES (110, 11);
INSERT INTO Contain(SKU, orderId) VALUES (102, 12);
INSERT INTO Contain(SKU, orderId) VALUES (107, 13);
INSERT INTO Contain(SKU, orderId) VALUES (110, 14);
INSERT INTO Contain(SKU, orderId) VALUES (102, 15);
INSERT INTO Contain(SKU, orderId) VALUES (104, 16);
INSERT INTO Contain(SKU, orderId) VALUES (101, 17);
INSERT INTO Contain(SKU, orderId) VALUES (104, 18);
INSERT INTO Contain(SKU, orderId) VALUES (103, 19);
INSERT INTO Contain(SKU, orderId) VALUES (105, 20);
INSERT INTO Contain(SKU, orderId) VALUES (102, 21);
INSERT INTO Contain(SKU, orderId) VALUES (105, 22);
INSERT INTO Contain(SKU, orderId) VALUES (105, 23);
INSERT INTO Contain(SKU, orderId) VALUES (110, 24);
INSERT INTO Contain(SKU, orderId) VALUES (104, 25);
INSERT INTO Contain(SKU, orderId) VALUES (101, 26);
INSERT INTO Contain(SKU, orderId) VALUES (102, 27);
INSERT INTO Contain(SKU, orderId) VALUES (104, 28);
INSERT INTO Contain(SKU, orderId) VALUES (109, 29);
INSERT INTO Contain(SKU, orderId) VALUES (105, 30);
INSERT INTO Contain(SKU, orderId) VALUES (109, 31);
INSERT INTO Contain(SKU, orderId) VALUES (104, 32);
INSERT INTO Contain(SKU, orderId) VALUES (101, 33);
INSERT INTO Contain(SKU, orderId) VALUES (102, 34);
INSERT INTO Contain(SKU, orderId) VALUES (103, 35);
INSERT INTO Contain(SKU, orderId) VALUES (104, 36);
INSERT INTO Contain(SKU, orderId) VALUES (105, 37);
INSERT INTO Contain(SKU, orderId) VALUES (101, 38);
INSERT INTO Contain(SKU, orderId) VALUES (102, 39);
INSERT INTO Contain(SKU, orderId) VALUES (103, 40);
INSERT INTO Contain(SKU, orderId) VALUES (104, 41);
INSERT INTO Contain(SKU, orderId) VALUES (105, 42);
INSERT INTO Contain(SKU, orderId) VALUES (103, 43);
INSERT INTO Contain(SKU, orderId) VALUES (105, 44);
INSERT INTO Contain(SKU, orderId) VALUES (105, 45);

--------------- OrderAddress  --------------->
INSERT INTO OrderAddress(trackingId, address) VALUES ('131', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('132', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('133', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('134', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('135', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('136', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('137', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('138', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('139', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('140', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('141', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('142', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('143', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('144', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('145', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('146', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('147', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('148', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('149', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('150', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('151', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('152', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('153', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('154', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('155', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('156', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('157', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('158', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('159', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('160', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('161', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('162', '308 Negra Arroyo Lane');
INSERT INTO OrderAddress(trackingId, address) VALUES ('163','Vancouver');
INSERT INTO OrderAddress(trackingId, address) VALUES ('164','Vancouver');
INSERT INTO OrderAddress(trackingId, address) VALUES ('165','Vancouver');
INSERT INTO OrderAddress(trackingId, address) VALUES ('166','Vancouver');
INSERT INTO OrderAddress(trackingId, address) VALUES ('167','Vancouver');
INSERT INTO OrderAddress(trackingId, address) VALUES ('168','Toronto');
INSERT INTO OrderAddress(trackingId, address) VALUES ('169','Toronto');
INSERT INTO OrderAddress(trackingId, address) VALUES ('170','Toronto');
INSERT INTO OrderAddress(trackingId, address) VALUES ('171','New York');
INSERT INTO OrderAddress(trackingId, address) VALUES ('172','New York');
INSERT INTO OrderAddress(trackingId, address) VALUES ('173','Seattle');
INSERT INTO OrderAddress(trackingId, address) VALUES ('174','San Francisco');
INSERT INTO OrderAddress(trackingId, address) VALUES ('175', '308 Negra Arroyo Lane');

commit;