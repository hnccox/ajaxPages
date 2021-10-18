'use strict';

import { default as ajaxMenu } from "/e107_plugins/ajaxTemplates/beta/js/ajaxMenus.js";
import { default as ajaxTable } from "/e107_plugins/ajaxTemplates/beta/js/ajaxTables.js";

(function () {

    function riverSystemGroup(element) {
        var table = element;

        for (var i = 1; i < table.rows.length - 2; i++) {

            var columns = table.rows[i].cells;
            var riversystemgrp = columns[columns.length - 1].innerText;

            switch (riversystemgrp) {
                case "N/A":
                    columns[columns.length - 1].innerHTML = "Unlabeled";
                    break;
                case "Hol":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=Holocene_LocalRivers'>" + riversystemgrp + "</a>";
                    break;
                case "LG":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=LateGlacial_LocalRivers'>" + riversystemgrp + "</a>";
                    break;
                case "S":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=Schiedam_(Rhine)'>" + riversystemgrp + "</a>";
                    break;
                case "B":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=Benschop_(Rhine)'>" + riversystemgrp + "</a>";
                    break;
                case "G":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=Graaf_(Rhine)'>" + riversystemgrp + "</a>";
                    break;
                case "U":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=Utrecht_(Rhine)'>" + riversystemgrp + "</a>";
                    break;
                case "K":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=Krimpen_(Rhine)'>" + riversystemgrp + "</a>";
                    break;
                case "Ls":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=Liemers_(Rhine)'>" + riversystemgrp + "</a>";
                    break;
                case "E":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=Est_(Rhine)'>" + riversystemgrp + "</a>";
                    break;
                case "Ln":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=Linschoten_(Rhine)'>" + riversystemgrp + "</a>";
                    break;
                case "R":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=Ridderkerk_(Meuse)'>" + riversystemgrp + "</a>";
                    break;
                case "H":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=Heusden_(Meuse)'>" + riversystemgrp + "</a>";
                    break;
                case "M":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=Maas_(Meuse)'>" + riversystemgrp + "</a>";
                    break;
                case "LT":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=LatePleniglacial_RhineTerrace'>" + riversystemgrp + "</a>";
                    break;
                case "BA":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=Bolling-Allerod_RhineTerrace'>" + riversystemgrp + "</a>";
                    break;
                case "TX":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=YoungerDryas_RhineTerrace'>" + riversystemgrp + "</a>";
                    break;
                case "PB":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=Preboreal_incisive'>" + riversystemgrp + "</a>";
                    break;
                case "BO":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=Boreal_incisive'>" + riversystemgrp + "</a>";
                    break;
                case "AT":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=Atlantic_incisive'>" + riversystemgrp + "</a>";
                    break;
                case "SB":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=Subboreal_incisive'>" + riversystemgrp + "</a>";
                    break;
                case "SA":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=Subatlantic_incisive'>" + riversystemgrp + "</a>";
                    break;
                case "A45":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=EarlyMiddle_Pleniglacial_RhineTerrace'>" + riversystemgrp + "</a>";
                    break;
                case "B34":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=MiddlePleniglacial_RhineTerrace'>" + riversystemgrp + "</a>";
                    break;
                case "LPG":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=LatePleniglacial_LocalRivers'>" + riversystemgrp + "</a>";
                    break;
                case "MPG":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=EarlyMiddle_Pleniglacial_MeuseTerrace'>" + riversystemgrp + "</a>";
                    break;
                case "S6A1":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=SaalianWarthe_RhineTerrace'>" + riversystemgrp + "</a>";
                    break;
                case "B1":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=SaalianWarthe_MeuseTerrace'>" + riversystemgrp + "</a>";
                    break;
                case "S5":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=SaalianDrenthe_Terrace_(postPGM)'>" + riversystemgrp + "</a>";
                    break;
                case "S4":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=SaalianDrenthe_Terrace_(PGM)'>" + riversystemgrp + "</a>";
                    break;
                case "S3":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=SaalianDrenthe_Terrace_(prePGM)'>" + riversystemgrp + "</a>";
                    break;
                case "X":
                    columns[columns.length - 1].innerHTML = "<a href='cbgroup.php?cbgroup=Exceptions'>" + riversystemgrp + "</a>";
                    break;
            }
        }
    }

    window["ajaxMenus"] = [];
    window["ajaxTables"] = [];

    document.addEventListener('DOMContentLoaded', () => {

        const menus = document.querySelectorAll('div[data-ajax="menu"]');
        menus.forEach((element, key) => {
            var object = {
                _menuCallback: {
                    functions: {}
                }
            }
            window["ajaxMenus"][key] = new ajaxMenu(element, key, object);
        })

        const tables = document.querySelectorAll('table[data-ajax]');
		tables.forEach((element, key) => {
            var object = {
                _tableCallback: {
                    functions: {
                        riverSystemGroup
                    }
                }
            }
			window["ajaxTables"][key] = new ajaxTable(element, key, object);
		})

    });
    
})();