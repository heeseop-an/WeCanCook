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
        // OCICommit($db_conn);
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

        debugAlertMessage($statement);
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
        $db_conn = OCILogon("ora_dim01", "a20780946", "dbhost.students.cs.ubc.ca:1522/stu");
    
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

    function deleteCommentRequest($sql) {
        global $db_conn;
        debugAlertMessage($sql);
        // you need the wrap the old name and new name values with single quotations
        $result = executePlainSQL($sql);
        if($result) {
            OCICommit($db_conn);
        }
    }

    function updateCommentRequest($sql) {
        global $db_conn;


        // you need the wrap the old name and new name values with single quotations
        $result = executePlainSQL($sql);
        if($result) {

        }
        OCICommit($db_conn);
    }

    function insertCommentRequest($sql) {
        global $db_conn;

        // you need the wrap the old name and new name values with single quotations
        $result = executePlainSQL($sql);
        if($result) {

        }
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

        if ($isEmail == false) {
            $status = 'Invalid email form...';
            return;
        }
          
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM Users WHERE email = '$email' AND password = '$password'";

        $result = handleRowRequest($sql);

        if (($row = oci_fetch_row($result))) {
   
            if(isset($row[0])) {
               $_SESSION['id'] = $row[0];
               $_SESSION['name'] = $row[1];
               
               header('location:index.php');
               die();
            }
            else {
                $status = 'invalid user...';
            }       
        }
    }
?>

