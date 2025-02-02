<?php
//what is a session
// used to manage info accross different pages
// berify user login info
session_start();
echo "welcome " . $_SESSION['username'];
echo "your faviorite category is ". $_SESSION['fav_cat'];
?>