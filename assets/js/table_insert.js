function insertLeerlingRow() {
    var $tr = $("tbody tr:last");
    var $clone = $tr.clone().fadeIn( 300 );
    $clone.find(':text').val('');
    $tr.after($clone);
}

function deleteleerlingRow() {
    var $last = $("tbody tr:last");
    if($last.is(':first-child')){
        alert('Je kan niet meer rijen verwijderen')
    }else {
        $last.fadeOut(300, function() {
            $(this).remove();
        });
    }
    
}

//functie voor het toevoegen/weghalen van rijen op de examen toevoeg pagina.

function deleteRow(div)
{
    var x = document.getElementById('vraagtoevoegen' + div);
    var new_row = x.rows[1].cloneNode(true);
    var len = x.rows.length;
    var z = len-1
    if(z <= 1){
        alert("Je kan niet meer vragen verwijderen");
    } else {
    document.getElementById('vraagtoevoegen' + div).deleteRow(z);
    }
}


function insRow(div)
            {
                console.log('hi');
                var x = document.getElementById('vraagtoevoegen' + div);
                var new_row = x.rows[1].cloneNode(true);
                var len = x.rows.length;

                t = len-1;
                var inp1 = new_row.cells[0].getElementsByTagName('input')[0];
                inp1.name = "vraag" + t;
                inp1.value = len;
                var inp2 = new_row.cells[1].getElementsByTagName('input')[0];
                inp2.name = "maxscore" + t;
                inp2.value = "";
                var inp3 = new_row.cells[2].getElementsByTagName('select')[0];
                inp3.name = "categorie" + t;
                inp3.value = "";


                x.appendChild(new_row);
            }

