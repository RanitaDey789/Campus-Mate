<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav>
        <div class="logo">
            <img src="photos/logo-removebg-preview (1).png" alt="Logo">
        </div>
        <ul class="nav-links">
            <li class="dropdown">
                <a href="#">Home</a>
            </li>
            <li class="dropdown">
                <a href="#">Login</a>
                <div class="dropdown-content">
                    <a href="script/admin/a_login.php">Admin</a>
                    <a href="script/faculty/f_login.php">Faculty</a>
                    <a href="script/students/s_login.php">Student</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="#">About Us</a>
                <div class="dropdown-content">
                    <a href="#">Sublink 1</a>
                    <a href="#">Sublink 2</a>
                    <a href="#">Sublink 3</a>
                </div>
            </li>
        </ul>
    </nav>
    <header>
        <div class="container">
            <h1>Welcome to <br><br> Camellia Institute of Engneering and Technology</h1>
        </div>
    </header>

    <section id="features">
        <div class="container">
            <h2>Features</h2>
            <div class="slider">
                <div class="slide">
                    <img src="photos/clgimg1 (1).jpg" alt="Feature 1">
                    <h3>World Literacy Day</h3>
                    <p>World Literacy Day Awareness program of NSS activity</p>
                </div>
                <div class="slide">
                    <img src="photos/clgimg1 (2).jpg" alt="Feature 2">
                    <h3>Teachers Day</h3>
                    <p>Welcome ceremony of Teachers day</p>
                </div>
                <div class="slide">
                    <img src="photos/clgimg1 (3).jpg" alt="Feature 3">
                    <h3>Teachers Day</h3>
                    <p>Teachers Day speech </p>
                </div>
                <div class="slide">
                    <img src="photos/fest1.jpg" alt="Feature 4">
                    <h3>Menestize</h3>
                    <p>Fest 2024</p>
                </div>
                <div class="slide">
                    <img src="photos/wall_magazine2k23.jpg" alt="Feature 5">
                    <h3>Wall Magazine</h3>
                    <p>Departmental Wall Magazine</p>
                </div>
                <div class="slide">
                    <img src="photos/industry_visit.jpg" alt="Feature 5">
                    <h3>Industy Visit</h3>
                    <p>Industry Visit 2k23</p>
                </div>
                <div class="slide">
                    <img src="photos/fest2.jpg" alt="Feature 5">
                    <h3>Fest</h3>
                    <p>Musically rocking with Darikoma</p>
                </div>
                <div class="slide">
                    <img src="photos/fest3.jpg" alt="Feature 5">
                    <h3>Fest</h3>
                    <p>Morphine India rocking the stage</p>
                </div>
                <div class="slide">
                    <img src="photos/farewell2k224.jpg" alt="Feature 5">
                    <h3>Farewell</h3>
                    <p>We keep the memories in photograph</p>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; Camellia Institute of Engneering and Technology</p> <br>
            <p>Contact Us : +91-9007030144</p>
        </div>
    </footer>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
    let slideIndex = 0;
    showSlides();

    function showSlides() {
        let slides = document.getElementsByClassName("slide");
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slideIndex++;
        if (slideIndex > slides.length) {
            slideIndex = 1;
        }
        slides[slideIndex - 1].style.display = "block";
        setTimeout(showSlides, 3000); // Change slide every 3 seconds
    }
});
    </script>
</body>
</html>
