<?php include "conn.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajax</title>
    <script>
       var ajax = new XMLHttpRequest();

function _1() {
    ajax.onreadystatechange = function() {
        if (ajax.readyState === 4) {
            if (ajax.status === 200) {
                console.dir(ajax.responseText);
                document.getElementById("res").innerHTML = ajax.response;
            }
        }
    }
    var publisher = document.getElementById("publisher").value;
    console.dir(publisher);
    ajax.open("get", "1.php?publisher=" + publisher);
    ajax.send();
}

function _2() {
    ajax.onreadystatechange = function() {
        if (ajax.readyState === 4) {
            if (ajax.status === 200) {

                console.dir(ajax);
                let rows = ajax.responseXML.firstChild.children;
                let result = "Таблица второго запроса: <table border=1> <tr><th>Вид и название</th><th>Автор</th><th>Издательство</th><th>Год выпуска</th></tr>";
                for (var i = 0; i < rows.length; i++) {
                    result += "<tr>";
                    result += "<td>" + rows[i].children[0].firstChild.nodeValue + "</td>";
                    result += "<td>" + rows[i].children[1].firstChild.nodeValue + "</td>";
                    result += "<td>" + rows[i].children[2].firstChild.nodeValue + "</td>";
                    result += "<td>"+ rows[i].children[3].firstChild.nodeValue + "</td>";
                    result += "</tr>";
                }
                result += "</table>";
                document.getElementById("res").innerHTML = result;
            }
        }
    }
    var year_min = document.getElementById("year_min").value;
    var year_max = document.getElementById("year_max").value;
    ajax.open("get", "2.php?year_min=" + year_min + "&year_max=" + year_max);
    ajax.send();
}

function _3() {
    ajax.onreadystatechange = function() {
    let rows = JSON.parse(ajax.responseText);
    console.dir(rows);
    if (ajax.readyState === 4) {
        if (ajax.status === 200) {
            console.dir(ajax);
            let result = "Таблица третьего запроса: <table border=1> <tr><th>Вид и название</th><th>Автор</th><th>Издательство</th><th>Год выпуска</th></tr>";
            for (var i = 0; i < rows.length; i++) {
                result += "<tr>";
                result += "<td>" + rows[i].title + "</td>";
                result += "<td>" + rows[i].name + "</td>";
                result += "<td>" + rows[i].publisher + "</td>";
                result += "<td>"+ rows[i].year + "</td>";
                result += "</tr>";
            }
            result += "</table>";
            document.getElementById("res").innerHTML = result;
            }
        }
    }
    var author = document.getElementById("author").value;
    ajax.open("get", "3.php?author=" + author);
    ajax.send();
} 
    </script>
</head>
<body>
<p>Вариант 0. КИУКИ-19-4, Смирнов Владислав</p>
<p><strong> Информация о книгах издательства: </strong>
        <select name="publisher" id="publisher">
            <?php
            $sql = "SELECT DISTINCT publisher FROM $db.LITERATURE";
            $sql = $dbh->query($sql);
            foreach ($sql as $cell) {
                echo "<option> $cell[0] </option>";
            }
            ?>
        </select>
    <button onclick="_1()">ОК</button>
</p>

<p><strong>Информация о книгах, журналах, газетах, опубликованных за указанный период:</strong>
        <select name="year_min" id="year_min">
            <?php
                $sql = "SELECT DISTINCT year FROM $db.LITERATURE";
                $sql = $dbh->query($sql);
                foreach ($sql as $cell) {
                    if($cell[0] == 0)
                        continue;
                    else
                        echo "<option> $cell[0] </option>";
                }
                $sql = "Select distinct year(date) from $db.LITERATURE";
                $sql = $dbh->query($sql);
                foreach ($sql as $cell) {
                    if($cell[0] == 0)
                        continue;
                    else
                        echo "<option> $cell[0] </option>";
                }
            ?>
        </select>
        <select name="year_max" id="year_max">
        <?php
            $sql = "SELECT DISTINCT year FROM $db.LITERATURE";
            $sql = $dbh->query($sql);
            foreach ($sql as $cell) {
                if($cell[0] == 0)
                    continue;
                else
                    echo "<option> $cell[0] </option>";
            }
            $sql = "Select distinct year(date) from $db.LITERATURE";
            $sql = $dbh->query($sql);
            foreach ($sql as $cell) {
                if($cell[0] == 0)
                    continue;
                else
                    echo "<option> $cell[0] </option>";
            }
            ?>
        </select>
    <button onclick="_2()">ОК</button>
</p>
<p><strong> Вывести информацию о книгах автора: </strong>
        <select name="author" id="author">
            <?php
                $sql = "SELECT DISTINCT name FROM $db.authors";
                $sql = $dbh->query($sql);
                foreach ($sql as $cell) {
                    echo "<option> $cell[0] </option>";
                }
            ?>
        </select>
    <button onclick="_3()">ОК</button>
</p>
<p id="res"></p>
</body>
</html>