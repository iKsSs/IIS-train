<?php if(isLogged() && isCustomer()) { ?>

<?php manageUser(); ?>

<?php   
if (isLogged()) :
  $profile = getProfileInfo();
?>
    
  <div id="edit">	 
    <h3>Změna údajů:</h3>
    <form method="post" action="">
      <table>		
        <tr>
     <td>
        <span class="req">Jméno</span>
     </td><td>
        <input type="text" name="name" placeholder="Jméno" required value="<?= (isset($_POST["name"])) ? $_POST["name"] : $profile['jmeno']; ?>" />	 
    </td></tr><tr><td>
    
        <span class="req">Přijmení</span>
    </td><td>
        <input type="text" name="surname" placeholder="Příjmení" required value="<?= (isset($_POST["surname"])) ? $_POST["surname"] : $profile['prijmeni']; ?>" />	
    </td></tr><tr><td>
    
       <span class="req">E-mail</span>
    </td><td>
        <input type="text" name="mail" placeholder="E-mail" required value="<?= (isset($_POST["mail"])) ? $_POST["mail"] : $profile['email']; ?>" />	
    </td></tr><tr><td>
    
    <input type="hidden" name="editProfileEvent" value="true" />
    
        <span class="req">Potvrdťe heslem</span>
    </td><td> 
        <input type="password" name="password" placeholder="Heslo" required />
    </td></tr><tr><td></td><td>
    
    <input type="submit" style="width: 150px" value="Uložit" />  
    </td></tr>

      </table>	 
    </form>	
    
    <form action="" method="post">       
      <input type="hidden" name="deleteUserEvent" value="true" />
      <input type="submit" value="Zrušit registraci" />
    </form> 
  </div> 

 <?php endif; } else printError("Musíte být registrován a přihlášen."); ?>
 