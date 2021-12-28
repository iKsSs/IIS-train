/* Autocomplete From and To station */
  $(function() {
      $( "#to" ).autocomplete({
  	source: zastavky
      });
      $( "#from" ).autocomplete({
  	source: zastavky
      });
      $( ".n_zastavka" ).autocomplete({
  	source: zastavky
      });
  });
 
function show(element)
{
	var el;
	el = document.getElementById(element);
	el.className = (el.className == 'invisible')?'active':'invisible';
}

 
function changePrice(sel) {
      
      var x = sel.parentElement.parentElement.parentElement.parentElement.parentElement.children[0].children[2];
      var summ = parseInt(x.innerHTML);
      
       if(sel.checked === true){
            summ += parseInt(sel.parentNode.getElementsByTagName("span")[0].innerHTML);          
        } 
       else {
            summ -= parseInt(sel.parentNode.getElementsByTagName("span")[0].innerHTML);          
        }  

      x.innerHTML = summ;
}

function ToSwapFrom() {
      var from = document.getElementById('from');
      var to = document.getElementById('to');
      
      var tmp = from.value;
      from.value = to.value;
      to.value = tmp;
}

function today() {     
      var tmp = new Date();
      var date = tmp.getDate(); 
      var month = tmp.getMonth() + 1;
      var year = tmp.getFullYear();
      var hours = tmp.getHours();
      var min = (tmp.getUTCMinutes() / 10 >= 1) ? tmp.getUTCMinutes() : "0"+tmp.getUTCMinutes();
            
      var dateElem = document.getElementById('date');
      var timeElem = document.getElementById('time');
      
      dateElem.value = date+"."+month+"."+year;
      timeElem.value = hours+":"+min;
}

$(document).ready(function(){
    $("#logout").click(function(){
	    $("#f_logout").submit();
    });
});


function editAdmin(sel)
{
    if(document.getElementById(sel).value === "ULOŽIT")
    {   
      var form = document.getElementById("f"+sel);
      
       var login = document.getElementById(sel+"a0");
       var admin = document.getElementById(sel+"b0");
      
         var x = document.createElement('input');
         x.setAttribute("type", "hidden");
         x.setAttribute("name", "login");
         x.setAttribute("value", login.value);
          form.appendChild(x);
          
         x = document.createElement('input');
         x.setAttribute("type", "hidden");
         x.setAttribute("name", "admin");
         x.setAttribute("value", admin.checked);
          form.appendChild(x);
          
      return true;
    }

     var login = document.getElementById(sel+"a");
     var admin = document.getElementById(sel+"b");    
     
     var input_login = document.createElement('input');
     var input_admin = document.createElement('input');
     input_login.setAttribute("id", sel+"a0");
     input_admin.setAttribute("id", sel+"b0");
     input_login.setAttribute("type", "text");
     input_admin.setAttribute("type", "checkbox"); 
     input_login.setAttribute("value", login.innerHTML);

     if(admin.innerHTML === "ANO")
     {
	 input_admin.setAttribute("checked", true);
     }

     login.innerHTML = "";
     admin.innerHTML = "";

     login.appendChild(input_login);
     admin.appendChild(input_admin);
   
    var form = document.getElementById("f"+sel);
    
     var x = document.createElement('input');
     x.setAttribute("type", "hidden");
     x.setAttribute("name", "id");
     x.setAttribute("value", input_login.value);
      form.appendChild(x);
     
     document.getElementById(sel).value = "ULOŽIT";  
     
     return false;        
}

function editUzivatel(sel)
{
    if(document.getElementById(sel).value === "ULOŽIT")
    {   
      var form = document.getElementById("f"+sel);
      
       var jmeno = document.getElementById(sel+"a0");
       var prijm = document.getElementById(sel+"b0");
       var login = document.getElementById(sel+"c0");
       var email = document.getElementById(sel+"d0");
      
         var x = document.createElement('input');
         x.setAttribute("type", "hidden");
         x.setAttribute("name", "jmeno");
         x.setAttribute("value", jmeno.value);
          form.appendChild(x);
          
         x = document.createElement('input');
         x.setAttribute("type", "hidden");
         x.setAttribute("name", "prijm");
         x.setAttribute("value", prijm.value);
          form.appendChild(x);
      
         x = document.createElement('input');
         x.setAttribute("type", "hidden");
         x.setAttribute("name", "login");
         x.setAttribute("value", login.value);
          form.appendChild(x);
          
         x = document.createElement('input');
         x.setAttribute("type", "hidden");
         x.setAttribute("name", "email");
         x.setAttribute("value", email.value);
          form.appendChild(x);
          
      return true;
    }

     var jmeno = document.getElementById(sel+"a");
     var prijm = document.getElementById(sel+"b");
     var login = document.getElementById(sel+"c");
     var email = document.getElementById(sel+"d");    
     
     var input_jmeno = document.createElement('input');
     var input_prijm = document.createElement('input');
     var input_login = document.createElement('input');
     var input_email = document.createElement('input');
     
     input_jmeno.setAttribute("id", sel+"a0");
     input_prijm.setAttribute("id", sel+"b0");
     input_login.setAttribute("id", sel+"c0");
     input_email.setAttribute("id", sel+"d0");
     
     input_jmeno.setAttribute("type", "text");
     input_prijm.setAttribute("type", "text"); 
     input_login.setAttribute("type", "text");
     input_email.setAttribute("type", "email");

     input_jmeno.setAttribute("value", jmeno.innerHTML);
     input_prijm.setAttribute("value", prijm.innerHTML);
     input_login.setAttribute("value", login.innerHTML);
     input_email.setAttribute("value", email.innerHTML);

     jmeno.innerHTML = "";
     prijm.innerHTML = "";
     login.innerHTML = "";
     email.innerHTML = "";

     jmeno.appendChild(input_jmeno);
     prijm.appendChild(input_prijm);
     login.appendChild(input_login);
     email.appendChild(input_email);
   
    var form = document.getElementById("f"+sel);
    
     var x = document.createElement('input');
     x.setAttribute("type", "hidden");
     x.setAttribute("name", "id");
     x.setAttribute("value", input_login.value);
      form.appendChild(x);
     
     document.getElementById(sel).value = "ULOŽIT";  
     
     return false;        
} 

