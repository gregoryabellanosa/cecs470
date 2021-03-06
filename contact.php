#!/usr/local/php5/bin/php-cgi
<?php
session_start();

// Connection to the database
$servername = "cecs-db01.coe.csulb.edu";
$username = "cecs470o14";
$password = "di7a3a";
$database = "cecs470sec01og04";
$conn = new mysqli($servername, $username, $password, $database);

// Warning if connection does not go through
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind values
$stmt = $conn->prepare("INSERT INTO message (message_contactName, message_email, message_phoneNumber, message_subject, message_type, message_body) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $message_contactName, $message_email, $message_phoneNumber, $message_subject, $message_type, $message_body);

$contactNameErr = $emailErr = $phoneNumberErr = $subjectErr  = $typeErr = $bodyErr = $message_contactName = $message_email = $message_phoneNumber = $message_subject = $message_type = $message_body = "";
 

function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $confirmationMsg = "";
    
    // Validation for contact name
    if (empty($_POST["message_contactName"])) {
        $contactNameErr = "Name is required.";
    } else {
        $message_contactName = test_input($_POST["message_contactName"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $message_contactName)) {
            $contactNameErr = "Only letters and whitespace allowed."; 
            $message_contactName = "";
        }
    }

    // Validation for email
    if (empty($_POST["message_email"])) {
        $emailErr = "Email is required.";
    } else {
        $message_email = test_input($_POST["message_email"]);
        // check if e-mail address is well-formed
        if (!filter_var($message_email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format."; 
            $message_email = "";
        }
    }
    
    // Validation for phone number
    $message_phoneNumber = test_input($_POST["message_phoneNumber"]);
    // check if phone number is 9 digits long if entered
    if (!empty($_POST["message_phoneNumber"])){
        if (!preg_match("/^[0-9]{10}$/", $message_phoneNumber)) {
            $phoneNumberErr = "Phone number must be 10 digits long (including area code)."; 
            $message_phoneNumber = "";
        }
    }

    // Validation for subject
    if (empty($_POST["message_subject"])) {
        $subjectErr = "Subject is required.";
    } else {
        $message_subject = test_input($_POST["message_subject"]);
    }

    // Validation for message type
    if (empty($_POST["message_type"])) {
        $typeErr = "Message type is required.";
    } else {
        $message_type = test_input($_POST["message_type"]);
    }

    // Validation for message
    if (empty($_POST["message_body"])) {
        $bodyErr = "Message is required.";
    } else {
        $message_body = test_input($_POST["message_body"]);
    }
    
    // If required fields are not empty, post values
    if($message_contactName !== "" && $message_email !== "" && message_subject !== "" && $message_type !== "" && message_body !== ""){
        $_SESSION['message_contactName'] = $_POST['message_contactName'];
        $_SESSION['message_email'] = $_POST['message_email'];
        $_SESSION['message_phoneNumber'] = $_POST['message_phoneNumber'];
        $_SESSION['message_subject'] = $_POST['message_subject'];
        $_SESSION['message_type'] = $_POST['message_type'];
        $_SESSION['message_body'] = $_POST['message_body'];
        
        $confirmationMsg = "Your message was sent successfully. Thank you for contacting me.";
        
        // Executes the statement and closes the connection
        $stmt->execute();
        $stmt->close();
        $conn->close();
        
//        header("Location: messages.php");
    }
}

echo "<div class=\"topbanner\">This website is a student project and not a commercial site.</div>";
?>

<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <title>Contact Me | Faith Yap</title>
        <link rel="stylesheet" href="css/project-style.css">
        <link rel="stylesheet" href="css/contact-style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    
    <body>
        
        <nav>
        <a href="index.php"><img class="logo" src="img/faithyaplogo.png" alt="Faith Yap logo"></a>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="projects.php">Projects</a></li>
            <li><a href="FaithYap_Resume.pdf" download="FaithYap_Resume.pdf"><i class="fa fa-download" aria-hidden="true"></i> Resume</a></li>
            <li><a class="hire" href="contact.php">Hire Me!</a></li>
        </ul>
        </nav>
        
        <div class="bluetitlesection">
            <h1>Contact Me</h1>
        </div>
        
        
        <div class="profilephoto">
            <img src="img/faithprofile.jpg" alt="Faith Yap profile picture">
        </div>
        
        <p><strong><?php echo $confirmationMsg;?></strong></p>
        
        <div class="messageform">
            <form method="post" onsubmit="submitForm(event)" action="<?php echo htmlspecialchars ($_SERVER["PHP_SELF"]);?>">
                
                <div class="leftcolumnform">
                    <label for="name">Your Name*</label> <br/>
                    <input type="text" id="name" name="message_contactName"/><br/>
                    <span class="errormsg"><?php echo $contactNameErr;?></span><br/>
                    <br/>

                    <label for="email">Your Email*</label><br/>
                    <input type="text" id="email" name="message_email"/><br/>
                    <span class="errormsg"><?php echo $emailErr;?></span><br/>
                    <br/>
                </div>
                
                <div class="rightcolumnform">
                    <label for="phoneNumber">Your Phone Number </label><br/>
                    <input type="text" id= "phoneNumber" name="message_phoneNumber"/><br/>
                    <span class="errormsg"><?php echo $phoneNumberErr;?></span><br/>
                    <br/>

                    <label for="subject">Subject*</label><br/>
                    <input type="text" id= "subject" name="message_subject"/><br/>
                    <span class="errormsg"><?php echo $subjectErr;?></span><br/>
                    <br/>
                </div>
                
                
                <div class="selectionsrowform">
                    <label for="contactType1" class="choice"><input type="radio" id="contactType1" value="Job Inquiry" name="message_type">Job Inquiry</label>
                    <label for="contactType2" class="choice"><input type="radio" id="contactType2" value="Project Commission" name="message_type">Project Commission</label>
                    <label for="contactType3" class="choice"><input type="radio" id="contactType3" value="Comment" name="message_type">Comment</label>
                    <br/>
                </div>
                <span class="errormsg"><?php echo $typeErr;?></span>
                <br/><br/>
                
                <div class="messagerowform">
                    <br/>
                    <label for="body">Your Message*</label><br/>
                    <textarea rows="5" id="body" name="message_body"></textarea><br/>
                    <span class="errormsg"><?php echo $bodyErr;?></span><br/>
                    <br/>
                </div>
                <br/><br/>
                <input type="submit" class="contactadbutton" value="CONTACT ME"/>
            </form>
        </div>

        <div class="contactad">
            <div class="contactadright">
              <a class="contactadbutton" href="FaithYap_Resume.pdf" download="FaithYap_Resume.pdf">DOWNLOAD</a>
            </div>
            <h3>Download my resume!</h3>
            <p>
                See more about my past work experiences and projects
            </p>
        </div>
        <br/><br/>
        <footer>
            <div class="footerinfo">
                <img class="logo" src="img/faithyaplogoinverted.png" alt="Faith Yap Logo">
                
                <div class="createdby">
                    <h4>Website Created By:</h4>
                    <p><i class="fa fa-male"></i> &nbsp;Gregory Abellanosa [ <a href="mailto:gregoryabellanosa@gmail.com">gregoryabellanosa@gmail.com</a> ]</p>
                    <p><i class="fa fa-female"></i> &nbsp;Caren Briones [ <a href="mailto:carenpbriones@gmail.com">carenpbriones@gmail.com</a> ]</p>
                    <p><i class="fa fa-male"></i> &nbsp;Marco Tran [ <a href="mailto:mtran0132@gmail.com">mtran0132@gmail.com</a> ]</p>
                    <hr>
              <?php echo "<p>Last modified: " . date ("F d Y H:i:s.", getlastmod()) . "</p>"; ?>
                </div>
                
                <p><a href="index.php">Home</a> | <a class="currentpage" href="projects.php">Projects</a> | <a href="FaithYap_Resume.pdf" download="FaithYap_Resume.pdf"><i class="fa fa-download" aria-hidden="true"></i> Download Resume</a> | <a href="contact.php">Contact</a> | <a href="messages.php">Messages</a> </p>
            </div>
        </footer>
    </body>
</html>
