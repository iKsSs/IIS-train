<?php include 'function.php'; ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">	
  <head>		
     <meta charset="utf-8" />		
    <meta name="viewport" content="width=device-width,initial-scale=1" />		
    <meta name="robots" content="all,follow" />		
    <meta name="author" content="Martin Pitřík, Jakub Pastuszek" />		
    <base href="/">		
    <meta name="keywords" content="" />		
    <meta name="description" content="" />									 		
    <title>Vlak.JeCool.net - hledač vlakových spojení</title>	
    
<!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
	
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />
	<link type="text/css" href="/style.css" rel="stylesheet" />	
	
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script type="text/javascript" src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>	

	<script type='text/javascript'>
		<?php
			/* Search for whole list of names of stations */
			$php_array = getStations();
			
			/* Transform PHP array to JS */
			$js_array = json_encode($php_array);
			echo "zastavky = ". $js_array . ";";
			
			/* Search for whole list of names of stations */
			$php_array = getTransporters();
			
			/* Transform PHP array to JS */
			$js_array = json_encode($php_array);
			echo "dopravci= ". $js_array . ";";			
		?>
	</script>
  
  <script src="/js/jquery.js"></script>
  
  </head>	
  <body>
  <?php logout(); ?>	   	
    <div id="header">        
      <div class="inner">            
        <a href="/">
          <div id="logo">                <h1>Vlak.jecool.cz</h1>                <h2>Spojení na internetu</h2>            
          </div></a>            
        <div id="menu" class="big_space">                
          <ul>       
			  <?php if(!isAdminAccess()) { ?>
            <li>
            <a href="/spojeni/">Hledat spoj</a>
            </li>
			  <?php } if(isCustomer()) { ?>
            <li>
            <a href="/profil/">Profil</a>
            </li>
            <li>
            <a href="/nakupy/">Nákupy</a>
            </li>
            <li>
            <form id="f_logout" action="" method="post">
              <input type="hidden" name="logoutEvent" value="true" />   
              <a id="logout">Odhlásit se</a>
            </form>
            </li>
			 <?php  } else if(isLogged() && !isCustomer()) { ?>
            <li><a href="/admin/"><?= isAdmin() ? "Admin" : "Správce" ?></a>
				<ul class="children">
					<li><a href="/admin/users">Správa uživatelů</a></li>
					<li><a href="/admin/tickets">Správa jízdních dokladů</a></li>
					<li><a href="/admin/trains">Správa vlaků a služeb</a></li>
					<li><a href="/admin/stations">Správa stanic</a></li>
					<li><a href="/admin/companies">Správa dopravců</a></li>
				</ul>
            </li>
			<li>
            <form id="f_logout" action="" method="post">
              <input type="hidden" name="logoutEvent" value="true" />   
              <a id="logout">Odhlásit se</a>
            </form>
            </li>
            <?php } else { ?>
            <li>
            <a href="/prihlaseni/">Přihlásit se</a>
            </li>                    
            <li>
            <a href="/registrace/">Registrace</a>
            </li>
            <?php } ?> 				                                
          </ul>            
        </div>        
      </div>	
    </div>
    <div class="inner">          
    <div id="main">            
      <?php includeContent($_GET["page"]); ?>        
    </div>
    </div>	
    <div id="footer">	
    Reklama:<endora></ednora>
    </div>	
  </body>
</html>