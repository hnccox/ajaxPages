/* Any JavaScript here will be loaded for all users on every page load. */

function validateMyForm(event)
{
    event.preventDefault();
    var regexC14 = /[a-zA-Z]+[-][0-9]+[a-z]?/gm;

    var labidnr = document.getElementById("inputLabidnr").value;
    var samplename = document.getElementById("inputSamplename").value;

    if(!labidnr.match(regexC14) || !samplename) { 
        if(!samplename) { window.alert("Provide a samplename"); } else { window.alert("LabIdnr is incorrect"); }
    } else {

        const C14object = {
            labidnr: labidnr,
            samplename: samplename
        }

        localStorage.setItem('C14object', JSON.stringify(C14object));

        window.location.href = 'https://wikiwfs.geo.uu.nl/wiki/Special:FormEdit/C14CatalogueId_Create/RijnMaasDelta:C14Catalogue/' + labidnr;
        return false;
    }

}

function CBGroup() {
    console.log("CBGroup");

    // idMentions("CBGroup");
    id__cross_ref();
}

function CBCatalogue() {
    console.log("CBCatalogue");

    function riverSystemGroup() {
        var list = document.getElementsByTagName("table");

        for (var i = 0; i < list.length; i++) {
            var table = list[i];
            var rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");

            for (var j = 0; j < rows.length; j++) {
                var columns = rows[j].getElementsByTagName("td");
                var riversystemgrp = columns[columns.length - 1].innerText;

                switch (riversystemgrp) {
                    case "N/A":
                        columns[columns.length - 1].innerHTML = "Unlabeled";
                        break;
                    case "Hol":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/Holocene_LocalRivers'>" + riversystemgrp + "</a>";
                        break;
                    case "LG":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/LateGlacial_LocalRivers'>" + riversystemgrp + "</a>";
                        break;
                    case "S":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/Schiedam_(Rhine)'>" + riversystemgrp + "</a>";
                        break;
                    case "B":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/Benschop_(Rhine)'>" + riversystemgrp + "</a>";
                        break;
                    case "G":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/Graaf_(Rhine)'>" + riversystemgrp + "</a>";
                        break;
                    case "U":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/Utrecht_(Rhine)'>" + riversystemgrp + "</a>";
                        break;
                    case "K":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/Krimpen_(Rhine)'>" + riversystemgrp + "</a>";
                        break;
                    case "Ls":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/Liemers_(Rhine)'>" + riversystemgrp + "</a>";
                        break;
                    case "E":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/Est_(Rhine)'>" + riversystemgrp + "</a>";
                        break;
                    case "Ln":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/Linschoten_(Rhine)'>" + riversystemgrp + "</a>";
                        break;
                    case "R":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/Ridderkerk_(Meuse)'>" + riversystemgrp + "</a>";
                        break;
                    case "H":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/Heusden_(Meuse)'>" + riversystemgrp + "</a>";
                        break;
                    case "M":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/Maas_(Meuse)'>" + riversystemgrp + "</a>";
                        break;
                    case "LT":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/LatePleniglacial_RhineTerrace'>" + riversystemgrp + "</a>";
                        break;
                    case "BA":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/Bolling-Allerod_RhineTerrace'>" + riversystemgrp + "</a>";
                        break;
                    case "TX":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/YoungerDryas_RhineTerrace'>" + riversystemgrp + "</a>";
                        break;
                    case "PB":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/Preboreal_incisive'>" + riversystemgrp + "</a>";
                        break;
                    case "BO":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/Boreal_incisive'>" + riversystemgrp + "</a>";
                        break;
                    case "AT":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/Atlantic_incisive'>" + riversystemgrp + "</a>";
                        break;
                    case "SB":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/Subboreal_incisive'>" + riversystemgrp + "</a>";
                        break;
                    case "SA":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/Subatlantic_incisive'>" + riversystemgrp + "</a>";
                        break;
                    case "A45":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/EarlyMiddle_Pleniglacial_RhineTerrace'>" + riversystemgrp + "</a>";
                        break;
                    case "B34":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/MiddlePleniglacial_RhineTerrace'>" + riversystemgrp + "</a>";
                        break;
                    case "LPG":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/LatePleniglacial_LocalRivers'>" + riversystemgrp + "</a>";
                        break;
                    case "MPG":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/EarlyMiddle_Pleniglacial_MeuseTerrace'>" + riversystemgrp + "</a>";
                        break;
                    case "S6A1":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/SaalianWarthe_RhineTerrace'>" + riversystemgrp + "</a>";
                        break;
                    case "B1":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/SaalianWarthe_MeuseTerrace'>" + riversystemgrp + "</a>";
                        break;
                    case "S5":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/SaalianDrenthe_Terrace_(postPGM)'>" + riversystemgrp + "</a>";
                        break;
                    case "S4":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/SaalianDrenthe_Terrace_(PGM)'>" + riversystemgrp + "</a>";
                        break;
                    case "S3":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/SaalianDrenthe_Terrace_(prePGM)'>" + riversystemgrp + "</a>";
                        break;
                    case "X":
                        columns[columns.length - 1].innerHTML = "<a href='/wiki/RijnMaasDelta:CBGroup/Exceptions'>" + riversystemgrp + "</a>";
                        break;
                }
            }
        }
    }

    riverSystemGroup();
}

