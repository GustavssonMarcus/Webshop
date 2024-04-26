<?php
require_once ("Pages/layout/Navbar.php");
require_once ("Pages/layout/Header.php");
require_once ("models/Database.php");
$dbContext = new DBContext();

$sortOrder = $_GET['sortOrder'] ?? "";
$sortCol = $_GET['sortCol'] ?? "";

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
        <form action="" method="GET">
            <label for="sort_column">Sortera efter:</label>
            <select name="sort_column" id="sort_column">
                <option value="brand">Namn</option>
                <option value="price">Pris</option>
            </select>
            <label for="sort_order">Sortera ordning:</label>
            <select name="sort_order" id="sort_order">
                <option value="ASC">Stigande</option>
                <option value="DESC">Fallande</option>
            </select>
            <input type="hidden" name="search"
                value="<?php echo isset($_GET['search']) ? urlencode($_GET['search']) : ''; ?>">
            <input type="submit" value="Sortera">
        </form>
        <div class="products">
            <?php
            if (isset($_GET['search'])) {
                $search_term = urldecode($_GET['search']);
                $sort_column = isset($_GET['sort_column']) ? $_GET['sort_column'] : 'brand';
                $sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';
                $products = $dbContext->searchProducts($search_term, $sort_column, $sort_order);
            } else {
                $sort_column = isset($_GET['sort_column']) ? $_GET['sort_column'] : 'brand';
                $sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';
                $products = $dbContext->getAllProductsSorted($sort_column, $sort_order);
            }

            foreach ($products as $product) {
                echo "<div class='products-info'> <h3>Produkt: $product->brand $product->brandname</h3>  <p>Färg: $product->color</p><p> Pris: $product->price kr</p>  <p><a href='/product?id=$product->id'>Läs mer</a></p></div>";
            }
            ?>
        </div>
    </section>

</Main>