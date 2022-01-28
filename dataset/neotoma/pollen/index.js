'use strict';

import { default as ajaxMenu } from "/e107_plugins/ajaxModules/Components/Menu/ajaxMenus.js";
import { default as ajaxTable } from "/e107_plugins/ajaxModules/Components/Table/ajaxTables.js";

(function () {

    window["ajaxMenus"] = [];
    window["ajaxTables"] = [];

    document.addEventListener('DOMContentLoaded', () => {

        const menus = document.querySelectorAll('div[data-ajax="menu"]');
        menus.forEach((element, key) => {
            var menuOptions = {
                _menuCallback: {
                    functions: {}
                }
            }
            window["ajaxMenus"][key] = new ajaxMenu(element, key, menuOptions);
        })

        const tables = document.querySelectorAll('table[data-ajax="table"]');
		tables.forEach((element, key) => {
            var tableOptions = {
                parseResponse: function (response) {
                    const type = response.type;
                    const data = response.data[0];
                    const dataset = response.data[0].sites;
                    let uid = 0;
                    let coords = {};
                    Object.keys(dataset).forEach((key) => {
                        uid = this.getUID(dataset[key]);
                        coords = this.getLatLng(dataset[key]);
                        dataset[key].uid = uid;
                        dataset[key].longitude = coords.lng;
                        dataset[key].latitude = coords.lat;
                    })
                    const records = response.data[0].sites.length;
                    const totalrecords = response.data[0].sites.length;
                    return { type, data, dataset, records, totalrecords };
                },
                getUID: function (value) {
                    return Object.entries(value)[0][1];
                },
                getLatLng: function (value) {
                    let latitude, longitude;
                    switch(JSON.parse(value.geography).type) {
                        case "Point":
                            latitude = JSON.parse(value.geography).coordinates[1];
                            longitude = JSON.parse(value.geography).coordinates[0];
                            break;
                        // case "Polygon":
                        //     let coords = JSON.parse(value.geography).coordinates[0];
                        //     let bounds = L.latLngBounds();
                        //     coords.forEach((item) => {
                        //         bounds.extend(item);
                        //     })
                        //     latitude = bounds.getCenter().lng;
                        //     longitude = bounds.getCenter().lat;
                        //     break;
                    }
                    if (isNaN(latitude)) { latitude = 0 }
                    if (isNaN(longitude)) { longitude = 0 }
                    return { lat: latitude, lng: longitude };
                },
                _tableCallback: {
                    functions: {}
                }
            }
			window["ajaxTables"][key] = new ajaxTable(element, key, tableOptions);
		})

    });
    
})();