function CBCatalogueId() {
    console.log("CBCatalogueId");

    function formEditOnly() {
        if (document.getElementById("ca-edit") != null) {
            document.getElementById("ca-edit").remove();
        }
        if (document.getElementById("ca-edit-ext") != null) {
            document.getElementById("ca-edit-ext").remove();
        }
    }

    function prevnext() {
        if ((document.getElementById("prev") != null) && (document.getElementById("next") != null)) {
            var Url = window.location.href.split("/");
            Url.pop();
            var baseUrl = Url.join("/");
            var prev = document.getElementById("prev").innerHTML;
            var next = document.getElementById("next").innerHTML;
            var prevAtt = baseUrl + "/CB" + prev;
            var nextAtt = baseUrl + "/CB" + next;

            if (prev == "false") {
                document.getElementById("CBprev").classList.remove("btn-primary");
                document.getElementById("CBprev").classList.add("btn-secondary");
                document.getElementById("CBprev").classList.add("disabled");
            } else {
                document.getElementById("CBprev").setAttribute("href", prevAtt);
            };
            if (next == "false") {
                document.getElementById("CBnext").classList.remove("btn-primary");
                document.getElementById("CBnext").classList.add("btn-secondary");
                document.getElementById("CBnext").classList.add("disabled");
            } else {
                document.getElementById("CBnext").setAttribute("href", nextAtt);
            };
        }
    }

    function releaseCandidateNotify() {
        if (document.getElementById("rc-releasecandidate").innerHTML == "true") {
            document.getElementById("releasecandidateAlertWarning").classList.remove("hidden");
        }

        var myArray = Array.from(document.getElementById("mws-properties").children);
        var myJSON = {};

        myArray.forEach(function (div, key, arr) {
            if (div.id === "rc-releasecandidate" ||
                div.id === "rc-id" ||
                div.id === "rc-name" ||
                div.id === "rc-abegin" ||
                div.id === "rc-abegincalbp" ||
                div.id === "rc-abeginadbc" ||
                div.id === "rc-aend" ||
                div.id === "rc-aendcalbp" ||
                div.id === "rc-aendadbc" ||
                div.id === "rc-abegindatingid" ||
                div.id === "rc-aenddatingid" ||
                div.id === "rc-remarkarcheology" ||
                div.id === "rc-remarkupdates"
            ) {
                return;
            } else {
                if ((div.innerText !== "") && (div.innerText.trim() != document.getElementById(div.id.split("-")[1]).innerText.trim())) {
                    myJSON[div.id.split("-")[1]] = document.getElementById(div.id.split("-")[1]).innerText.trim();
                }
            }
            if (Object.is(arr.length - 1, key)) {
                // execute last item logic
                // console.log(`Last callback call at index ${key} with value ${div}` );
                localStorage.setItem('CBCatalogueIdProperties', JSON.stringify(myJSON));
            }
        });

        // console.log(document.getElementById("releasecandidateAlertWarning").getElementsByTagName('a')[0]);
        document.getElementById("releasecandidateAlertWarning").getElementsByTagName('a')[0].onclick = function (e) {
            e.preventDefault();
            Object.keys(myJSON).forEach(function (div, key, arr) {
                document.getElementById(div).innerText = document.getElementById('rc-' + div).innerText;
                document.getElementById(div).style.backgroundColor = "#faf3ce";
                if (Object.is(arr.length - 1, key)) {
                    // execute last item logic
                    // console.log(`Last callback call at index ${key} with value ${div}`);
                    // idMentions("CBCatalogue");
                    id__cross_ref();
                    document.getElementById("releasecandidateAlertWarning").classList.add("hidden");
                    document.getElementById("releasecandidateAlertDanger").classList.remove("hidden");
                }
            });
        };

        // console.log(document.getElementById("releasecandidateAlertDanger").getElementsByTagName('a')[0]);
        document.getElementById("releasecandidateAlertDanger").getElementsByTagName('a')[0].onclick = function (e) {
            e.preventDefault();
            Object.keys(JSON.parse(localStorage.getItem('CBCatalogueIdProperties'))).forEach(function (div, key, arr) {
                document.getElementById(div).innerText = JSON.parse(localStorage.getItem('CBCatalogueIdProperties'))[div];
                document.getElementById(div).style.backgroundColor = "transparent";
                if (Object.is(arr.length - 1, key)) {
                    // execute last item logic
                    // console.log(`Last callback call at index ${key} with value ${div}`);
                    // idMentions("CBCatalogue");
                    id__cross_ref();
                    document.getElementById("releasecandidateAlertDanger").classList.add("hidden");
                    document.getElementById("releasecandidateAlertWarning").classList.remove("hidden");
                }
            });
        };
    }

    function riverSystemGroup() {
        var riversystemgrp = document.getElementById("riversystemgrp").innerHTML;
        //console.log(riversystemgrp);
        switch (riversystemgrp) {
            case "N/A":
                document.getElementById("riversystemgrp").innerHTML = "Unlabeled";
                break;
            case "Hol":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/Holocene_LocalRivers'>Holocene, not differentiated</a>";
                break;
            case "LG":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/LateGlacial_LocalRivers'>Late Glacial, not differentiated</a>";
                break;
            case "S":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/Schiedam_(Rhine)'>Schiedam river system</a>";
                break;
            case "B":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/Benschop_(Rhine)'>Benschop river system</a>";
                break;
            case "G":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/Graaf_(Rhine)'>Graaf river system</a>";
                break;
            case "U":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/Utrecht_(Rhine)'>Utrecht river system</a>";
                break;
            case "K":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/Krimpen_(Rhine)'>Krimpen river system</a>";
                break;
            case "Ls":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/Liemers_(Rhine)'>Liemers river system</a>";
                break;
            case "E":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/Est_(Rhine)'>Est river system</a>";
                break;
            case "Ln":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/Linschoten_(Rhine)'>Linschoten river system</a>";
                break;
            case "R":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/Ridderkerk_(Meuse)'>Ridderkerk river system</a>";
                break;
            case "H":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/Heusden_(Meuse)'>Heusden river system</a>";
                break;
            case "M":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/Maas_(Meuse)'>Maas river system</a>";
                break;
            case "LT":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/LatePleniglacial_RhineTerrace'>'Lower Terrace' Late Pleniglacial NT2</a>";
                break;
            case "BA":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/Bolling-Allerod_RhineTerrace'>Bolling/Allerod</a>";
                break;
            case "TX":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/YoungerDryas_RhineTerrace'>'TerraceX', Younger Dryas, NT3</a>";
                break;
            case "PB":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/Preboreal_incisive'>Preboreal incisive, E-NT3, EH1</a>";
                break;
            case "BO":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/Boreal_incisive'>Boreal incisive, EH1, EH2</a>";
                break;
            case "AT":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/Atlantic_incisive'>Atlantic incisive, MH1</a>";
                break;
            case "SB":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/Subboreal_incisive'>Subboreal incisive, MH2</a>";
                break;
            case "SA":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/Subatlantic_incisive'>Subatlantic incisive, JH1-3</a>";
                break;
            case "A45":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/EarlyMiddle_Pleniglacial_RhineTerrace'>'Lower Terrace' Early-Middle Pleniglacial</a>";
                break;
            case "B34":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/MiddlePleniglacial_RhineTerrace'>'Lower Terrace' Middle Pleniglacial, NT1, Om Montferland</a>";
                break;
            case "LPG":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/LatePleniglacial_LocalRivers'>'Lower Terrace' Late Pleniglacial</a>";
                break;
            case "MPG":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/EarlyMiddle_Pleniglacial_MeuseTerrace'>'Lower Terrace' Early-Middle Pleniglacial</a>";
                break;
            case "S6A1":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/SaalianWarthe_RhineTerrace'>Saalian Warthe Stage, deglaciation S6</a>";
                break;
            case "B1":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/SaalianWarthe_MeuseTerrace'>Saalian Warthe Stage, deglaciation B1 (Meuse within S5)</a>";
                break;
            case "S5":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/SaalianDrenthe_Terrace_(postPGM)'>Saalian Drenthe Stage, tipping point</a>";
                break;
            case "S4":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/SaalianDrenthe_Terrace_(PGM)'>Saalian Drenthe Stage, glaciation near-maximum</a>";
                break;
            case "S3":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/SaalianDrenthe_Terrace_(prePGM)'>Saalian Drenthe Stage, advancing stage</a>";
                break;
            case "X":
                document.getElementById("riversystemgrp").innerHTML = "(" + riversystemgrp + ") <a href='/wiki/RijnMaasDelta:CBGroup/Exceptions'>Exception - Berendsen & Stouthamer 2001</a>";
                break;
        }
    }

    function drawSlope(dnstrxco, dnstryco, upstrxco, upstryco, dnstrtopsand, upstrtopsand) {
        var c = document.getElementById("myCanvas");
        var ctx = c.getContext("2d");
        var avgslope, dnstrxco, dnstryco, dnstrtopsand, upstrxco, upstryco, upstrtopsand;
        // avgslope = parseInt(document.getElementById("avgslope").getAttribute("placeholder"), 10); // Not exact!
        dnstrxco = parseInt(document.getElementById("dnstrxco").getAttribute("placeholder"), 10);
        dnstryco = parseInt(document.getElementById("dnstryco").getAttribute("placeholder"), 10);
        upstrxco = parseInt(document.getElementById("upstrxco").getAttribute("placeholder"), 10);
        upstryco = parseInt(document.getElementById("upstryco").getAttribute("placeholder"), 10);
        dnstrtopsand = parseFloat(document.getElementById("dnstrtopsand").getAttribute("placeholder"));
        upstrtopsand = parseFloat(document.getElementById("upstrtopsand").getAttribute("placeholder"));
        var aa, bb, cc, elevationDiff, elDiff2, h, w, h2, w2, c2;
        aa = Math.pow(Math.abs(upstrxco - dnstrxco), 2);
        bb = Math.pow(Math.abs(upstryco - dnstryco), 2);
        cc = aa + bb;
        elevationDiff = parseFloat(Math.abs(dnstrtopsand - upstrtopsand).toFixed(1));
        var avgslope = (elevationDiff / Math.sqrt(cc)) * 100000;
        console.log(avgslope);
        h = myCanvas.getAttribute("height");
        w = myCanvas.getAttribute("width");

        c2 = Math.sqrt(cc) / 2;
        elDiff2 = elevationDiff / 2;

        h = h * 0.96;
        h2 = (h / 2);
        w = w * 0.96;
        w2 = (w / 2);

        var x1, y1, x2, y2;

        ctx.clearRect(0, 0, w, h);
        ctx.beginPath();
        ctx.moveTo((300 - w2), (100 - h2));
        ctx.lineTo(300, 100);
        ctx.stroke();
    }

    formEditOnly();
    prevnext();
    releaseCandidateNotify();
    riverSystemGroup();
    drawSlope();
    // idMentions("CBCatalogue");
    id__cross_ref();
}

