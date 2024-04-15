<?php
require_once ("Pages/layout/Navbar.php");
require_once ("Pages/layout/Header.php");
require_once ("models/Database.php");
$dbContext = new DBContext();

$sort_column = isset ($_GET['sort_column']) ? $_GET['sort_column'] : 'brand';
$sort_order = isset ($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';

layout_header("Stefans Bank");
?>
<!------------------sidenav-------------->
<?php
layout_Navbar($dbContext);
?>
<Main>
    <Section class="main">
        <div class="main-content">
            <h1>Innebandy Produkter</h1>
        </div>
    </Section>
    <section>
        <form action="" method="get">
            <label for="sort_column">Sortera efter:</label>
            <select name="sort_column" id="sort_column">
                <option value="brand">Märke</option>
                <option value="price">Pris</option>
            </select>
            <label for="sort_order">Ordning:</label>
            <select name="sort_order" id="sort_order">
                <option value="ASC">Stigande</option>
                <option value="DESC">Fallande</option>
            </select>
            <input type="submit" value="Sortera">
        </form>
        <div class="products">
            <?php
            if (isset ($_GET['search'])) {
                $search_term = $_GET['search'];
                // Hämta produkter från databasen som matchar söktermen
                $products = $dbContext->searchProducts($search_term);
            } else {
                // Hantera användarens val för sorteringskolumn och ordning
                $sort_column = isset ($_GET['sort_column']) ? $_GET['sort_column'] : 'brand'; // standard sortering efter märke
                $sort_order = isset ($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC'; // standard ordning i stigande ordning
            
                // Hämta produkter från databasen med dynamisk sortering om sorteringsalternativ har valts, annars hämta alla produkter
                $products = $dbContext->getAllProductsSorted($sort_column, $sort_order);
            }

            foreach ($products as $product) {
                echo "<div class='products-info'> <p>Produkt: $product->brand $product->brandname</p>  <p>Färg: $product->color</p><p> Pris: $product->price kr</p>  <p><a href='/product?id=$product->id'>Läs mer</a></p></div>";
            }
            ?>
        </div>
    </section>
</Main>