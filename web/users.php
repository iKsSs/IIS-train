<?php if (isLogged() && isAdminAccess()) { ?>

<?php if(isAdmin()) { ?>
<h3>Přidat nového správce/administrátora:</h3>

<div id="registration">    
  <form action="" method="post">
    <table>
      <tr>
        <td><span class="req">Přihlašovací jméno</span></td>
        <td><input type="text" name="login" placeholder="Přihlašovací jméno" required /></td>
      </tr>
      <tr>
        <td><span class="req">Heslo</span></td>	
        <td><input type="text" name="password" placeholder="Heslo" required /></td>
      </tr>
      <tr>
        <td>Admin oprávnění</td>	
        <td><input type="checkbox" name="admin" /></td>
      </tr>
      <tr>
        <td><input type="hidden" name="registerAdminEvent" value="true" />
        <input type="submit" value="Vložit" /></td> 
      </tr> 
    </table>
  </form>
</div>

 <hr />
  <br />

<div id="admins">
  <h3>Správci:</h3>
		<div class="tab">
        <table>
          <thead class="center">
		  <tr> 
			<td>Login</td><td>Admin</td><td colspan="2">Akce</td>
          </tr>
		  </thead>
                  
  <?php $array = getAdminUsers(); $id = getSessionId(); $i=0;?> 
  <?php foreach($array as $val) { 
  ?>

          <tr>
           <form action="" method="post" id="far<?= $i ?>">
            <td id="ar<?= $i ?>a"><?= $val['login'] ?></td>
            <td id="ar<?= $i ?>b"><?= $val['admin'] ? "ANO" : "" ?></td>
            <td>
               <input type="submit" id="ar<?= $i ?>" onClick="return editAdmin('ar<?= $i ?>');" value="EDITOVAT" />
               <input type="hidden" name="editaceAdmina" value="true" />
            </td>
           </form>
          <td>
            <form action="" method="post">
              <?php if ( $val['aktivni'] == TRUE ) : ?>
                  <input type="submit" value="DEAKTIVOVAT" name="akce"
                    <?php if ($val['login'] == "admin") : ?>disabled="disabled"<?php endif; ?> />  
              <?php else : ?>
                  <input type="submit" value="AKTIVOVAT" name="akce" />
              <?php endif; ?>
              <input type="hidden" name="login" value="<?= $val['login'] ?>" />
              <input type="hidden" name="aktivaceAdmina" value="true" />
            </form>
          </td>
          </tr>
  <?php $i++; } ?>
        </table>
</div>		
</div>  

<br />
<?php } ?>

<div id="users">
  <h3>Zákazníci:</h3>  
		<div class="tab">
        <table>
          <thead class="center">
		  <tr> 
			<td>Jméno</td><td>Příjmení</td><td>Login</td><td>E-mail</td><td colspan="2">Akce</td>
          </tr>
		  </thead>
        
  <?php $array = getUsers(); $i=0; ?> 
  <?php foreach($array as $val) { ?>
  <?php if ($val['login'] != "") { ?>
          <tr>
          <form action="" method="post" id="fzr<?= $i ?>">
            <td id="zr<?= $i ?>a"><?= $val['jmeno'] ?></td>
            <td id="zr<?= $i ?>b"><?= $val['prijmeni'] ?></td>
            <td id="zr<?= $i ?>c"><?= $val['login'] ?></td>
            <td id="zr<?= $i ?>d"><?= $val['email'] ?></td>
            <td>
                 <input type="submit" id="zr<?= $i ?>" onClick="return editUzivatel('zr<?= $i ?>');" value="EDITOVAT" />
                 <input type="hidden" name="editaceUzivatele" value="true" />
            </td>
           </form>
          <td>
            <form action="" method="post">
              <?php if ( $val['aktivni'] == TRUE ) : ?>
                  <input type="submit" value="DEAKTIVOVAT" name="akce" >  
              <?php else : ?>
                  <input type="submit" value="AKTIVOVAT" name="akce">
              <?php endif; ?>
              <input type="hidden" name="login" value="<?= $val['login'] ?>">
              <input type="hidden" name="aktivaceUzivatele" value="true">
            </form>
          </td>
          </tr>
  <?php $i++; }} ?>
        </table>    
		 </div>
</div> 

<br />

<div id="nonusers">
  <h3>Neregistrovaní:</h3>  
        <div class="tab">
		<table>
          <thead class="center">
		  <tr> 
			<td>Jméno</td><td>Příjmení</td><td>E-mail</td>
          </tr>
		  </thead>
        
  <?php $array = getUsers(); $i=0; ?> 
  <?php foreach($array as $val) { ?>
  <?php if ($val['login'] == "") { ?>
          <tr>
          <form action="" method="post" id="fnzr<?= $i ?>">
            <td id="nzr<?= $i ?>a"><?= $val['jmeno'] ?></td>
            <td id="nzr<?= $i ?>b"><?= $val['prijmeni'] ?></td>
            <td id="nzr<?= $i ?>d"><?= $val['email'] ?></td>
           </form>
          </tr>
  <?php $i++; }} ?>
        </table> 
			</div>
</div>

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
        </tr>
    </table>
</form>

<?php } ?>