function editVlak(sel)
{
    if(document.getElementById(sel).value === "ULOŽIT")
    {   
      var form = document.getElementById("f"+sel);
      
       var cislo = document.getElementById(sel+"a");
       var nazev = document.getElementById(sel+"b0");
       var kateg = document.getElementById(sel+"c0");
       var razen = document.getElementById(sel+"d0");
       var dopra = document.getElementById(sel+"e0");
          
         var x = document.createElement('input');
         x.setAttribute("type", "hidden");
         x.setAttribute("name", "nazev");
         x.setAttribute("value", nazev.value);
          form.appendChild(x);
      
         x = document.createElement('input');
         x.setAttribute("type", "hidden");
         x.setAttribute("name", "kateg");
         x.setAttribute("value", kateg.value);
          form.appendChild(x);
          
         x = document.createElement('input');
         x.setAttribute("type", "hidden");
         x.setAttribute("name", "razen");
         x.setAttribute("value", razen.value);
          form.appendChild(x);
                           
         x = document.createElement('input');
         x.setAttribute("type", "hidden");
         x.setAttribute("name", "dopra");
         x.setAttribute("value", dopra.value);
          form.appendChild(x);
          
         x = document.createElement('input');
         x.setAttribute("type", "hidden");
         x.setAttribute("name", "id");
         x.setAttribute("value", cislo.innerHTML);
          form.appendChild(x);
          
      return true;
    }

     var nazev = document.getElementById(sel+"b");
     var kateg = document.getElementById(sel+"c");
     var razen = document.getElementById(sel+"d");  
     var dopra = document.getElementById(sel+"e");  
     
     var input_nazev = '<input type="text" id="'+sel+'b0" style="width: 100px;" value="'+nazev.innerHTML+'" />';
     var input_kateg = '<input type="text" id="'+sel+'c0" style="width: 50px;" value="'+kateg.innerHTML+'" />';
     var input_razen = '<textarea id="'+sel+'d0" style="width: 425px; height: 32px;">'+razen.innerHTML+'</textarea>';
     var input_dopra = '<select id="'+sel+'e0" style="width: 125px;">'+sel_dopravci+'</select>';
     
     /* Tag selected transporter */
     var index = input_dopra.indexOf(dopra.innerHTML)-1;
     input_dopra = input_dopra.substr(0,index) + ' selected="selected"' + input_dopra.substr(index);
     
     nazev.innerHTML = input_nazev;
     kateg.innerHTML = input_kateg;
     razen.innerHTML = input_razen;
     dopra.innerHTML = input_dopra;

     document.getElementById(sel).value = "ULOŽIT";  
     
     return false;          
}

function removeReq()
{
    $(':input[required]').removeAttr("required"); 
    return false;
}

