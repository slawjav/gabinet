<?php
//session_start();
//require_once('database.php');
require_once('class/Visit.php');

$id_wizyty = $_POST['id'];
$visit = $Visit->getVisitId($id_wizyty);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rozliczenie wizyty</title>
    <!--<script type="text/javascript">document.write('Pacjent rozliczony');</script>-->
</head>
<body>
    <?php
            // pacjent rozliczony
        $rozl = $Visit->getSettlement($id_wizyty);
        if($rozl[0]['suma']>0) {
            echo "Pacjent rozliczony"."<br>";
            $dzien=substr($visit[0]['start'],0,10);
            echo "<a href='day.php?date={$dzien}'>Powrót</a> ";
            //exit();
        }
    ?>
    <form method="post" action="">
        <input type="hidden" name="id" value=" <?php echo $id_wizyty; ?>" />
        <p><?="Rozliczenie dla: ".$visit[0]['nazwisko']." ".$visit[0]['imie']?><p>
        <p>Rodzaj usługi</p>
        Leczenie <input type="number" name="treatment"><br>
        <p>W tym:</p>
        Sedacja <input type="number" name="sedation"><br>
        Technik <input type="number" name="technician"><br>
        Towar <input type="number" name="article"><br>
        Medycyna estetyczna <input type="number" name="botox"><br><br>
        Ortodoncja <input type="number" name="orto"><br><br>
        Pacjent prywatny <input type="checkbox" value="Pacjent prywatny" name="private"><br><br>
        <!-- automatyczne podsumowanie wartości -->
        <p>Sposób płatności</p>
        Gotówka <input type="number" name="cash"><br>
        Karta <input type="number" name="card"><br>
        Przelew <input type="number" name="transfer"><br>
        Kredyt <input type="number" name="credit"><br>
        <!-- automatyczne podsumowanie wartości -->
        <!-- sprawdzenie czy sumy się zgadzają -->
        <input type="submit" name="add" value="Zapisz">
        <span id="alert" style="color:red"></span><br>
    <form>
    <?php
        if(!empty($_POST['private'])) $priv=1;
        if(isset($_POST['add'])) {
            $Visit->setSettl(
                $_POST['treatment'],
                $_POST['sedation'],
                $_POST['technician'], 
                $_POST['article'],
                $_POST['botox'],
                $_POST['orto'],
                $_POST['cash'],
                $_POST['card'],
                $_POST['transfer'],
                $_POST['credit'],
                $priv,
                $_POST['id']
            );
            header("Location: /przychodnia/day.php?date=".substr($visit[0]['start'],0,10));
        }
    ?>
    <script>
        //document.getElementById("alert").innerHTML="BłądTestowy";
        const form = document.querySelector('form');
        const inputTreatment = Number(form.querySelector('input[name=treatment]').value);
        const inputCash = parseFloat(form.querySelector('input[name=cash]').value);
        const inputCard = parseFloat(form.querySelector('input[name=card]').value);
        const inputTransfer = parseFloat(form.querySelector('input[name=transfer]').value);
        const inputCredit = parseFloat(form.querySelector('input[name=credit]').value);
        const suma = inputCash + inputCard + inputTransfer + inputCredit;
        form.addEventListener("submit", function(e){
            //e.preventDefault();
        //WALIDACJE
            alert(typeof inputTreatment +" "+inputTreatment  );
            alert(Number(form.querySelector('input[name=treatment]').value));
            if(inputTreatment == (inputCash+inputCard+inputTransfer+inputCredit)) {
                e.target.submit();    
            } else {            
                e.preventDefault();
                document.getElementById("alert").innerHTML=" Błąd";
            }
        })
    </script>
</body>
</html>

<!--const form = document.querySelector('form');
form.addEventListener('submit', function(e){
    e.preventDefault();

    //WALIDACJE

    e.target.submit();
})-->