function C14Catalogue() {
    console.log("C14Catalogue");

    function InUseFor() {
        // var table = document.getElementsByTagName("table")[0];
        // table.innerHTML = table.innerHTML.replace(/<td>t/g, '<td>&#10004;').replace(/<td>f/g, '<td>');
        
        var table = document.getElementsByTagName("table")[0];
        var marinecurve2bused, inuseforchannelage, inuseforgwtinterpol, inuseforldem, inuseformslrise, inuseforvegetationhistory, inuseforlandsubsidence, inuseforcompactquant;
        marinecurve2bused = 4;
        inuseforchannelage = 5;
        inuseforgwtinterpol = 6;
        inuseforldem = 7;
        inuseformslrise = 8;
        inuseforvegetationhistory = 9;
        inuseforlandsubsidence = 10;
        inuseforcompactquant = 11;

        for (i = 1; i < table.rows.length; i++) {

            if (table.rows[i].cells[marinecurve2bused].innerText == "1") {
                table.rows[i].cells[marinecurve2bused].innerHTML = "&excl;";
            } else {
                table.rows[i].cells[marinecurve2bused].innerText = "";
            }

            if (table.rows[i].cells[inuseforchannelage].innerText == "1") {
                table.rows[i].cells[inuseforchannelage].innerHTML = "&#10004;";
            } else {
                table.rows[i].cells[inuseforchannelage].innerText = "";
            }

            if (table.rows[i].cells[inuseforgwtinterpol].innerText == "1") {
                table.rows[i].cells[inuseforgwtinterpol].innerHTML = "&#10004;";
            } else {
                table.rows[i].cells[inuseforgwtinterpol].innerText = "";
            }

            if (table.rows[i].cells[inuseformslrise].innerText == "1") {
                table.rows[i].cells[inuseformslrise].innerHTML = "&#10004;";
            } else {
                table.rows[i].cells[inuseformslrise].innerText = "";
            }

            if (table.rows[i].cells[inuseforvegetationhistory].innerText == "1") {
                table.rows[i].cells[inuseforvegetationhistory].innerHTML = "&#10004;";
            } else {
                table.rows[i].cells[inuseforvegetationhistory].innerText = "";
            }

            if (table.rows[i].cells[inuseforlandsubsidence].innerText == "1") {
                table.rows[i].cells[inuseforlandsubsidence].innerHTML = "&#10004;";
            } else {
                table.rows[i].cells[inuseforlandsubsidence].innerText = "";
            }

            if (table.rows[i].cells[inuseforcompactquant].innerText == "1") {
                table.rows[i].cells[inuseforcompactquant].innerHTML = "&#10004;";
            } else {
                table.rows[i].cells[inuseforcompactquant].innerText = "";
            }

        }
    }

    InUseFor(); /* Fuck Google Chrome */

}

