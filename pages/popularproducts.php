<?php
require_once ("Pages/layout/Navbar.php");
require_once ("Pages/layout/Header.php");
require_once ("Models/Database.php");


$dbContext = new DBContext();

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
    <div class="products">
        <?php
        foreach ($dbContext->getPopularProducts() as $product) {
            echo "<div class='products-info'> <p>Klubba: $product->brand $product->brandname</p><p> Pris: $product->price kr</p><p><a href='/product?id=$product->id'>Läs mer</a></p></div>";
        }
        ?>
    </div>
</Main>