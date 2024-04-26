<?php
require_once ("Pages/layout/Navbar.php");
require_once ("Pages/layout/Header.php");
require_once ("Models/Database.php");

$id = $_GET['id'] ?? "";
$dbContext = new DBContext();

$category = $dbContext->getCategoryById($id);


if (isset($_GET['sort_column']) && isset($_GET['sort_order'])) {
    $sortCol = $_GET['sort_column'];
    $sortOrder = $_GET['sort_order'];
    
    $products = $dbContext->getSortedProductsByCategoryId($id, $sortCol, $sortOrder);
} else {

    $products = $dbContext->getProductsByCategoryId($id);
}


layout_header("Marcus Shop");
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
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="sort_column" value="<?php echo $sortCol; ?>">
            <input type="hidden" name="sort_order" value="<?php echo $sortOrder; ?>">
            <label for="sort_column">Sortera efter:</label>
            <select name="sort_column" id="sort_column">
                <option value="brand" >Namn</option>
                <option value="price" >Pris</option>
            </select>
            <label for="sort_order">Sortera ordning:</label>
            <select name="sort_order" id="sort_order">
                <option value="ASC" >Stigande</option>
                <option value="DESC" >Fallande</option>
            </select>
            <input type="submit" value="Sortera">
        </form>
            <div class="products">  
                    <?php foreach ($products as $product): ?>
                        <div class='products-info'>
                            <h3>
                                <?php echo $category['category']; ?>
                            </h3>
                            <p>Produkt: <?php echo $product['brandname']; ?></p>
                            <p>Pris: <?php echo $product['price']; ?> Kr</p>
                            <p>Färg: <?php echo $product['color']; ?></p>
                        </div>
                    <?php endforeach; ?>
            </div>
        </section>
</Main>