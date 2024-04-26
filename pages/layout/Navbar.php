<?php

require_once ("Models/Database.php");

$dbContext = new DBContext();
function layout_Navbar($dbContext)
{
    ?>
    <header>
        <nav class="navbar">
            <div class="navbar-menu">
                <h3><a href="/">Innebandyshopen</a></h3>
                <div class="dropdown">
                    <button class="dropdown-btn">Välj kategori</button>
                        <div class="dropdown-content">
                            <a href="/popularproducts" name="popular">Populärt</a>
                        <?php
                        foreach ($dbContext->getAllCategories() as $category) {
                            echo "<li class='dropdown-list'><a href='/productpage?id=$category->id'>$category->category</a></li> ";
                        }
                        ?>
                    </div>
                </div>
                <form action="" method="GET">
                    <label for="search">Sök produkt:</label>
                    <input type="text" name="search" id="search" placeholder="Skriv in sökord..."
                        value="<?php echo isset($_GET['search']) ? urldecode($_GET['search']) : ''; ?>">
                    <input type="submit" value="Sök">
                </form>
            </div>
        </nav>
    </header>
    <?php
}
?>