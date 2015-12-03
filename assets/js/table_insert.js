$(document).ready(function() {
	$("#add_leerling").on("click", function() {
		var $tr = $("tbody tr:last");
		var $clone = $tr.clone();
		$clone.find(':text').val('');
		$tr.after($clone);
	});
});

//functie voor het toevoegen van rijen op de examen toevoeg pagina.

function deleteRow(row)
{
    var x = document.getElementById('vraagtoevoegen');
    var new_row = x.rows[1].cloneNode(true);
    var len = x.rows.length;
    var z = len-1
    if(z <= 1){
        alert("Je niet meer vragen verwijderen");
    } else {
    document.getElementById('vraagtoevoegen').deleteRow(z);
    }
}


function insRow()
            {
                console.log('hi');
                var x = document.getElementById('vraagtoevoegen');
                var new_row = x.rows[1].cloneNode(true);
                var len = x.rows.length;

				t = len-1;
                var inp1 = new_row.cells[0].getElementsByTagName('input')[0];
                inp1.name = "vraag[" + t + "]";
                inp1.value = len;
                var inp2 = new_row.cells[1].getElementsByTagName('input')[0];
                inp2.name = "maxscore[" + t + "]";
                inp2.value = "";
                var inp3 = new_row.cells[2].getElementsByTagName('select')[0];
                inp3.name = "categorie[" + t + "]";
                inp3.value = "";


                x.appendChild(new_row);
            }