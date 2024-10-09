<!DOCTYPE html>
<html dir="rtl">

<head>
    <meta charset="utf-8">
    <title>Bakhsh aval</title>
</head>

<body>
    <center>
   <?php include "index1.php";
   

   ?>
        <table border="1" style="width: 800px;">
            <thead style="background-color: burlywood; width: 200px; height: 100px;">
                <tr>
                    <th>ورودی</th>
                    <th>خروجی</th>
                </tr>
            </thead>
            <tbody style="background-color: aqua;">
                <tr>
                    <th>
                        <form method="post" action="">
                            <br>
                            <label for="Name">نام و نام خانوادگی : </label>
                            <input type="text" name="Name" id="Name" >
                            <br><br>
                            <label for="Age">سن شما   : </label>
                            <input type="text" name="Age"  id="Age" >
                            <br><br>
                            <input type="submit" name="submit" value="ارسال">
                        </form>
                    </th>
                    <th>
                        <?php
                       if (isset($_POST['submit'])) {
                        $name = $_POST['Name'];
                        $age = $_POST['Age'];
                        define("GENDER", "زن");
                    
                        $numbers = generateNumbersTable($age, GENDER);
                        $message = generateWelcomeMessage(GENDER, $age);
                    
                        echo "<table  border='1'  >";
                        echo "<tr><th>ردیف</th><th>عدد زوج</th><th>چک باکس</th></tr>";
                        echo $numbers;
                        echo "</table>";
                    
                        echo "خوش آمدید، $name <br>";
                        echo $message;
                    }
                    function generateNumbersTable($age, $gender) {
                        $numbers = '';
                        $minNumber = 0;
                    
                        if ($gender == "مرد") {
                            if ($age % 2) {
                                for ($i = $age + 3; $i <= $age * 2; $i += 2) {
                                    $numbers .= "<tr><td>" . (int)(($i - $age) / 2) . "</td><td>$i</td><td><input type='checkbox' checked name='check" . (($i - $age) / 2) . "'></td></tr>";
                                }
                            } else {
                                for ($i = $age + 2; $i <= $age * 2; $i += 2) {
                                    $numbers .= "<tr><td>" . (($i - $age) / 2) . "</td><td>$i</td><td><input type='checkbox' checked name='check" . (($i - $age) / 2) . "'></td></tr>";
                                }
                            }
                        } else {
                            if ($age % 2) {
                                for ($i = $age + 2; $i <= $age * 2; $i += 2) {
                                    $numbers .= "<tr><td>" . (($i - $age) / 2) . "</td><td>$i</td><td><input type='checkbox' checked name='check" . (($i - $age) / 2) . "'></td></tr>";
                                }
                            } else {
                                for ($i = $age + 1; $i <= $age * 2; $i += 2) {
                                    $numbers .= "<tr><td>" . (int)(($i - $age) / 2 + 1) . "</td><td>$i</td><td><input type='checkbox' checked name='check" . (($i - $age) / 2 + 1) . "'></td></tr>";
                                }
                            }
                        }
                    
                        return $numbers;
                    }
                    
                    function generateWelcomeMessage($gender, $minNumber) {
                        if($gender=="مرد"){
                                if ($minNumber % 2) {
                                   $minNumber+=3;
                                      $message = "جنسیت: $gender <br> کوچکترین عدد تولید شده: $minNumber";
                                 }else{
                                 $minNumber+=2;
                                  $message = "جنسیت: $gender <br> کوچکترین عدد تولید شده: $minNumber";
                                   }
                        }else{
                            if ($minNumber % 2) {
                                $minNumber+=2;
                                   $message = "جنسیت: $gender <br> کوچکترین عدد تولید شده: $minNumber";
                              }else{
                              $minNumber+=1;
                               $message = "جنسیت: $gender <br> کوچکترین عدد تولید شده: $minNumber";
                                }
                        }
                       

                       
                        return $message;
                    }
                   

                        ?>
                    </th>
                </tr>
            </tbody>
        </table>
    </center>
</body>

</html>