$(document).ready(function(){
    $("button.add_new").click(add_fun);
    $("button.sub_new").click(sub_fun);
    
    function add_fun(){
	var link = $( this ).parent().parent();
        $( "<tr></tr>" ).insertAfter( link );
	
	link = link.next();
	
	var input = '<td><input type="text" name="time" class="n_time" /></td>' +
		    '<td><input type="text" name="time2" class="n_time2" /></td>' +				
		    '<td><select name="zastavka" class="n_zastavka">'+sel_zastavky+'</select></td>' +	
		    '<td><input type="text" name="staniceni" class="n_staniceni" /></td>' +	
		    '<td>' +
			'<button onclick="return false;" class="add_new">+</button>' +
			'<button onclick="return false;" class="sub_new">-</button>' +
		    '</td>';
	
	link.html(input);
	
	$("button.add_new").unbind("click", add_fun);     
	$("button.add_new").bind("click", add_fun);
	$("button.sub_new").bind("click", sub_fun);
    }
  
    function sub_fun(){
	var link = $( this ).parent().parent();
	link.children().remove();
	link.remove();
    }
    
    $("#sav_new").click(function(){
	var link = $( this ).parent().parent().parent();
	var count = link.children().length-2;
	var x = document.createElement('input');
	x.setAttribute("type", "hidden");
	x.setAttribute("name", "count");
	x.setAttribute("value", count);
	$( "#ns" ).append(x);
	
	x = document.createElement('input');
	x.setAttribute("type", "hidden");
	x.setAttribute("name", "vlak");
	x.setAttribute("value", $( "#n_vlak" ).html());
	$( "#ns" ).append(x);
	
	var rowIndex = 0;
	$(".n_time").each(function(){
	    $(this).attr('id', 'time' + rowIndex);
	    $(this).attr('name', 'time' + rowIndex++);
	});
	
	var rowIndex = 0;
	$(".n_time2").each(function(){
	    $(this).attr('id', 'times' + rowIndex);
	    $(this).attr('name', 'times' + rowIndex++);
	});
	
	var rowIndex = 0;
	$(".n_zastavka").each(function(){
	    $(this).attr('id', 'zastavka' + rowIndex);
	    $(this).attr('name', 'zastavka' + rowIndex++);
	});   
	
	var rowIndex = 0;
	$(".n_staniceni").each(function(){
	    $(this).attr('id', 'staniceni' + rowIndex);
	    $(this).attr('name', 'staniceni' + rowIndex++);
	});
	    
	var tmp = "";
	
	for ( i=0; i < count ; ++i )
	{
	    var time = $("#time"+i).val();
	    var time2 = $("#times"+i).val();
	    var staniceni = $("#staniceni"+i).val();
	    
	    $("#time"+i).removeClass('invalid');
	    $("#times"+i).removeClass('invalid');
	    $("#staniceni"+i).removeClass('invalid');
	    
	    var col = time.indexOf(":");
	    var hour = time.substr(0, col);
	    var min = time.substr(col+1);

	    var col2 = time2.indexOf(":");
	    var hour2 = time2.substr(0, col2);
	    var min2 = time2.substr(col2+1);
	    
	    var exp = (hour2 + 60/min2) - (hour + 60/min);
	   
	    if ( time === "" )
	    {
		tmp += "Čas příjezdu musí být vyplněn - řádek "+(i+1)+"<br />";
		$("#time"+i).addClass('invalid');
	    }
	    else if ( !(col > 0 && hour >= 0 && hour < 24 && min >= 0 && min < 60) )
	    {
		tmp += "Čas příjezdu musí být ve fromátu HH:MM v rozsahu 00:00 - 23:59 - řádek "+(i+1)+"<br />";
		$("#time"+i).addClass('invalid');              
	    }
	    
	    if ( time2 === "" )
	    {
		tmp += "Čas odjezdu musí být vyplněn - řádek "+(i+1)+"<br />";
		$("#times"+i).addClass('invalid');
	    }
	    else if ( !(col2 > 0 && hour2 >= 0 && hour2 < 24 && min2 >= 0 && min2 < 60) )
	    {
		tmp += "Čas odjezdu musí být ve fromátu HH:MM v rozsahu 00:00 - 23:59 - řádek "+(i+1)+"<br />";
		$("#times"+i).addClass('invalid');
	    }

	    if ( exp < 0 )
	    {
		tmp += "Čas odjezdu musí být později než čas příjezdu - řádek "+(i+1)+"<br />";
	    }
	    
	    if ( staniceni === "" )
	    {
		tmp += "Staniceni musí být vyplněno - řádek "+(i+1)+"<br />";
		$("#staniceni"+i).addClass('invalid');
	    }
	    else if (isNaN(staniceni))
	    {
		tmp += "Staniceni musí být číslo - řádek "+(i+1)+"<br />";
		$("#staniceni"+i).addClass('invalid');
	    }
	}
	
	if ( tmp === "" )
	{
	    $( "#ns" ).unbind('submit').submit();
	}
	else
	{
	    $(".done").hide();
	    $("#txtSearch").addClass("error");
	    $("#txtSearch").html(tmp);
	}
    });
    
    $("#ns").submit(function (e) {
        e.preventDefault(); //prevent default form submit
    });
}); 

sel_zastavky = "";
for (var i = 0; i < zastavky.length; i++) 
{ 
    sel_zastavky += '<option>'+zastavky[i]+'</option>'; 
}

sel_dopravci = "";
for (var i = 0; i < dopravci.length; i++) 
{ 
    sel_dopravci += '<option>'+dopravci[i]+'</option>'; 
}

function checkTimetable()
{

    return false;
}
 
  