<?php
    if(isset($_GET['publisher'])){
        include "conn.php";
        $publisher = $_GET['publisher'];
        $literate = "Book";
        $sqlSelect = $dbh->prepare(
            "SELECT * FROM $db.LITERATURE 
            JOIN $db.BOOK_AUTHORS 
            on $db.LITERATURE.ID_BOOK = $db.BOOK_AUTHORS.FID_BOOK
            JOIN $db.AUTHORS 
            on $db.BOOK_AUTHORS.FID_AUTHORS = $db.AUTHORS.ID_AUTHORS
            where $db.LITERATURE.LITERATE = :literate and $db.LITERATURE.publisher = :publisher"
        );
        $sqlSelect->execute(array('literate' => $literate, 'publisher' => $publisher));
        echo "Таблица перовго запроса: <table border=1> <tr><th>Книга</th><th>Автор</th><th>Издательство</th><th>Год выпуска</th></tr>";
        while ($cell = $sqlSelect->fetch(PDO::FETCH_BOTH)) {
            echo "<tr><td>$cell[1]</td><td>$cell[13]</td><td>$publisher</td><td>$cell[5]</td></tr>";
        }
        echo "</table>";
        }   
    ?>