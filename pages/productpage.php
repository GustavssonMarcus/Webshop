<?php
require_once ("Pages/layout/Navbar.php");
require_once ("Pages/layout/Header.php");
require_once ("Models/Database.php");

$id = $_GET['id'] ?? "";
$dbContext = new DBContext();

$category = $dbContext->getCategoryById($id); // Hämta kategorin baserat på den valda kategori-ID:n
$products = $dbContext->getProductsByCategoryId($id); // Hämta alla produkter inom den valda kategorin

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
            <h2>
                <?php echo $category['category']; ?>
            </h2> <!-- Visa kategorinamnet -->
            <ul>
                <?php foreach ($products as $product): ?>
                    <li class='products-info'>
                        <?php echo $product['brandname']; ?>
                    </li> <!-- Visa produktnamn -->
                <?php endforeach; ?>
            </ul>
        </div>
    </Section>
</Main>