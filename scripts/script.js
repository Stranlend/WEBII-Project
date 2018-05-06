$(document).ready(function() {
    var cim = $(location).attr('protocol') + '//' + $(location).attr('hostname') + $(location).attr('pathname');
    cim = cim.replace('index.php', '');
    
    $('#bejelentkezes').click(function () {
        var felhasznalonev = $('#felhasznalonev').val();
        var jelszo = $('#jelszo').val();
        
        if(felhasznalonev != '' && jelszo != '') {
            $.ajax({
                type: 'post',
                url: cim + 'ajax.php?action=bejelentkezes',
                data: { felhasznalonev: felhasznalonev, jelszo: jelszo },
                dataType: 'json'
            })
            .done(function(json) {
                if(json.resp === 1) {
                    alert('Sikeres bejelentkezés');
                    location.href = cim;
                } else {
                    alert('Hiba');
                }
            })
            .fail(function() {
                alert('Hiba');
            });
        } else {
            alert('Nincs elég adat');
        }
    });
    
    $('#regisztracio').click(function () {
        var felhasznalonev = $('#felhasznalonev').val();
        var jelszo = $('#jelszo').val();
        var jelszo2 = $('#jelszo2').val();
        var email = $('#email').val();
        
        if(felhasznalonev != '' && jelszo != '' && email != '' && jelszo === jelszo2) {
            $.ajax({
                type: 'post',
                url: cim + 'ajax.php?action=regisztracio',
                data: { felhasznalonev: felhasznalonev , jelszo: jelszo, jelszo2: jelszo2, email: email },
                dataType: 'json'
            })
            .done(function(json) {
                if(json.resp === 1) {
                    alert("Sikeres regisztráció");
                    location.href = cim;
                }
            })
            .fail(function() {
                alert('Hiba!');
            });
        } else {
            alert('Nincs elég adat');
        }
    });
    
    $('#kijelentkezes').click(function () {
        $.ajax({
            type: 'get',
            url: cim + 'ajax.php?action=logout',
            dataType: 'json'
        })
        .done(function(json) {
            if(json.resp === 1) {
                location.href = cim;
            } else {
                alert('Hiba');
            }
        })
        .fail(function() {
            alert('Hiba');
        });
    });
    
    $('#hozzaad').click(function () {
        var velemeny = $('.velemeny-text').val();
        $.ajax({
            type: 'post',
            url: url + 'ajax.php?action=review',
            data: { velemeny: velemeny },
            dataType: 'json'
        })
        .done(function(json) {
            if(json.resp === 1) {
                location.reload();
            } else {
                alert('Hiba');
            }
        })
        .fail(function() {
            alert('Hiba');
        });
    });
});

