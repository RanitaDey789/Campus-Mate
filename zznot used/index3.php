<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Website Homepage</title>
</head>
<body>
    <nav><div class="navA">
            <div class="alg">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li class="dropdown">
                        <a href="#">Login</a>
                        <div class="dropdown-content">
                            <a href="#">Super Admin</a>
                            <a href="#">HOD</a>
                            <a href="#">Teacher</a>
                            <p><a href="script/students/s_signup.php">Student</a></p>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a href="#">About Us</a>
                        <div class="dropdown-content">
                            <a href="#">Mission</a>
                            <a href="#">Vision</a>
                            <a href="#">Values</a>
                        </div>
                    </li>
                </ul>
            </div>
                <div class="logo" ><img src="photos/logo-removebg-preview (1).png" alt=""></div>
            </div>
    </nav>
    <div class="burger">
        <div class="burger-line"></div>
        <div class="burger-line"></div>
        <div class="burger-line"></div>
    </div>
    <header>
        <!-- Header section with photos -->
        <div class="header-photos">
            <!-- Add your photos here -->
            <img src="photos/ciet3.jpg" alt="">
        </div>
    </header>

    <main>
        <!-- Main section with four divs -->
        <div class="section">
            <div class="super-admin">Super Admin</div>
            <div class="hod">HOD</div>
            <div class="teacher">Teacher</div> 
            <div class="student">Student</div>
        </div>
        <!--Main section for photos-->
        <section class="photo-section">
            <div class="photo-container"><img src="photos/clgimg1 (1).jpg" alt="Photo 1"></div>
            <div class="photo-container"><img src="photos/clgimg1 (2).jpg" alt="Photo 2"></div>
            <div class="photo-container"><img src="photos/clgimg1 (3).jpg" alt="Photo 3"></div>
            <div class="photo-container"><img src="photos/ciet4.webp" alt="Photo 5"></div>
        </section>
    </main>

    <footer>
        <!-- Footer section with contact details -->
        <div class="contact-details">
            <h5><p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sit excepturi facilis alias quasi recusandae veniam aspernatur aperiam illo, laboriosam temporibus aliquam vel cupiditate amet fugiat magni! Asperiores quas nobis aut.</p></h5>
            <!-- Add your contact details here -->
        </div>
    </footer>
</body>
</html>
