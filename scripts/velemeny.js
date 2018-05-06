$(document).ready(function() {
    var cim = $(location).attr('protocol') + '//' + $(location).attr('hostname') + $(location).attr('pathname');
    cim = cim.replace('index.php', '');
    
    $.ajax({
        type: 'get',
        url: cim + 'ajax.php?action=velemenyek',
        dataType: 'json'
    })
    .done(function(json) {
        if(json.resp === 1) {
            var eredmeny = "";
            json.velemenyek.forEach(function(velemeny) {
                eredmeny += '<li>';
                eredmeny += '<p class="nev">' + velemeny.felhasznalonev + '</p>';
                eredmeny += '<p class="ido">' + velemeny.datum + '</p>';
                eredmeny += '<p class="szoveg">' + velemeny.velemeny + '</p>';
                eredmeny += '</li>';
            });
            $('.lista').html(eredmeny);
        }
    })
    .fail(function() {
        alert('Hiba');
    });
    
    $('textarea').keypress(function(e) {
        if(e.which == 13) {
            var velemeny = $(this).val();
            
            $.ajax({
                type: 'post',
                data: { velemeny: velemeny },
                url: cim + 'ajax.php?action=velemeny',
                dataType: 'json'
            })
            .done(function(json) {
                location.reload();
            })
            .fail(function() {
                alert('Hiba');
            });
        }
    });
     
});

