<?php
function layout_sidenav($dbContext)
{
    ?>
    <header>
        <nav class="navbar">
            <div class="navbar-menu">
                <h3>Innebandyshopen</h3>
                <div>
                    <ul>
                        <li class="dropdown">
                            <a class="dropbtn">Kategorier</a>
                            <div class="dropdown-content">
                                <a href="#">Populära produkter</a>
                                <a href="#">Salming</a>
                                <a href="#">Unihoc</a>
                                <a href="#">Fatpipe</a>
                                <a href="#">Oxdog</a>
                                <a href="#">Jolly</a>
                                <a href="#">Exel</a>
                                <a href="#">Zone</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
<?php
}
?>