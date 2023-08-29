<nav id="sidebar">
    <ul class="list-unstyled">
        <li><a href="/panel/"> <i class="fas fa-home"></i>Home </a></li>
        <li><a href="/panel/licenses/"><i class="fas fa-key"></i>Licenses </a></li>
        <li><a href="/panel/add"><i class="fas fa-plus"></i>Add license</a></li>
        <?php
        if (tokenExist($_COOKIE['USER_TOKEN']) && getID($_COOKIE['USER_TOKEN']) === 'UNX80G') { //check if the user is the initial user
        ?>
            <li><a href="/panel/users"><i class="fas fa-users"></i>Manage Users</a></li>
        <?php
        }
        ?>
    </ul>
</nav>