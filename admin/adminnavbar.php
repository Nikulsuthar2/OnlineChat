<nav class="navbar">
    <div class="nav-menus">
        <label class="applogo">
            ChatApp Admin
        </label>
        <div class="nav-action">
            <a href="adminhome.php">Dashboard</a>
            <a href="userlist.php">Users</a>
            <a href="userchatreport.php">Chat Report</a>
        </div>
    </div>
    <div>
        <label style="font-weight: bold;margin-right:20px;">
        <?php echo $data["name"]?></label>
        <a class="adminbtn" href="logout.php">Logout</a>
    </div>
</nav>