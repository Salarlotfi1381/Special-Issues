<!DOCTYPE html>
<html dir="rtl">

<head>
    <meta charset="utf-8">
    <title>Bakhsh aval</title>
</head>

<body>
 <?php
   function Welcom($name){

    $message = "خوش آمدید، $name <br>";
    return $message;
}
$name="parnia";
$message = Welcom($name);
echo $message;
 ?>
    <center>
  
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
                            <input type="text" name="text1" value="پارامتر ورودی">
                            <br><br>
                            <input type="submit" name="submit1" value="ارسال">
                        </form>
                    </th>
                    <th >
                    <?php
                    
                            if (isset($_POST['submit1'])) {
                                $input_parameter = $_POST['text1'];
                                $output = createMessage($input_parameter);
                                echo $output;
                            }

                            function createMessage($message) {
                                $date = date(" Y-M-d  D");
                                $time = date("h:i a");
                                $output = "<textarea rows='4' cols='50'>";
                                $output .= "پارامتر ورودی: " . $message . "\n";
                                $output .= "Date: " . $date . "\n";
                                $output .= "Time: " . $time;
                                $output .= "</textarea>";
                                return $output;
                            }
                            ?>

                    </th>
                </tr>
            </tbody>
        </table>
        
    </center>
    
</body>

</html>
