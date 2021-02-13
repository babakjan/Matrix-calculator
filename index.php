<?php

$C = []; //matrix C

//when user press calculate
if (isset($_GET['submit'])) {

    $isSetA = isset($_GET['A00']) &&
        isset($_GET['A01']) &&
        isset($_GET['A02']) &&
        isset($_GET['A10']) &&
        isset($_GET['A11']) &&
        isset($_GET['A12']) &&
        isset($_GET['A20']) &&
        isset($_GET['A21']) &&
        isset($_GET['A22']);

    $isSetB = isset($_GET['A00']) &&
        isset($_GET['B01']) &&
        isset($_GET['B02']) &&
        isset($_GET['B10']) &&
        isset($_GET['B11']) &&
        isset($_GET['B12']) &&
        isset($_GET['B20']) &&
        isset($_GET['B21']) &&
        isset($_GET['B22']);

    if (isset($_GET['operator']) && $isSetA && $isSetB) {
        switch ($_GET['operator']) {
            case "+":
                $C = addition();
                break;
            case "-":
                $C = subtraction();
                break;
            case "*":
                $C = multiplication();
        }
    }
}

//return A + B
function addition()
{
    $result = [[], [], []];

    for ($i = 0; $i < 3; $i++)
        for ($j = 0; $j < 3; $j++)
            $result[$i][$j] = $_GET["A" . $i . $j] + $_GET["B" . $i . $j];

    return $result;
}

//return A - B
function subtraction()
{
    $result = [[], [], []];

    for ($i = 0; $i < 3; $i++)
        for ($j = 0; $j < 3; $j++)
            $result[$i][$j] = $_GET["A" . $i . $j] - $_GET["B" . $i . $j];

    return $result;
}

//return C[i][j], where C =  A * B
function multiplicationSum($i, $j) {
    $sum = 0;
    for ($k = 0; $k < 3; $k++)
        $sum += $_GET["A" . $i . $k] * $_GET["B" . $k . $j];

    return $sum;
}

//return A * B
function multiplication()
{
    $result = [[], [], []];

    for ($i = 0; $i < 3; $i++)
        for ($j = 0; $j < 3; $j++)
            $result[$i][$j] = multiplicationSum($i, $j);

    return $result;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrix Calculator</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<form>
    <!--matrices section-->
    <section class="matrices">
        <!--matrix A-->
        <div class="matrix">
            <div class="matrixLabel">A =</div>
            <div class="parentheses">(</div>
            <div class="values">
                <!--generate input fields of matrix A-->
                <?php
                for ($i = 0; $i < 3; $i++) {
                    for ($j = 0; $j < 3; $j++) {
                        echo "<input type=\"text\" name=\"A" . $i . $j . "\" value=\"";
                        echo (!isset($_GET["A" . $i . $j])) ? "0" : $_GET["A" . $i . $j];
                        echo "\">";
                    }
                    echo "<br>";
                }
                ?>
            </div>
            <div class="parentheses">)</div>
        </div>

        <!--operator select-->
        <select name="operator">
            <!--keep data in select form-->
            <?php
                if (isset($_GET["operator"])) {
                    if ($_GET["operator"] === "+") {
                        echo "<option value=\"+\" selected>+</option>";
                        echo "<option value=\"-\">-</option>";
                        echo "<option value=\"*\">*</option>";
                    } elseif ($_GET["operator"] === "-") {
                        echo "<option value=\"+\">+</option>";
                        echo "<option value=\"-\" selected>-</option>";
                        echo "<option value=\"*\">*</option>";
                    } else {
                        echo "<option value=\"+\">+</option>";
                        echo "<option value=\"-\">-</option>";
                        echo "<option value=\"*\" selected>*</option>";
                    }
                } else {
                    echo "<option value=\"+\" selected>+</option>";
                    echo "<option value=\"-\">-</option>";
                    echo "<option value=\"*\">*</option>";
                }
            ?>
        </select>

        <!--matrix B-->
        <div class="matrix">
            <div class="matrixLabel">B =</div>
            <div class="parentheses">(</div>
            <div class="values">
                <!--generate input fields of matrix B-->
                <?php
                for ($i = 0; $i < 3; $i++) {
                    for ($j = 0; $j < 3; $j++) {
                        echo "<input type=\"text\" name=\"B" . $i . $j . "\" value=\"";
                        echo (!isset($_GET["B" . $i . $j])) ? "0" : $_GET["B" . $i . $j];
                        echo "\">";
                    }
                    echo "<br>";
                }
                ?>
            </div>
            <div class="parentheses">)</div>
        </div>

        <div class="matrixLabel">=</div>

        <!--matrix C-->
        <div class="matrix">
            <div class="matrixLabel">C =</div>
            <div class="parentheses">(</div>
            <div class="values">
                <!-- generate matrix C-->
                <?php
                for ($i = 0; $i < 3; $i++) {
                    for ($j = 0; $j < 3; $j++) {
                        echo "<input type=\"text\" readonly value=\"";
                        echo ($C !== []) ? $C[$i][$j] : "0";
                        echo "\">";
                    }
                    echo "<br>";
                }
                ?>
            </div>
            <div class="parentheses">)</div>
        </div>
    </section>
    <br>

    <button class="submit" type="submit" name="submit" value="submit">Calculate</button>
</form>

</body>
</html>
