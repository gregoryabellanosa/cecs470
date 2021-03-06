#!/usr/local/php5/bin/php-cgi
<?php
	$servername = "cecs-db01.coe.csulb.edu";
	$username = "cecs470o11";
	$password = "suxoh4";
	$database = "cecs470sec01og04";
	// Create connection
	$conn = new mysqli($servername, $username, $password, $database);

	$error = mysqli_connect_error();

	//if there is a connection error...
	if ($error != null) {
		$output = "<p>Unable to connect to database<p>" . $error;
	  // Outputs a message and terminates the current script
	  exit($output);
	  }

	  //create the sql statement
	  $sql = "SELECT project_name, project_desc, project_tagline, project_img, project_img_alt FROM project";
	  $result = mysqli_query($conn, $sql);

	  //find out how many rows are in the result set
	  $numrows=mysqli_num_rows($result);

    echo "<div class=\"topbanner\">This website is a student project and not a commercial site.</div>";
?>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Faith Yap</title>
	<link rel="stylesheet" type="text/css" href="css/index-style.css">
	<link rel="stylesheet" type="text/css" href="css/project-style.css">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/nav.css">
	<meta name="viewport" content="width=device-width">
</head>
<body>
	<nav class="topnav" id="nav">
		<a href="index.php"><img alt="Faith Yap" class="logo" src="img/faithyaplogo.png"></a>
		<ul>
			<li><a class="currentpage" href="index.php">Home</a></li>
			<li><a href="projects.php">Projects</a></li>
			<li><a href=""><i class="fa fa-download" aria-hidden="true"></i> Resume</a></li>
			<li><a class="hire" href="contact.php">Hire Me!</a></li>
			<li><a href="javascript:void(0);" class="icon" onclick="hamburgerMenu()" aria-label="Hamburger Menu"><i class="fa fa-bars"></i></a></li>
		</ul>
	</nav>
	<div class="wrapper">
		<div class="row">
			<div class="column-6 column-s-12">
				<img alt="Faith Yap Profile Picture" class="profile-picture" src="img/faithprofile.jpg">
			</div>
			<div class="column-6 column-s-12" id="about-me">
				<h2>Computer Science Graduate &amp; Coding Enthusiast </h2>
				<p>
					I am recent Computer Science gradate from California State University, Long Beach. With the pursuit of my degree, I have developed a progressing appreciation for certain coding languages and pracitces. After continually exposing myself to a varying range of concepts, I find I can apply these skills between different languages. Aside from coding, I enjoy playing video games, watching movies, and being a foodie.
				</p>
				<div class="social-icons">
					<a href="https://www.instagram.com/faithallyson/" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
					<a href="https://github.com/faithyap" aria-label="GitHub"><i class="fab fa-github"></i></a>
					<a href="https://www.linkedin.com/in/faith-yap/"aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
				</div>
			</div>
		</div>
		<div id="skills">
			<div class="row">
				<div class="column-12">
					<div class="column-8">
						<h3>Skills</h3><span class="vl">&nbsp;&nbsp;|&nbsp;&nbsp;</span>Trade practices that I would contribute to the workplace
					</div>
				</div>
			</div>
			<div class="row">
				<div class="column-4 column-s-12">
					<div class="skill-wrapper">
						<div>
							<i class="fas fa-user skill-icon"></i>
						</div>
						<p class="skill-header">Interpersonal Communicator</p>
						<p class="skill-desc">I am confident in my ability to deliver key information to small and large groups.</p>
					</div>
				</div>
				<div class="column-4 column-s-12">
					<div class="skill-wrapper">
						<div>
							<i class="fas fa-comments skill-icon"></i>
						</div>
						<p class="skill-header">Bilingual Speaker</p>
						<p class="skill-desc">I am able to speak conversational Tagalog and English</p>
					</div>
				</div>
				<div class="column-4 column-s-12">
					<div class="skill-wrapper">
						<div>
							<i class="fas fa-mouse-pointer skill-icon"></i>
						</div>
						<p class="skill-header">Tool Adapters</p>
						<p class="skill-desc">I am familiar with various tools of the trade like Netbeans, Visio, Photoshop, and Microsoft Office</p>
					</div>
				</div>
				<div class="column-4 column-s-12">
					<div class="skill-wrapper">
						<div>
							<i class="fas fa-code skill-icon"></i>
						</div>
						<p class="skill-header">Development Language Worker</p>
						<p class="skill-desc">I am proficient with Java and have experience with Python, SQL, HTML, JSF, JPA, and C++</p>
					</div>
				</div>
			</div>
		</div>

		<div id="projects">
			<div class="row">
				<div class="column-12">
					<div class="column-8"><h3>Projects</h3><span class="vl">&nbsp;&nbsp;|&nbsp;&nbsp;</span>School assigned and personal projects I've worked started or completed</div>
				</div>
			</div>
			<div class="row">
				<?php
					//loop through the result set
					if ($result=mysqli_query($conn,$sql))
					{
					// Fetch one and one row
						while ($row=mysqli_fetch_assoc($result))
						{
							echo "<div class=\"column-4 column-s-12\">";
							echo "<div class=\"project-desc\">";
							echo "<img alt=\"" . $row["project_img_alt"] . "\" src=\"img/" . $row["project_img"]."\" class=\"project-image\">";
							echo "<h2><strong>" . $row["project_name"] . "</strong></h2>";
							echo "<p class=\"tagline\">" . $row["project_tagline"] . "</p>";
							echo "<p>" . $row["project_desc"] . "</p>";
							echo "</div>";
							echo "</div>";
						}



					}
				?>

			</div>
			<div class="row">
				<div class="column-12 project-button-link">
					<a href="projects.php">
						<div class="column-offset-6">
							<p class="project-button">View More Projects &nbsp;<i class="fas fa-angle-right"></i></p>
							<br />
						</div>
					</a>
				</div>
			</div>
		</div>
			<div id="jobExp">
				<div class="row">
					<div class="column-12">
						<div class="column-8 column-s-12"><h3>Experience</h3><span class="vl">&nbsp;|&nbsp;&nbsp;</span>My Past Experience with Applying Myself to the Work Force</div>
					</div>
				</div>
				<div class="row">
				<?php
					$sql = "SELECT experience_name, experience_desc, experience_tagline FROM experience";
					$result = mysqli_query($conn, $sql);
					//loop through the result set
					if ($result=mysqli_query($conn,$sql))
					{
					// Fetch one and one row
						while ($row=mysqli_fetch_assoc($result))
						{
							echo "<div class=\"column-12\">";
							echo "<div class=\"job-entry\">";
							echo "<h2>" . $row["experience_name"] . "</h2>";
							echo "<p class=\"tagline\">" . $row["experience_tagline"] . "</p>";
							echo "<p>" . $row["experience_desc"] . "</p>";
							echo "</div>";
							echo "</div>";
						}

	   					// Free result set
	    				mysqli_free_result($result);
						mysqli_close($conn);
					}
				?>				

				<div class="row">
					<div class="column-12"  id="connection">
						<div class="column-6 column-s-12">
							<h3 style="font-size: 1.3em">Make the Connection</h3>
							<p style="font-size: 1.25em">Think I am someone you can work with? Let's work on something meaningful together.</p>
						</div>
						<div class="column-offset-6">
							<a class="hire-connection" href="contact.php">Hire Me!</a>
						</div>
					</div>
				</div>

			</div>
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
            <p><a href="index.php">Home</a> | <a class="currentpage" href="projects.php">Projects</a> | <a href="FaithYap_Resume.pdf" download="FaithYap_Resume.pdf"><i class="fa fa-download" aria-hidden="true"></i> Download Resume</a> | <a href="contact.php">Contact</a> </p>
          </div>
        </footer>
	<script src="js/nav.js"></script>
	<script src="js/project-desc.js"></script>
</body>
</html>
