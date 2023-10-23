<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl3.css">
    <title>Twoje BMI</title>
</head>
<body>
    <div class="logo">
        <img src="wzor.png" alt="wzór BMI">
    </div>
    <div class="baner">
        <h1>Oblicz swoje BMI</h1>
    </div>
    <div class="main">
        <table>
            <tr>
                <th>Interpretacja BMI</th>
                <th>Wartość minimalna</th>
                <th>Wartość maksymalna</th>
            </tr>
            <!-- SCRIPT -->
            <?php 
                $conn = mysqli_connect("localhost","root","","bmi");//Łączenie z bazą danych
                $zapytanie = "SELECT informacja,wart_min,wart_max FROM bmi";//zapytanie
                $res = mysqli_query($conn, $zapytanie);
                while ($wynik = mysqli_fetch_row($res)) { //Skrypt wypisuje informacje w tabeli
                    echo 
                    "<tr>
                        <td>$wynik[0]</td>
                        <td>$wynik[1]</td>
                        <td>$wynik[2]</td>
                    </tr>";
                }
                mysqli_close($conn);//Zakończenie łączenia z bazą danych
            ?>
        </table>
    </div>
    <div class="left">
        <h2>Podaj wagę i wzrost</h2>
        <form action="" method="POST">
        <label for="waga">Waga:</label><input type="number" name="waga" id="waga"><br>
        <label>Wzrost w cm:<input type="number" name="wzrost" id="wzrost"></label>
        <button name="submit" id="submit">Oblicz i zapmiętaj wynik</button>
        </form>
        <!-- SCRIPT2 -->
        <?php 
            $conn = mysqli_connect("localhost","root","","bmi");
           
            if (isset($_POST['submit'])) { //Po naciśnięciu przycisku skrypt wykonuje się 
                $waga = $_POST["waga"];
                $wzrost = $_POST["wzrost"];
                $bmi = $waga / ($wzrost*$wzrost)*10000; //Wzór na BMI
                $bmi = number_format($bmi, 2, ",", "");//Zaokrąglanie do 2 miejsc po przecinku
                if ( //Sprawdza czy pola zostały wypełnione
                    !empty($_POST['waga']) ||
                    !empty($_POST['wzrost'])
                ) {
                    echo "Twoja waga:$waga; Twój wzrost:$wzrost<br>";
                    echo "BMI wynosi:$bmi";

            } else {
                echo "<p>Wypełnij wszystkie pola</p>";
                die;
            }
            if ($bmi <= 18) $bmi_id = 1;
            if ($bmi > 19 && $bmi < 25) $bmi_id = 2;
            if ($bmi > 26 && $bmi < 30) $bmi_id = 3;
            if ($bmi > 31 && $bmi < 100) $bmi_id = 4;
            $date = date("Y-m-d");//Zmienna z aktualną datą
            $zapytanie3 = "INSERT INTO wynik (id,bmi_id,data_pomiaru,wynik) VALUES (null,'$bmi_id','$date','$bmi');";
            $res2 = mysqli_query($conn, $zapytanie3);
        }
        ?>
    </div>
    <div class="right">
        <img src="rys1.png" alt="ćwiczenia">
    </div>
    <div class="footer">
        <p>Autor Paweł Lewandowski</p>
        <a href="kwerendy.txt">Zobacz kwerendy</a>
    </div>
</body>
</html>