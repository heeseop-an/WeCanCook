<?php
    //this tells the system that it's no longer just parsing html; it's now parsing PHP

    $success = True; //keep track of errors so it redirects the page only if there are no errors
    $db_conn = NULL; // edit the login credentials in connectToDB()
    $show_debug_alert_messages = True; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

    function debugAlertMessage($message) {
        global $show_debug_alert_messages;

        if ($show_debug_alert_messages) {
            echo "<script type='text/javascript'>alert('" . $message . "');</script>";
        }
    }

    function executePlainSQL($sql) { //takes a plain (no bound variables) SQL command and executes it
        //echo "<br>running ".$cmdstr."<br>";
        global $db_conn, $success;
        
        connectToDB();

        $statement = OCIParse($db_conn, $sql);
        //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

        if (!$statement) {
            echo "<br>Cannot parse the following command: " . $sql . "<br>";
            $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
            echo htmlentities($e['message']);
            $success = False;
        }

        $r = OCIExecute($statement, OCI_DEFAULT);
        if (!$r) {
            echo "<br>Cannot execute the following command: " . $sql . "<br>";
            $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
            echo htmlentities($e['message']);
            $success = False;
        }

        disconnectFromDB();
        return $statement;
    }

    function executeBoundSQL($cmdstr, $list) {
        /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
    In this case you don't need to create the statement several times. Bound variables cause a statement to only be
    parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection.
    See the sample code below for how this function is used */

        global $db_conn, $success;
        $statement = OCIParse($db_conn, $cmdstr);

        if (!$statement) {
            echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
            $e = OCI_Error($db_conn);
            echo htmlentities($e['message']);
            $success = False;
        }

        foreach ($list as $tuple) {
            foreach ($tuple as $bind => $val) {
                //echo $val;
                //echo "<br>".$bind."<br>";
                OCIBindByName($statement, $bind, $val);
                unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
            }

            $r = OCIExecute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($statement); // For OCIExecute errors, pass the statementhandle
                echo htmlentities($e['message']);
                echo "<br>";
                $success = False;
            }
        }
    }

    function printResult($result) { //prints results from a select statement
        echo "<br>Retrieved data from table demoTable:<br>";
        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

    function connectToDB() {
        global $db_conn;
        // Your username is ora_(CWL_ID) and the password is a(student number). For example,
        // ora_platypus is the username and a12345678 is the password.
        $db_conn = OCILogon("ora_an94318", "a78513967", "dbhost.students.cs.ubc.ca:1522/stu");
    
        if ($db_conn) {

            // debugAlertMessage("Database is Connected");


            OCICommit($db_conn);

            return true;
        } else {
            debugAlertMessage("Cannot connect to Database");
            $e = OCI_Error(); // For OCILogon errors pass no handle
            echo htmlentities($e['message']);
            return false;
        }
    }

    function disconnectFromDB() {
        global $db_conn;

        // debugAlertMessage("Disconnect from Database");
        OCILogoff($db_conn);
    }

    function handleUpdateRequest() {
        global $db_conn;

        $old_name = $_POST['oldName'];
        $new_name = $_POST['newName'];
       
        // you need the wrap the old name and new name values with single quotations
        executePlainSQL("UPDATE demoTable SET name='" . $new_name . "' WHERE name='" . $old_name . "'");
        OCICommit($db_conn);
    }

    function insertCommentRequest() {
        global $db_conn;

        //Getting the values from user and insert data into the table
        $tuple = array (
            ":bind1" => $_POST['insNo'],
            ":bind2" => $_POST['insName']
        );

        $alltuples = array (
            $tuple
        );

        executeBoundSQL("insert into demoTable values (:bind1, :bind2)", $alltuples);
        OCICommit($db_conn);
    }

    function handleRowRequest($sql) {
        connectToDB();

        $result = executePlainSQL($sql);
        disconnectFromDB();    
        return $result;
    }

    // HANDLE ALL GET ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
    function handleGETRequest() {
        if (connectToDB()) {
            if (array_key_exists('countTuples', $_GET)) {
                handleCountRequest();
            }

            disconnectFromDB();
        }
    }

    if(isset($_POST['login'])) {
        $isEmail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

        
        executePlainSQL("DROP TABLE List");
        executePlainSQL("DROP TABLE Inform");
        executePlainSQL("DROP TABLE Explains");
        executePlainSQL("DROP TABLE Ingredient");
        executePlainSQL("DROP TABLE MealPosts");
        executePlainSQL("DROP TABLE Blog");
        executePlainSQL("DROP TABLE Post");  
        executePlainSQL("DROP TABLE Contain");
        executePlainSQL("DROP TABLE GroceryStore");
        executePlainSQL("DROP TABLE OrderAddress");
        executePlainSQL("DROP TABLE Orders");
        executePlainSQL("DROP TABLE Comments");
        executePlainSQL("DROP TABLE MealKit");
        executePlainSQL("DROP TABLE Users");
        executePlainSQL("DROP TABLE UserType");
        executePlainSQL("DROP TABLE Comments");
        
        executePlainSQL("CREATE TABLE Comments (postId INT, commentId INT, rating INT, content CHAR(2000), userId INT, PRIMARY KEY (postId, commentId), FOREIGN KEY (userId) REFERENCES Users)");  
        executePlainSQL("CREATE TABLE Post (postId INT PRIMARY KEY, title CHAR(200), content CHAR(1000))");
        executePlainSQL("CREATE TABLE MealPosts (postId INT PRIMARY KEY,  dietType CHAR(100), instruction CHAR(2000), rate INT)"); 
        executePlainSQL("CREATE TABLE Ingredient (ingName CHAR(100)	PRIMARY KEY, type CHAR(100))");
        executePlainSQL("CREATE TABLE List (postId INT, ingName	CHAR(100), PRIMARY KEY (postId, ingName), FOREIGN KEY (postId) REFERENCES MealPosts(postId) ON DELETE CASCADE, FOREIGN KEY (ingName) REFERENCES Ingredient(ingName) ON DELETE CASCADE)");
        executePlainSQL("CREATE TABLE Blog (postId INT PRIMARY KEY, category CHAR(100), FOREIGN KEY (postId) REFERENCES Post(postId) ON DELETE CASCADE)");
        executePlainSQL("CREATE TABLE GroceryStore (storeId INT PRIMARY KEY, name CHAR(100), address CHAR(100))");
        executePlainSQL("CREATE TABLE Inform (postId INT, storeId INT, PRIMARY KEY (postId, storeId), FOREIGN KEY (postId) REFERENCES MealPosts ON DELETE CASCADE, FOREIGN KEY (storeId) REFERENCES GroceryStore ON DELETE CASCADE)");
        executePlainSQL("CREATE TABLE MealKit (SKU INT PRIMARY KEY, name CHAR(100))");
        executePlainSQL("CREATE TABLE Users (userId INT PRIMARY KEY, name CHAR(100), email CHAR(100), password CHAR(100))");
        executePlainSQL("CREATE TABLE UserType (email CHAR(100) PRIMARY KEY, type CHAR(100))");
        executePlainSQL("CREATE TABLE Orders (orderId INT PRIMARY KEY, trackingId CHAR(100) UNIQUE, userId INT UNIQUE, year CHAR(4), month CHAR(2), day CHAR(2), FOREIGN KEY (userId) REFERENCES Users ON DELETE CASCADE)");
        executePlainSQL("CREATE TABLE OrderAddress (trackingId CHAR(100) PRIMARY KEY, address CHAR(100))");
        executePlainSQL("CREATE TABLE Contain (SKU INT, orderId INT, PRIMARY KEY (SKU, orderId), FOREIGN KEY (SKU) REFERENCES MealKit ON DELETE CASCADE, FOREIGN KEY (orderId) REFERENCES Orders ON DELETE CASCADE)");
        executePlainSQL("CREATE TABLE Comments (postId INT, commentId INT, rating INT, content CHAR(2000), userId INT, PRIMARY KEY (postId, commentId), FOREIGN KEY (userId) REFERENCES Users)");
        executePlainSQL("CREATE TABLE Explains (SKU INT, postId INT, PRIMARY KEY (SKU, postId), FOREIGN KEY (SKU) REFERENCES MealKit ON DELETE CASCADE, FOREIGN KEY (postId) REFERENCES MealPosts ON DELETE CASCADE)");
                
        
        // <!--------------- Post  --------------->
        executePlainSQL("INSERT INTO Post(postId, title, content) VALUES (1, 'Tteokbokki', 'Tteokbokki is one of the most popular Korean street foods in Korea. Among other things, today'' s recipe is made with Korean rice cakes, Korean fish cakes, Korean soup stock / dashi stock and gochujang (Korean chili paste)!')");
        executePlainSQL("INSERT INTO Post(postId, title, content) VALUES (2, 'Jjajang Tteokbokki', 'Jjajang tteokbokki known as Korean Black Bean Tteokbokki, is a delicious 15 mins recipe made with chewy Korean rice cakes in a black bean sauce!')");
        executePlainSQL("INSERT INTO Post(postId, title, content) VALUES (3, 'Curry Tteokbokki', 'Curry Tteokbokki Korean Kare- a hearty, rich and comforting dish made with rice cakes, sausages, potatoes, carrots, onions, and mushrooms; all simmered in a thick and flavorsome curry sauce.')");
        executePlainSQL("INSERT INTO Post(postId, title, content) VALUES (4, 'Carbonara Tteokbokki', 'Korean Cream Carbonara Tteokbokki is a fusion rice cake dish, made with smokey bacon, lashings of cream and a generous sprinkling of black pepper.')");
        executePlainSQL("INSERT INTO Post(postId, title, content) VALUES (5, 'Gungjung Tteokbokki', 'Gungjung tteokbokki is the traditional version of tteokbokki. Gungjung means ''royal court'' in Korean. Unlike today''s red spicy version, this traditional version is mildly flavored with a soy sauce based sauce.')");
        executePlainSQL("INSERT INTO Post(postId, title, content) VALUES (6, 'Fried Chicken', 'Fried chicken, also known as Southern fried chicken, is a dish consisting of chicken pieces that have been coated with seasoned flour or batter and pan-fried, deep fried, pressure fried, or air fried.')");
        executePlainSQL("INSERT INTO Post(postId, title, content) VALUES (7, 'Korean Fried Chicken', 'Korean fried chicken, usually called chikin in Korea, refers to a variety of fried chicken dishes created in South Korea, including the basic huraideu-chicken and spicy yangnyeom chicken.')");
        executePlainSQL("INSERT INTO Post(postId, title, content) VALUES (8, 'Buffalo Wing', 'A Buffalo Wing in American cuisine is an unbreaded chicken wing section that is generally deep-fried and then coated or dipped in a sauce consisting of a vinegar-based cayenne pepper hot sauce and melted butter prior to serving.')");
        executePlainSQL("INSERT INTO Post(postId, title, content) VALUES (9, 'Shoyu Ramen', '''Shoyu'' means soy sauce in Japanese. Shoyu ramen simply refers to ramen served with a soy sauce-based broth that is usually in clear, brown color.')");
        executePlainSQL("INSERT INTO Post(postId, title, content) VALUES (10, 'Tonkotsu Ramen', 'Tonkotsu ramen is the king of Japenese soups for a reason. Deeply flavourful broth is in perfect balance with the pork and those wonderful ramen noodles.')");
        
         executePlainSQL("INSERT INTO Post(postId, title, content) VALUES (11, 'Dongdaemun Yupdduk', 'Honestly, Yupdduk is just unbelievable amazing. I get takeout nearly every day, and the sausage just hits differently. Always grab additional sausage with your order; you won''t be sorry. I don''t usually purchase the rice balls since, as I previously said, I usually order takeout and can create the rice balls myself with only rice and seaweed from Costco. However, if I''m out with friends and dining out at a restaurant, I always make sure to get it since the combination is fantastic! If you are a typical eater, the quantities will be more than plenty! My friend and I didn''t eat the remainder of the spicy rice cakes. I don''t know what to say about the eggs since I''ve never eaten them LOL. but my friend would always bring it home for his brother to eat it because apparently he likes it a lot. ANYWAYS LOVE YUPDDUK')");
         executePlainSQL("INSERT INTO Post(postId, title, content) VALUES (12, 'Sinjeon Tteokbokki', 'Delicious Korean street food! Ordered takeout at the restaurant and the staff were super friendly. Had to wait a little longer than usual and the staff were very apologetic for it and gave us an extra fried set on the house. Super friendly and super delicious food! The cheese tteokbokki had the cheese pull and the mild wasn''t too spicy. Overall would definitely visit again!')");
         executePlainSQL("INSERT INTO Post(postId, title, content) VALUES (13, 'bbq Chicken', 'Absolutely amazing authentic korean fried chicken place! What more can you ask for? You got hot and crispy , saucy, finger-lickin good chicken, cold beer, and sumptuous  cheese balls and tteobokki....wow!! Apparently this chain is very very popular in korea, as per my korean buddy. And of course it did not disappoint! Ive tried the dasarang chicken, but this place is better. Chicken pieces were huge and fried as you order. Sauce was tangy and very flavourful. Love it ! Quality and taste all there. Chicken was not dry. Very juicy. Crispy coating was not overdone. Delicious!! The cheese balls were oozing with mozarella cheese upon being sliced. Inside was still smoking. Service was quick. Covid protocols excellent. Each table had a hand sanitizer bottle. Servers very attentive. Napkins and wet towels readily available. They have beers by the pitcher! Heaven!! Already making plans of going back!! Cheers! Happy eating!')");
         executePlainSQL("INSERT INTO Post(postId, title, content) VALUES (14, 'Kokoro', 'We got their chicken from karaage king again and their takoyaki as well. The chicken karaage were ordered with the tartar mayo sauce and although the sauce was delicious, I found the chicken a little bit too salty. The pieces were quite large but the price was also higher so it was understandable. The takoyaki was awesome with a huge plump piece of octopus in each piece, very crispy fried and with the mental mayo, it provided a different flavour that was fishy but in the best way. Overall, I didnt love the chicken today but since this place is so close to home, we will probably return soon.')");
         executePlainSQL("INSERT INTO Post(postId, title, content) VALUES (15, 'Kinton', 'UBC''s first ramen restaurant! A nice spot to enjoy a nice hot bowl of ramen to warm up after trekking across campus to class or commuting to school. The ramen is decent and pretty standard. Nothing about it sticks out to me or differentiates it from other ramen places nearby. The broth is flavorful, but a tad on the salty side. The portion sizes were average, and there definitely wasn''t enough toppings to complement the amount of noodles they give. The sides like their gyoza are good, but once again, nothing sticks out about it. Definitely on the pricer side for the quality and amount that you get. They also offer a stamp card challenge where you get a stamp each time you finish the entire bowl, including the soup. The end reward is ramen for a year, but they''re a little stingy on what finishing a bowl looks like. My friends have previously licked the bowl cleaned and were rejected of their stamp, which is a little disappointing. The staff was friendly and efficient until you''re seated, then the service gets really slow and a little pushy. I was rushed to order the moment I sat down and then waited around 30 minutes for my bowl of ramen to come out. This place gets really busy in between classes and during lunch and dinner. I''ve heard of wait times being as long as an hour, so I suggest pre-ordering for take out, or sending someone to grab a table ahead of time.')");
         
        
        // <!--------------- MealPost  --------------->
executePlainSQL("INSERT INTO MealPosts(postId, dietType, instruction, rate) VALUES (1, 'pescatarians', 'Unless your rice cakes are soft already, soak them in warm water for 10 mins. Boil the soup stock in a shallow pot over medium high heat and dissolve the tteokbokki sauce by stirring it with a spatula. Once the seasoned stock is boiling, add the rice cakes, fish cakes and onion. Boil them a further 3 to 5 mins until the rice cakes are fully cooked. Then, to thicken the sauce and to deepen the flavor, simmer it over low heat for a further 2 to 4 mins. Add the sesame oil, sesame seeds, and green onion then quickly stir. Serve warm.', 10)");
executePlainSQL("INSERT INTO MealPosts(postId, dietType, instruction, rate) VALUES (2, 'pescatarians', 'In a small bowl, mix together your water and cornstarch. In a medium size pot set over low heat, add your avocado oil. You want to ensure your oil is warmed. Then add in your roasted black bean paste. Fry it in the oil for 1 minute. Then add in your onion, green onions that are sliced in 1 inch pieces, and fish cakes. Give it a stir until everything is covered in the sauce. Pour in your cornstarch water and dried kelp into the pot. Mix altogether scraping the base of the pot. Allow this to boil and reduce to a simmer for 5 minutes or until sauce has thickened. Add in your rice cakes and mix into the sauce. Season with sugar. Boil this for 10 minutes until rice cakes are soft but chewy or fork tender. Transfer to a plate and sprinkle green onions and sesame seeds over top (optional).',  10)");
executePlainSQL("INSERT INTO MealPosts(postId, dietType, instruction, rate) VALUES (3, 'flextarian', 'Cut 4 sausages into bite-sized pieces using scissors. Fry off in a little oil until browned. Add half thinly sliced onion and sauté until soft. Now add 6 sliced mushrooms and stir. A few minutes later, add 4 minced garlic cloves. Cook for 3-5 minutes. Add chopped potatoes and carrots. Pour in 2 cups water. Place a lid on and allow it to cook for 15-20 minutes until softened. Pour 1 cup of water into the pot. Break up two Golden Curry blocks into smaller pieces and transfer them to the pot. Now add 1.5 cups rice cakes. Stir well until curry blocks have dissolved and rice cakes are submerged. Cook for the rice cakes for 5 minutes. Once the curry sauce has thickened, garnish with chopped green onions or chives. Serve the pan at the table.', 5)");
executePlainSQL("INSERT INTO MealPosts(postId, dietType, instruction, rate) VALUES (4, 'flextarian', 'Slice garlic, onion, bacon and the broccoli to bite-sized pieces. Rice cake is reopened when a hard boil in boiling water for 30 seconds.It''s okay if omitted. Wearing the olive oil in a preheated pan. Put the garlic, onions, broccoli order. Put the bacon and fry it. Put the milk and cream in order with salt and pepper after bacon fried. Put boiled rice cakes. Finish putting the parmesan cheese powder.', 10)");
executePlainSQL("INSERT INTO MealPosts(postId, dietType, instruction, rate) VALUES (5, 'flextarian', 'Combine the meat with the marinade. Set aside while other ingredients are being prepared. In a heated pan (on medium-high heat), add some cooking oil and the onion. Stir lightly until they are wilted. Add the meat and cook briefly (about 30 seconds) until the outer layer is cooked. Add the mushrooms, rice cakes, bell peppers and the seasoning sauce. Stir them well until all are cooked (about 2 to 3 mins). Garnish with the green onion and roasted sesame seeds. Serve.', 10)");
executePlainSQL("INSERT INTO MealPosts(postId, dietType, instruction, rate) VALUES (6, 'flextarian', 'In a large shallow dish, combine 3 cups flour, garlic salt, paprika, 3 teaspoons pepper and poultry seasoning. In another shallow dish, beat eggs and 2 cups water; add salt and the remaining 1 cups flour and 1 teaspoon pepper. Dip chicken in egg mixture, then place in flour mixture, a few pieces at a time. Turn to coat. In a deep-fat fryer, heat oil to 375 degree. Fry chicken, several pieces at a time, until chicken is golden brown and juices run clear, 7-8 minutes on each side. Drain on paper towels.', 9)");
executePlainSQL("INSERT INTO MealPosts(postId, dietType, instruction, rate) VALUES (7, 'flextarian', 'Wash chicken wings, and drain thoroughly. Mix with the salt, pepper, and ginger. Let it sit in the fridge for 2 hours or longer. Combine all the sauce ingredients of your choice and stir well. Boil over medium heat until it thickens slightly, about 4 to 5 minutes. Turn the heat off. Mix the wet batter ingredients in a bowl, and stir well until smooth with no visible lumps. Add the oil to a deep fryer, wok, or large pot. Heat the oil to 320 F. Drop the chicken in the oil, one piece at a time. If using wet batter, dip each piece in the wet batter with tongs and shake off excess batter before dropping the chicken in the oil. Fry them in two batches. Cook until lightly golden, about 6 minutes, depending on the size of the chicken wings. Remove them with a wire skimmer or a slotted spoon. Drain on a wire rack or in a large mesh strainer set on a bowl. Reheat the oil to 350 F. Add the chicken, and deep fry again, for about 5 minutes, until golden brown. Drain on a wire rack or in a large mesh strainer set on a bowl. You can either toss the fried chicken pieces in the sauce or hand-brush them. Sprinkle with the optional sesame seeds or chopped scallion to serve.', 3)");
executePlainSQL("INSERT INTO MealPosts(postId, dietType, instruction, rate) VALUES (8, 'flextarian', 'Preheat oven to 400 F and place a wire rack over a baking sheet. In a large bowl, toss chicken wings with oil and season with garlic powder, salt, and pepper. Transfer to prepared baking sheet. Bake until chicken is golden and skin is crispy, 50 to 60 minutes, flipping the wings halfway through. In a small saucepan, whisk together hot sauce and honey. Bring to simmer then stir in butter. Cook until butter is melted and slightly reduced, about 2 minutes. Heat broiler on low. Transfer baked wings to a bowl and toss with buffalo sauce until completely coated. Return wings to rack and broil—watching carefully!—until sauce caramelizes, 3 minutes. Serve with ranch dressing and vegetables.', 2)");
executePlainSQL("INSERT INTO MealPosts(postId, dietType, instruction, rate) VALUES (9, 'flextarian', 'Ingredients for shoyu ramen recipe gathered. Heat sesame oil in a deep pan over medium heat. Sauté the chopped ginger and garlic in the pan for about a minute. Garlic and ginger frying in oil in a saucepan. Lower the heat and add the chicken soup stock and kombu dashi soup stock to the pan. Bring to a boil. Combined stocks boiling in the saucepan Add the soy sauce, sake, sugar, and salt to the soup and bring to a boil again. Soy sauce and seasonings added to boiling stock. In the meantime, boil water in a large pot. Add the chukamen noodles to the boiling water and cook for a few minutes (follow package directions). Ramen noodles cooking in water in a pot. Place a fine-mesh strainer over a bowl and pour the soup through the strainer. Stock being strained through a metal strainer into a bowl. Pour the hot soup into individual bowls. Clear soup in two bowls Drain the noodles and add to the hot soup. Ramen noodles added to soup in two bowls. Add toppings, such as chopped negi and nori seaweed, if desired. Sprinkle with pepper to taste.', 3)");
executePlainSQL("INSERT INTO MealPosts(postId, dietType, instruction, rate) VALUES (10, 'flextarian', 'Make the pork broth. Transfer the trotters to a large stock pot and cover with cold water. Bring to a boil over high heat, then remove from the heat and drain in a colander, discarding the liquid. Using chopsticks, clean the bones under cold running water to remove any red or brown blood or organ pieces. Transfer the cleaned bones to a clean stock pot. In a large cast iron skillet over medium-high heat, toast the green onions, yellow onion, and ginger, turning occasionally, until the aromatics are charred in places. Add charred aromatics to the stock pot with the cleaned bones and cover with cold water. Bring to a boil over high heat, skimming off any scum that floats to the surface. Continue to boil and skim for 20 minutes, then cover and reduce to a simmer. Continue simmering, adding enough water as needed to keep bones and aromatics covered, until broth is opaque, about 6 hours. Uncover and bring to a boil. Let broth reduce to desired thickness. Strain the broth through a fine-mesh strainer and refrigerate overnight. When cool, bone broth should be very thick and gelatinous, and there should be a layer of fat on top of the broth. In a stock pot, bring pork bone broth and pork fat to a simmer over medium heat. Season to taste with salt and soy sauce. Meanwhile, bring a large pot of water to a boil. Cook ramen noodles in boiling water according to package directions. Divide the ramen noodles between two bowls and ladle the pork broth over the noodles. Top each bowl with two slices of chashu pork, enoki mushrooms, and menma. Tuck a nori sheet in between the side of the bowl and an egg half. Sprinkle the bowls with green onions and sesame seeds, and drizzle with mayu and/or chili oil, as desired.', 4)");
        
        
        // <!--------------- Ingredient  --------------->
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Gochujang', 'Condiment')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Sugar', 'Sugar')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Soy Sauce', 'Sauce')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Gochugaru', 'Spice')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Sesame Seed', 'Nut')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Sesame Oil', 'Oil')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Green Onion', 'Vegetable')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Black Bean Paste', 'Condiment')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Rice Cake', 'Cereal Grain')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Fish Cake', 'Seafood')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Cornstarch', 'Cereal grain')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Dried Kelp', 'Seaweed')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Sausage', 'Meat')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Olive Oil', 'Oil')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Onion', 'Vegetable')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Mushroom', 'Vegetable')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Garlic', 'Vegetable')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Potato', 'Vegetable')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Carrot', 'Vegetable')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Curry Flake', 'Spice')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Broccoli', 'Vegetable')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Bacon', 'Meat')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Milk', 'Dairy Product')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Cream', 'Dairy Product')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Salt', 'Condiment')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Pepper', 'Condiment')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Parmesan Cheese', 'Dairy Product')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Rib Eye Fillet', 'Meat')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Bell Pepper', 'Vegetable')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Flour', 'Cereal Grain')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Paprika', 'Condiment')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Seasoning', 'Spice')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Egg', 'Dairy Product')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Chicken', 'Meat')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Tomato Sauce', 'Sauce')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Honey', 'Sugar')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Ginger', 'Condiment')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Butter', 'Dairy Product')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Pork Belly', 'Meat')");
        executePlainSQL("INSERT INTO Ingredient(ingName, type) VALUES ('Noodle', 'Cereal Grain')");
        
        // <!--------------- List  --------------->
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (1, 'Gochujang')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (1, 'Sugar')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (1, 'Rice Cake')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (1, 'Fish Cake')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (1, 'Soy Sauce')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (1, 'Gochugaru')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (1, 'Sesame Seed')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (1, 'Sesame Oil')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (1, 'Green Onion')");
        
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (2, 'Black Bean Paste')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (2, 'Rice Cake')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (2, 'Fish Cake')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (2, 'Green Onion')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (2, 'Carrot')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (2, 'Potato')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (2, 'Cornstarch')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (2, 'Dried Kelp')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (2, 'Sugar')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (2, 'Soy Sauce')");
        
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (3, 'Rice Cake')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (3, 'Fish Cake')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (3, 'Sausage')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (3, 'Olive Oil')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (3, 'Onion')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (3, 'Mushroom')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (3, 'Garlic')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (3, 'Potato')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (3, 'Carrot')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (3, 'Curry Flake')");
        
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (4, 'Rice Cake')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (4, 'Fish Cake')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (4, 'Garlic')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (4, 'Broccoli')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (4, 'Onion')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (4, 'Bacon')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (4, 'Milk')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (4, 'Cream')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (4, 'Salt')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (4, 'Pepper')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (4, 'Parmesan Cheese')");
        
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (5, 'Rice Cake')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (5, 'Fish Cake')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (5, 'Rib Eye Fillet')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (5, 'Mushroom')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (5, 'Onion')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (5, 'Bell Pepper')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (5, 'Olive Oil')");
        
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (6, 'Flour')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (6, 'Salt')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (6, 'Paprika')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (6, 'Pepper')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (6, 'Seasoning')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (6, 'Egg')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (6, 'Chicken')");
        
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (7, 'Chicken')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (7, 'Flour')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (7, 'Salt')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (7, 'Paprika')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (7, 'Pepper')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (7, 'Seasoning')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (7, 'Egg')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (7, 'Tomato Sauce')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (7, 'Gochujang')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (7, 'Honey')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (7, 'Sugar')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (7, 'Soy Sauce')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (7, 'Garlic')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (7, 'Sesame Oil')");
        
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (8, 'Chicken')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (8, 'Olive Oil')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (8, 'Garlic')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (8, 'Salt')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (8, 'Pepper')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (8, 'Honey')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (8, 'Butter')");
        
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (9, 'Dried Kelp')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (9, 'Soy Sauce')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (9, 'Pork Belly')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (9, 'Pepper')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (9, 'Olive Oil')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (9, 'Carrot')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (9, 'Garlic')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (9, 'Ginger')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (9, 'Egg')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (9, 'Noodle')");
        
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (10, 'Dried Kelp')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (10, 'Soy Sauce')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (10, 'Pork Belly')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (10, 'Pepper')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (10, 'Olive Oil')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (10, 'Carrot')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (10, 'Garlic')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (10, 'Ginger')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (10, 'Egg')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (10, 'Noodle')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (10, 'Mushroom')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (10, 'Green Onion')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (10, 'Onion')");
        executePlainSQL("INSERT INTO List(postId, ingName) VALUES (10, 'Salt')");
        
        
        // <!--------------- Blog  --------------->
         executePlainSQL("INSERT INTO Blog(postId, category) VALUES (11, 'Food Tour')");
         executePlainSQL("INSERT INTO Blog(postId, category) VALUES (12, 'Food Tour')");
         executePlainSQL("INSERT INTO Blog(postId, category) VALUES (13, 'Food Tour')");
         executePlainSQL("INSERT INTO Blog(postId, category) VALUES (14, 'Food Tour')");
         executePlainSQL("INSERT INTO Blog(postId, category) VALUES (15, 'Food Tour')");
        
        
        // <!--------------- Users  --------------->
        executePlainSQL("INSERT INTO Users(userId, name, email, password) VALUES (1, 'Bob', 'bob@ubc.ca', '123456')");
        executePlainSQL("INSERT INTO Users(userId, name, email, password) VALUES (2, 'David', 'david@gmail.com', '123456')");
        executePlainSQL("INSERT INTO Users(userId, name, email, password) VALUES (3, 'Erin', 'erin@microsoft.com', '123456')");
        executePlainSQL("INSERT INTO Users(userId, name, email, password) VALUES (4, 'Huan', 'huan@ubc.ca', '123456')");
        executePlainSQL("INSERT INTO Users(userId, name, email, password) VALUES (5, 'Jenny', 'jenny@ubc.ca', '123456')");
        
        // <!--------------- UserType  --------------->
        executePlainSQL("INSERT INTO UserType(email, type) VALUES ('bob@ubc.ca', 'student')");
        executePlainSQL("INSERT INTO UserType(email, type) VALUES ('david@gmail.com', 'personal')");
        executePlainSQL("INSERT INTO UserType(email, type) VALUES ('erin@microsoft.com', 'business')");
        executePlainSQL("INSERT INTO UserType(email, type) VALUES ('huan@ubc.ca', 'student')");
        executePlainSQL("INSERT INTO UserType(email, type) VALUES ('jenny@ubc.ca', 'student')");
        
        // <!--------------- GroceryStore  --------------->
        executePlainSQL("INSERT INTO GroceryStore(storeId, name, address) VALUES (1, 'Walmart', 'Downtown')");
        executePlainSQL("INSERT INTO GroceryStore(storeId, name, address) VALUES (2, 'Super Store', 'Richmond')");
        executePlainSQL("INSERT INTO GroceryStore(storeId, name, address) VALUES (3, 'Costco', 'Downtown')");
        executePlainSQL("INSERT INTO GroceryStore(storeId, name, address) VALUES (4, 'Walmart', 'Burnaby')");
        executePlainSQL("INSERT INTO GroceryStore(storeId, name, address) VALUES (5, 'NoFrills', 'West Point Grey')");
        
        // <!--------------- Inform  --------------->
        executePlainSQL("INSERT INTO Inform(postId, storeId) VALUES (1, 1)");
        executePlainSQL("INSERT INTO Inform(postId, storeId) VALUES (1, 2)");
        executePlainSQL("INSERT INTO Inform(postId, storeId) VALUES (1, 3)");
        executePlainSQL("INSERT INTO Inform(postId, storeId) VALUES (2, 1)");
        executePlainSQL("INSERT INTO Inform(postId, storeId) VALUES (2, 2)");
        executePlainSQL("INSERT INTO Inform(postId, storeId) VALUES (3, 3)");
        executePlainSQL("INSERT INTO Inform(postId, storeId) VALUES (3, 5)");
        executePlainSQL("INSERT INTO Inform(postId, storeId) VALUES (4, 1)");
        executePlainSQL("INSERT INTO Inform(postId, storeId) VALUES (4, 4)");
        executePlainSQL("INSERT INTO Inform(postId, storeId) VALUES (5, 1)");
        executePlainSQL("INSERT INTO Inform(postId, storeId) VALUES (5, 3)");
        executePlainSQL("INSERT INTO Inform(postId, storeId) VALUES (5, 5)");
        executePlainSQL("INSERT INTO Inform(postId, storeId) VALUES (6, 2)");
        executePlainSQL("INSERT INTO Inform(postId, storeId) VALUES (6, 3)");
        executePlainSQL("INSERT INTO Inform(postId, storeId) VALUES (6, 4)");
        executePlainSQL("INSERT INTO Inform(postId, storeId) VALUES (7, 3)");
        executePlainSQL("INSERT INTO Inform(postId, storeId) VALUES (7, 2)");
        executePlainSQL("INSERT INTO Inform(postId, storeId) VALUES (8, 1)");
        executePlainSQL("INSERT INTO Inform(postId, storeId) VALUES (8, 4)");
        executePlainSQL("INSERT INTO Inform(postId, storeId) VALUES (9, 3)");
        executePlainSQL("INSERT INTO Inform(postId, storeId) VALUES (9, 5)");
        executePlainSQL("INSERT INTO Inform(postId, storeId) VALUES (10, 1)");
        executePlainSQL("INSERT INTO Inform(postId, storeId) VALUES (10, 2)");
        
    

        if ($isEmail == false) {
            $status = 'Invalid email form...';
            return;
        }
          
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT Name FROM Users WHERE email = '$email' AND password = '$password'";

        $result = handleRowRequest($sql);

        if (($row = oci_fetch_row($result))) {
   
            if(isset($row[0])) {
               $_SESSION['name'] = $row[0];
               header('location:index.php');
               die();
            }
            else {
                $status = 'invalid user...';
            }       
        }
    }
?>

