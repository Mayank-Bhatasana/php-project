<?php
    if(isset($_POST["submit"]))
    {
        $name = $_POST["name"];
        $roll = $_POST["roll"];
        $pass = $_POST["pass"];

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "student";

        $con = mysqli_connect($servername, $username, $password, $dbname);
        if($con)
        {
            $query = "INSERT INTO stu(rollno,stuname,stupass) VALUES($roll,'$name','$pass')";
            $result = mysqli_query($con, $query);
            if($result)
            {
                echo "<script>
                    alert('Student info has been added')
                    window.location.href='index.html'
                </script>";
            }
            else{
                echo "not done";
            }
        }
    }
?>