function C14CatalogueId() {
    console.log("C14CatalogueId");

    function marineCurve2Bused() {
        if (document.getElementById("marinecurve2bused").innerText == "t") {
            document.getElementById("marinecurve2bused").innerText = "~";
            document.getElementById("marinecurve2bused").classList.remove("hidden");
        }
    }

    function siteType() {
        switch (document.getElementById("sitetype").innerText) {
            case "coring":
                document.getElementById("sitetype-icon").src = "/w/resources/assets/sitetype_coring.png";
                break;
            case "excavation":
                document.getElementById("sitetype-icon").src = "/w/resources/assets/sitetype_excavation.png";
                break;
            default:
                document.getElementById("sitetype-icon").src = "/w/resources/assets/sitetype_unknown.png";
        }

    }

    /*
        function NAPMV() {
        }
    */

    function isPeatOnSand() {
        if (document.getElementById("ispeatonsand").innerText == "t") {
            document.getElementById("ispeatonsand").innerText = "Y";
        } else {
            document.getElementById("ispeatonsand").innerText = "N";
        }
    }

    function InUseFor() {
        console.log("DO NOT RUN!");
        var InUseForArray = ["InUseForChannelAge", "InUseForGWTinterpol", "InUseForMSLrise", "InUseForVegetationHistory", "InUseForLandSubsidence", "InUseForCompactQuant", "InUseForLDEM"];

        InUseForArray.forEach(function (element) {

            var el = document.getElementById(element);
            if (el.firstElementChild.innerText == "t") {
                switch (element) {
                    case "InUseForLDEM":
                        el.nextElementSibling.classList.remove("hidden");
                        break;
                    default:
                        el.previousElementSibling.firstElementChild.firstElementChild.classList.add("filled");
                        el.classList.add("in");
                        el.setAttribute("aria-expanded", true);
                        el.style.height = "auto";
                }

            }
        });

    }

    function releaseCandidateNotify() {
        if (document.getElementById("rc-releasecandidate").innerHTML == "true") {
            document.getElementById("releasecandidateAlertWarning").classList.remove("hidden");
        }

        var myArray = Array.from(document.getElementById("mws-properties").children);
        var myJSON = {};

        myArray.forEach(function (div, key, arr) {
            if (div.id === "rc-releasecandidate" ||
                div.id === "rc-id" ||
                div.id === "rc-name" ||
                div.id === "rc-abegin" ||
                div.id === "rc-abegincalbp" ||
                div.id === "rc-abeginadbc" ||
                div.id === "rc-aend" ||
                div.id === "rc-aendcalbp" ||
                div.id === "rc-aendadbc" ||
                div.id === "rc-abegindatingid" ||
                div.id === "rc-aenddatingid" ||
                div.id === "rc-remarkarcheology" ||
                div.id === "rc-remarkupdates"
            ) {
                return;
            } else {
                if ((div.innerText !== "") && (div.innerText.trim() != document.getElementById(div.id.split("-")[1]).innerText.trim())) {
                    myJSON[div.id.split("-")[1]] = document.getElementById(div.id.split("-")[1]).innerText.trim();
                }
            }
            if (Object.is(arr.length - 1, key)) {
                // execute last item logic
                // console.log(`Last callback call at index ${key} with value ${div}` );
                localStorage.setItem('C14CatalogueIdProperties', JSON.stringify(myJSON));
            }
        });

        // console.log(document.getElementById("releasecandidateAlertWarning").getElementsByTagName('a')[0]);
        document.getElementById("releasecandidateAlertWarning").getElementsByTagName('a')[0].onclick = function (e) {
            e.preventDefault();
            Object.keys(myJSON).forEach(function (div, key, arr) {
                document.getElementById(div).innerText = document.getElementById('rc-' + div).innerText;
                document.getElementById(div).style.backgroundColor = "#faf3ce";
                if (Object.is(arr.length - 1, key)) {
                    // execute last item logic
                    // console.log(`Last callback call at index ${key} with value ${div}`);
                    // idMentions("C14Catalogue");
                    id__cross_ref();
                    document.getElementById("releasecandidateAlertWarning").classList.add("hidden");
                    document.getElementById("releasecandidateAlertDanger").classList.remove("hidden");
                }
            });
        };

        // console.log(document.getElementById("releasecandidateAlertDanger").getElementsByTagName('a')[0]);
        document.getElementById("releasecandidateAlertDanger").getElementsByTagName('a')[0].onclick = function (e) {
            e.preventDefault();
            Object.keys(JSON.parse(localStorage.getItem('C14CatalogueIdProperties'))).forEach(function (div, key, arr) {
                document.getElementById(div).innerText = JSON.parse(localStorage.getItem('C14CatalogueIdProperties'))[div];
                document.getElementById(div).style.backgroundColor = "transparent";
                if (Object.is(arr.length - 1, key)) {
                    // execute last item logic
                    // console.log(`Last callback call at index ${key} with value ${div}`);
                    // idMentions("CBCatalogue");
                    id__cross_ref();
                    document.getElementById("releasecandidateAlertDanger").classList.add("hidden");
                    document.getElementById("releasecandidateAlertWarning").classList.remove("hidden");
                }
            });
        };
    }

    document.getElementById("editformlink").getElementsByTagName("form")[0].action = "/wiki/Special:FormEdit/C14CatalogueId_Create/RijnMaasDelta:C14Catalogue/"+location.href.substring(location.href.lastIndexOf('/') + 1);

    marineCurve2Bused();
    siteType();
    isPeatOnSand();
    // NAPMV();
    // InUseFor();
    releaseCandidateNotify();

}

