<!DOCTYPE html>
<LINK rel="stylesheet" href="C:\Users\HP\OneDrive\Dokumenti\PRAKSA\GAIA\styles\Registracija uspešna.css">
<body>
    <h1 class="h1">Hvala za Registracijo</h1>
    
    <h2>Z tem podpirate podjetje Gaia</h2><br>
    <center>
       
    <a class="a button" href="C:\Users\HP\OneDrive\Dokumenti\PRAKSA\GAIA\gaia2.html">Glavna stran</a>
    <div class="div">
        <h1>Vpisani podatki</h1>
        <p class="p" id="prejetiIme"></p>
        <p class="p" id="prejetiStarost"></p>
        <p class="p" id="prejetiEmail"></p>
        <p class="p" id="prejetipostcode"></p>
        <p class="p" id="prejeticountry"></p>
        <p class="p" id="prejetiregija"></p>
        <p class="p" id="prejetiPodatki"></p>
    </div>
    </center>
    <script>
        window.onload = function() {
            // Preberemo podatke iz localStorage
            var prejmiPodatke = sessionStorage.getItem("poslaniPodatki");

            if (prejmiPodatke) {
                // Pretvorimo JSON string v objekt
                var podatki = JSON.parse(prejmiPodatke);

                // Prikazemo prejete podatke na strani
                document.getElementById("prejetiIme").innerText = "First name: " + podatki.firstName;
                document.getElementById("prejetiStarost").innerText = "Last name: " + podatki.lastName;
                document.getElementById("prejetiEmail").innerText = "Email: " + podatki.address;
                document.getElementById("prejeticountry").innerText = "Username: " + podatki.country;
            } 
            else {
                document.getElementById("prejetiPodatki").innerText = "Ni podatkov za prikaz.";
            }
        }
    </script>
    </head>
</body>