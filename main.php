<?php

$student_database="database.txt";
if(isset($_POST['submit']))
{
  $name = $_POST['name'];
  $regNo = $_POST['regNo'];
  $grade = $_POST['grade'];
  $class = $_POST['class'];
}

echo "My name is $name, I am a $class student at Jagaad Academy.\nMy registration no. is $regNo; My grade is $grade";
