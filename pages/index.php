<?php
require_once ("Pages/layout/Navbar.php");
require_once ("Pages/layout/Header.php");
require_once ("models/Database.php");
$dbContext = new DBContext();

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
        <div class="products">
            <?php
            foreach ($dbContext->getAllProducts() as $product) {
                echo "<div class='products-info'> <p>Produkt: $product->brand $product->brandname</p>  <p>Färg: $product->color</p><p> Pris: $product->price kr</p>  <p><a href='/product?id=$product->id'>Läs mer</a></p></div>";
            }
            ?>
        </div>
    </section>
</Main>