function id__cross_ref() {

    var regexCB = /(\ \(#[0-9]*\))/gm;
    var regexC14 = /(\ \(Beta-[0-9]*\))|(\ \(GrN-[0-9]*\))|(\ \(GrA-[0-9]*\))|(\ \(Poz-[0-9]*\))|(\ \(UtC-[0-9]*\))/gm;

    function zeroPad(input, length) {
        return (Array(length + 1).join('0') + input).slice(-length);
    }

    var myArray = Array.from(document.getElementsByClassName('id--cross-ref'));

    myArray.forEach(function (elem) {
        elem.innerHTML = elem.innerHTML.replace(regexCB, function ($1) {
            var id = $1;
            var url = " <a href='/wiki/RijnMaasDelta:CBCatalogue/CB" + id.match(/\d+/g).map(Number) + "'>" + id.trim() + "</a>";
            return url;
        });

        elem.innerHTML = elem.innerHTML.replace(regexC14, function ($1) {
            var id = $1;
            var tmp = id.trim().substring(1, id.length - 2).split("-");

            if (tmp[1].length < 5) {
                tmp[1] = zeroPad(tmp[1], 5);
            }

            id = tmp.join("-");
            var url = " <a href='/wiki/RijnMaasDelta:C14Catalogue/" + id.trim() + "'>(" + id.trim() + ")</a>";
            return url;
        });
    });
}

/*
function idMentions(category) {
    console.log("idMentions: " + category);

    var regexCB = /(\ \(#[0-9]*\))/gm;
    var regexC14 = /(\ \(Beta-[0-9]*\))|(\ \(GrN-[0-9]*\))|(\ \(GrA-[0-9]*\))|(\ \(Poz-[0-9]*\))|(\ \(UtC-[0-9]*\))/gm;

    switch (category) {
        case "CBCatalogue":
            idMentionsCBCatalogue();
            break;
        case "CBGroup":
            idMentionsCBGroup();
            break;
    }

    function idMentionsCBCatalogue() {

        function zeroPad(input, length) {
            return (Array(length + 1).join('0') + input).slice(-length);
        }

        var abeginreasoningText = document.getElementById("abeginreasoning").innerHTML;
        var aendreasoningText = document.getElementById("aendreasoning").innerHTML;
        var archeologyfindperiodsText = document.getElementById("archeologyfindperiods").innerHTML;
        var remarkvariousText = document.getElementById("remarkvarious").innerHTML;

        abeginreasoningText = abeginreasoningText.replace(regexCB, function ($1) {
            var id = $1;
            var url = " <a href='/wiki/RijnMaasDelta:CBCatalogue/CB" + id.match(/\d+/g).map(Number) + "'>" + id.trim() + "</a>";
            return url;
        });

        abeginreasoningText = abeginreasoningText.replace(regexC14, function ($1) {
            var id = $1;
            var tmp = id.trim().substring(1, id.length - 2).split("-");

            if (tmp[1].length < 5) {
                tmp[1] = zeroPad(tmp[1], 5);
            }

            id = tmp.join("-");
            var url = " <a href='/wiki/RijnMaasDelta:C14Catalogue/" + id.trim() + "'>(" + id.trim() + ")</a>";
            return url;
        });

        aendreasoningText = aendreasoningText.replace(regexCB, function ($1) {
            var id = $1;
            var url = " <a href='/wiki/RijnMaasDelta:CBCatalogue/CB" + id.match(/\d+/g).map(Number) + "'>" + id.trim() + "</a>";
            return url;
        });

        aendreasoningText = aendreasoningText.replace(regexC14, function ($1) {
            var id = $1;
            var tmp = id.trim().substring(1, id.length - 2).split("-");

            if (tmp[1].length < 5) {
                tmp[1] = zeroPad(tmp[1], 5);
            }

            id = tmp.join("-");
            var url = " <a href='/wiki/RijnMaasDelta:C14Catalogue/" + id.trim() + "'>(" + id.trim() + ")</a>";
            return url;
        });

        archeologyfindperiodsText = archeologyfindperiodsText.replace(regexCB, function ($1) {
            var id = $1;
            var url = " <a href='/wiki/RijnMaasDelta:CBCatalogue/CB" + id.match(/\d+/g).map(Number) + "'>" + id.trim() + "</a>";
            return url;
        });

        archeologyfindperiodsText = archeologyfindperiodsText.replace(regexC14, function ($1) {
            var id = $1;
            var tmp = id.trim().substring(1, id.length - 2).split("-");

            if (tmp[1].length < 5) {
                tmp[1] = zeroPad(tmp[1], 5);
            }

            id = tmp.join("-");
            var url = " <a href='/wiki/RijnMaasDelta:C14Catalogue/" + id.trim() + "'>(" + id.trim() + ")</a>";
            return url;
        });

        remarkvariousText = remarkvariousText.replace(regexCB, function ($1) {
            var id = $1;
            var url = " <a href='/wiki/RijnMaasDelta:CBCatalogue/CB" + id.match(/\d+/g).map(Number) + "'>" + id.trim() + "</a>";
            return url;
        });

        remarkvariousText = remarkvariousText.replace(regexC14, function ($1) {
            var id = $1;
            var tmp = id.trim().substring(1, id.length - 2).split("-");

            if (tmp[1].length < 5) {
                tmp[1] = zeroPad(tmp[1], 5);
            }

            id = tmp.join("-");
            var url = " <a href='/wiki/RijnMaasDelta:C14Catalogue/" + id.trim() + "'>(" + id.trim() + ")</a>";
            return url;
        });

        document.getElementById("abeginreasoning").innerHTML = abeginreasoningText;
        document.getElementById("aendreasoning").innerHTML = aendreasoningText;
        document.getElementById("archeologyfindperiods").innerHTML = archeologyfindperiodsText;
        document.getElementById("remarkvarious").innerHTML = remarkvariousText;

    }

    function idMentionsCBGroup() {
        var membershipsText = document.getElementById("memberships").innerHTML;

        membershipsText = membershipsText.replace(regexCB, function ($1) {
            var id = $1;
            var url = " <a href='/wiki/RijnMaasDelta:CBCatalogue/CB" + id.match(/\d+/g).map(Number) + "'>" + id.trim() + "</a>";
            return url;
        });

        membershipsText = membershipsText.replace(regexC14, function ($1) {
            var id = $1;
            var url = " <a href='/wiki/RijnMaasDelta:C14Catalogue/" + id.trim().substring(1, id.length - 2) + "'>" + id.trim() + "</a>";
            return url;
        });

        document.getElementById("memberships").innerHTML = membershipsText;
    }
}
*/

function categoryId() {
    console.log("categoryId");
    switch(document.getElementById("page").innerHTML) {
        case "c14catalog":
            C14Catalogue();
            break;
    }
    /*
    if (document.getElementById("page").innerHTML === "c14catalog") {
        C14Catalogue();
    }
    if (window.location.href.endsWith("RijnMaasDelta:CBCatalogue") == 1) {
        CBCatalogue();
    }
    if (window.location.href.indexOf("RijnMaasDelta:CBCatalogue/") >= 0) {
        CBCatalogueId();
    }
    if (window.location.href.endsWith("RijnMaasDelta:C14Catalogue") == 1) {
        document.getElementById("submitForm").classList.remove("hidden");
        
    }
    if (window.location.href.indexOf("RijnMaasDelta:C14Catalogue/") >= 0) {
        C14CatalogueId();
    }
    */
}

// Wait for the page to be parsed
$(document).ready(function () {
    setTimeout(function () {
        categoryId();
    }, 1000);
});
