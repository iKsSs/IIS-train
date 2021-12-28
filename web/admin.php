<?php manageAdmin(); ?>
<?php manageCompany(); ?>
<?php manageStation(); ?>
<?php manageUser(); ?>

<?php if (isLogged() && isAdminAccess()) { ?>

<div id="menu_container">
	<div class="small_space" id="menu">
	<ul>
	  <li><a href="/admin/users">Správa uživatelů</a></li>
	  <li><a href="/admin/tickets">Správa jízdních dokladů</a></li>
	  <li><a href="/admin/trains">Správa vlaků a služeb</a></li>
	  <li><a href="/admin/stations">Správa stanic</a></li>
	  <li><a href="/admin/companies">Správa dopravců</a></li>
	</ul>
	</div>
</div>

<!-- vypise danou cast administrace -->
<?php 
	includeContent($_GET["item"], true);
?> 
  
<?php } else { ?>
<!-- prihlaseni -->

<h3>Přihlášení do administrace</h3>
<form action="" method="post">
    <table>
        <tr>
            <td><span class="req">Uživatelské jméno</span></td>
        <td><input type="text" name="login" placeholder="Uživatelské jméno" required /></td>
      </tr>
      <tr>
		  <td><span class="req">Heslo</span></td>	
        <td><input type="password" name="password" placeholder="Heslo" required /></td>
        </tr>
        <tr>
            <td><input type="hidden" name="loginAdminEvent" value="true" />
                <input type="submit" value="Přihlásit se" /></td>
			<td></td>
        </tr>
    </table>
</form>

<?php } ?>
