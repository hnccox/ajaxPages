export function exportDataAsXML(response) {
    console.log("exportDataAsXML");

    const obj = response;
    //const obj = self._overlayMaps[layer].parseResponse?.(response) || response;
    //const obj = this.parseResponse?.(response) || response;
    const data = obj.data;
    const dataset = obj.dataset;
    const records = obj?.records || 0;
    const totalrecords = obj?.totalrecords || 0;

    let dataObj = new Object();

    var el = {};
    el.dataset = {};

    el.dataset.url = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/server/API.php";
    el.dataset.db = "llg";
    el.dataset.table = "llg_nl_boreholedata"; // TODO: This should be a variable..
    el.dataset.columns = "startdepth,depth,texture,organicmatter,plantremains,color,oxired,gravelcontent,median,calcium,ferro,groundwater,sample,soillayer,stratigraphy,remarks";
    el.dataset.where = "borehole=':uid'";
    el.dataset.order_by = "startdepth";
    el.dataset.direction = "ASC";

    function asyncAJAX(prop) {

        return new Promise((resolve, reject) => {
            //let [k, v] = Object.entries(obj)[prop];
            var k = Object.keys(obj)[prop];
            var v = obj[Object.keys(obj)[prop]];
            var index = v[Object.keys(v)[0]];

            dataObj[k] = {};
            dataObj[k].boreholeheader = {};
            dataObj[k].boreholedata = {};

            dataObj[k].boreholeheader = v;

            el.dataset.where = "borehole='" + index + "'";

            let method = "GET";
            let sql = {
                "url": self._overlayMaps[layer]?.layerParams.url || null,
                "db": self._overlayMaps[layer]?.layerParams.db || null,
                "query": self._overlayMaps[layer]?.layerParams.query
                //"query": jsonSQL.query.replace(self._overlayMaps[layer]?.layerParams.query, [":xmin", ":xmax", ":ymin", ":ymax", ":lat", ":lng"], [xmin, xmax, ymin, ymax, lat, lng])
            }
            ajax(method, sql, (data) => {
                let obj = JSON.parse(data);
                if (obj.totalrecords == 0) { reject(); return; }
                delete obj.totalrecords;
                dataObj[k].boreholedata = obj;
                resolve(dataObj[k]);
            });
        })
    }

    const createJSON = new Promise((resolve, reject) => {

        const promises = [];
        for (const prop in dataset) {
            promises.push(asyncAJAX(prop));
        }

        Promise.all(promises)
            .then(obj => {
                resolve(obj)
            }, reason => {
                console.log(reason)
            }).catch(e => {
                console.log(e)
            });

    });

    createJSON.then(obj => {

        var XMLSchema = () => {
            const xhr = new XMLHttpRequest(),
                method = "GET",
                url = "https://wikiwfs.geo.uu.nl/views/dataset/LLG/XMLSchema/LLG2012DataSet.xsd";

            xhr.open(method, url, true);
            xhr.setRequestHeader('Content-Type', 'text/xml');
            xhr.overrideMimeType('application/xml');

            xhr.onreadystatechange = function () {
                if (this.readyState === XMLHttpRequest.DONE) {
                    if (this.status == 200) {
                        createXML(this.responseXML);
                    } else {
                        console.log(this.statusText)
                    }
                }
            }

            xhr.send(null);
        }

        var createXML = (schema) => {

            var namespaceURI,
                qualifiedNameStr,
                documentType;
            namespaceURI = "";
            qualifiedNameStr = "";
            documentType = null;

            var XMLDocument = document.implementation.createDocument(namespaceURI, qualifiedNameStr, documentType);
            var LLG2012Dataset = XMLDocument.createElement("LLG2012Dataset");
            LLG2012Dataset.appendChild(XMLDocument.createTextNode("\n"));
            LLG2012Dataset.setAttribute("xmlns", "http://tempuri.org/LLG2012DataSet.xsd");
            LLG2012Dataset.appendChild(XMLDocument.importNode(schema.documentElement, true));

            var BoreholeHeader = XMLDocument.createElement("BoreholeHeader");
            var Borehole = XMLDocument.createElement("Borehole");
            var Name = XMLDocument.createElement("Name");
            var DrillDate = XMLDocument.createElement("DrillDate");
            var Xco = XMLDocument.createElement("Xco");
            var Yco = XMLDocument.createElement("Yco");
            var CoordZone = XMLDocument.createElement("CoordZone");
            var Elevation = XMLDocument.createElement("Elevation");
            var DrillDepth = XMLDocument.createElement("DrillDepth");
            var Geom = XMLDocument.createElement("Geom");
            var Geol = XMLDocument.createElement("Geol");
            var Soil = XMLDocument.createElement("Soil");
            var Veget = XMLDocument.createElement("Veget");
            var GroundWaterStep = XMLDocument.createElement("GroundWaterStep");
            var ExtraRemarks = XMLDocument.createElement("ExtraRemarks");

            var BoreholeData = XMLDocument.createElement("BoreholeData");
            var Depth = XMLDocument.createElement("Depth");
            var StartDepth = XMLDocument.createElement("StartDepth");
            var Texture = XMLDocument.createElement("Texture");
            var OrganicMatter = XMLDocument.createElement("OrganicMatter");
            var PlantRemains = XMLDocument.createElement("PlantRemains");
            var Color = XMLDocument.createElement("Color");
            var OxiRed = XMLDocument.createElement("OxiRed");
            var GravelContent = XMLDocument.createElement("GravelContent");
            var Median = XMLDocument.createElement("Median");
            var Calcium = XMLDocument.createElement("Calcium");
            var Ferro = XMLDocument.createElement("Ferro");
            var GroundWater = XMLDocument.createElement("GroundWater");
            var Sample = XMLDocument.createElement("Sample");
            var SoilLayer = XMLDocument.createElement("SoilLayer");
            var Stratigraphy = XMLDocument.createElement("Stratigraphy");
            var Remarks = XMLDocument.createElement("Remarks");

            var GroupIdentity = XMLDocument.createElement("GroupIdentity");
            var Year = XMLDocument.createElement("Year");
            var Group = XMLDocument.createElement("Group");
            var Names = XMLDocument.createElement("Names");
            var LLGType = XMLDocument.createElement("LLGType");

            Object.keys(obj).forEach(key => {
                LLG2012Dataset.appendChild(XMLDocument.createTextNode("\n"))
                var BoreholeHeader = XMLDocument.createElement("BoreholeHeader")
                if (obj[key].boreholeheader.borehole) {
                    BoreholeHeader.appendChild(XMLDocument.createTextNode("\n\t"))
                    BoreholeHeader.appendChild(Borehole.cloneNode(true))
                    BoreholeHeader.lastElementChild.appendChild(XMLDocument.createTextNode(obj[key].boreholeheader.borehole))
                }
                if (obj[key].boreholeheader.name) {
                    BoreholeHeader.appendChild(XMLDocument.createTextNode("\n\t"))
                    BoreholeHeader.appendChild(Name.cloneNode(true))
                    BoreholeHeader.lastElementChild.appendChild(XMLDocument.createTextNode(obj[key].boreholeheader.name.substring(0, 20)))
                }
                if (obj[key].boreholeheader.drilldate) {
                    BoreholeHeader.appendChild(XMLDocument.createTextNode("\n\t"))
                    BoreholeHeader.appendChild(DrillDate.cloneNode(true))
                    BoreholeHeader.lastElementChild.appendChild(XMLDocument.createTextNode(obj[key].boreholeheader.drilldate))
                }
                if (obj[key].boreholeheader.xco) {
                    BoreholeHeader.appendChild(XMLDocument.createTextNode("\n\t"))
                    BoreholeHeader.appendChild(Xco.cloneNode(true))
                    BoreholeHeader.lastElementChild.appendChild(XMLDocument.createTextNode(obj[key].boreholeheader.xco))
                }
                if (obj[key].boreholeheader.yco) {
                    BoreholeHeader.appendChild(XMLDocument.createTextNode("\n\t"))
                    BoreholeHeader.appendChild(Yco.cloneNode(true))
                    BoreholeHeader.lastElementChild.appendChild(XMLDocument.createTextNode(obj[key].boreholeheader.yco))
                }
                if (obj[key].boreholeheader.coordzone) {
                    BoreholeHeader.appendChild(XMLDocument.createTextNode("\n\t"))
                    BoreholeHeader.appendChild(CoordZone.cloneNode(true))
                    BoreholeHeader.lastElementChild.appendChild(XMLDocument.createTextNode(obj[key].boreholeheader.coordzone))
                }
                if (obj[key].boreholeheader.elevation) {
                    BoreholeHeader.appendChild(XMLDocument.createTextNode("\n\t"))
                    BoreholeHeader.appendChild(Elevation.cloneNode(true))
                    BoreholeHeader.lastElementChild.appendChild(XMLDocument.createTextNode(obj[key].boreholeheader.elevation))
                }
                if (obj[key].boreholeheader.drilldepth) {
                    BoreholeHeader.appendChild(XMLDocument.createTextNode("\n\t"))
                    BoreholeHeader.appendChild(DrillDepth.cloneNode(true))
                    BoreholeHeader.lastElementChild.appendChild(XMLDocument.createTextNode(obj[key].boreholeheader.drilldepth))
                }
                if (obj[key].boreholeheader.geom) {
                    BoreholeHeader.appendChild(XMLDocument.createTextNode("\n\t"))
                    BoreholeHeader.appendChild(Geom.cloneNode(true))
                    BoreholeHeader.lastElementChild.appendChild(XMLDocument.createTextNode(obj[key].boreholeheader.geom))
                }
                if (obj[key].boreholeheader.geol) {
                    BoreholeHeader.appendChild(XMLDocument.createTextNode("\n\t"))
                    BoreholeHeader.appendChild(Geol.cloneNode(true))
                    BoreholeHeader.lastElementChild.appendChild(XMLDocument.createTextNode(obj[key].boreholeheader.geol))
                }
                if (obj[key].boreholeheader.soil) {
                    BoreholeHeader.appendChild(XMLDocument.createTextNode("\n\t"))
                    BoreholeHeader.appendChild(Soil.cloneNode(true))
                    BoreholeHeader.lastElementChild.appendChild(XMLDocument.createTextNode(obj[key].boreholeheader.soil))
                }
                if (obj[key].boreholeheader.veget) {
                    BoreholeHeader.appendChild(XMLDocument.createTextNode("\n\t"))
                    BoreholeHeader.appendChild(Veget.cloneNode(true))
                    BoreholeHeader.lastElementChild.appendChild(XMLDocument.createTextNode(obj[key].boreholeheader.veget))
                }
                if (obj[key].boreholeheader.groundwaterstep) {
                    BoreholeHeader.appendChild(XMLDocument.createTextNode("\n\t"))
                    BoreholeHeader.appendChild(GroundWaterStep.cloneNode(true))
                    BoreholeHeader.lastElementChild.appendChild(XMLDocument.createTextNode(obj[key].boreholeheader.groundwaterstep))
                }
                if (obj[key].boreholeheader.extraremarks) {
                    BoreholeHeader.appendChild(XMLDocument.createTextNode("\n\t"))
                    BoreholeHeader.appendChild(ExtraRemarks.cloneNode(true))
                    BoreholeHeader.lastElementChild.appendChild(XMLDocument.createTextNode(obj[key].boreholeheader.extraremarks))
                }

                Object.values(obj[key].boreholedata).forEach(value => {
                    BoreholeHeader.appendChild(XMLDocument.createTextNode("\n\t"));
                    var BoreholeData = XMLDocument.createElement("BoreholeData")
                    if (obj[key].boreholeheader.borehole) {
                        BoreholeData.appendChild(Borehole.cloneNode(true))
                        BoreholeData.lastElementChild.appendChild(XMLDocument.createTextNode(obj[key].boreholeheader.borehole))
                    }
                    if (value.depth) {
                        BoreholeData.appendChild(Depth.cloneNode(true))
                        BoreholeData.lastElementChild.appendChild(XMLDocument.createTextNode(value.depth))
                        BoreholeData.appendChild(StartDepth.cloneNode(true))
                        BoreholeData.lastElementChild.appendChild(XMLDocument.createTextNode(value.startdepth))
                    }
                    if (value.texture) {
                        BoreholeData.appendChild(Texture.cloneNode(true))
                        BoreholeData.lastElementChild.appendChild(XMLDocument.createTextNode(value.texture))
                    }
                    if (value.organicmatter) {
                        BoreholeData.appendChild(OrganicMatter.cloneNode(true))
                        BoreholeData.lastElementChild.appendChild(XMLDocument.createTextNode(value.organicmatter))
                    }
                    if (value.plantremains) {
                        BoreholeData.appendChild(PlantRemains.cloneNode(true))
                        BoreholeData.lastElementChild.appendChild(XMLDocument.createTextNode(value.plantremains))
                    }
                    if (value.color) {
                        BoreholeData.appendChild(Color.cloneNode(true))
                        BoreholeData.lastElementChild.appendChild(XMLDocument.createTextNode(value.color))
                    }
                    if (value.oxired) {
                        BoreholeData.appendChild(OxiRed.cloneNode(true))
                        BoreholeData.lastElementChild.appendChild(XMLDocument.createTextNode(value.oxired))
                    }
                    if (value.gravelcontent) {
                        BoreholeData.appendChild(GravelContent.cloneNode(true))
                        BoreholeData.lastElementChild.appendChild(XMLDocument.createTextNode(value.gravelcontent))
                    }
                    if (value.median) {
                        BoreholeData.appendChild(Median.cloneNode(true))
                        BoreholeData.lastElementChild.appendChild(XMLDocument.createTextNode(value.median))
                    }
                    if (value.calcium) {
                        BoreholeData.appendChild(Calcium.cloneNode(true))
                        BoreholeData.lastElementChild.appendChild(XMLDocument.createTextNode(value.calcium))
                    }
                    if (value.ferro) {
                        BoreholeData.appendChild(Ferro.cloneNode(true))
                        BoreholeData.lastElementChild.appendChild(XMLDocument.createTextNode(value.ferro))
                    }
                    if (value.groundwater) {
                        BoreholeData.appendChild(GroundWater.cloneNode(true))
                        BoreholeData.lastElementChild.appendChild(XMLDocument.createTextNode(value.groundwater))
                    }
                    if (value.sample) {
                        BoreholeData.appendChild(Sample.cloneNode(true))
                        BoreholeData.lastElementChild.appendChild(XMLDocument.createTextNode(value.sample))
                    }
                    if (value.soillayer) {
                        BoreholeData.appendChild(SoilLayer.cloneNode(true))
                        BoreholeData.lastElementChild.appendChild(XMLDocument.createTextNode(value.soillayer))
                    }
                    if (value.stratigraphy) {
                        BoreholeData.appendChild(Stratigraphy.cloneNode(true))
                        BoreholeData.lastElementChild.appendChild(XMLDocument.createTextNode(value.stratigraphy))
                    }
                    if (value.remarks) {
                        BoreholeData.appendChild(Remarks.cloneNode(true))
                        BoreholeData.lastElementChild.appendChild(XMLDocument.createTextNode(value.remarks))
                    }
                    BoreholeHeader.appendChild(BoreholeData.cloneNode(true))

                })

                BoreholeHeader.appendChild(XMLDocument.createTextNode("\n"))
                LLG2012Dataset.appendChild(BoreholeHeader.cloneNode(true))

            });

            var llgtype = 0;
            // switch (ajaxTables[1].element.dataset.table) {
            //     case "llg_nl_boreholedata":
            //         llgtype = "0";
            //         break;
            //     case "llg_it_boreholedata":
            //         llgtype = "2";
            //         break;
            //     default: llgtype = "0";
            // }
            GroupIdentity.appendChild(XMLDocument.createTextNode("\n\t"))
            GroupIdentity.appendChild(Year)
            GroupIdentity.lastElementChild.appendChild(XMLDocument.createTextNode("9999"))
            GroupIdentity.appendChild(XMLDocument.createTextNode("\n\t"))
            GroupIdentity.appendChild(Group)
            GroupIdentity.lastElementChild.appendChild(XMLDocument.createTextNode("99"))
            GroupIdentity.appendChild(XMLDocument.createTextNode("\n\t"))
            GroupIdentity.appendChild(Names)
            GroupIdentity.lastElementChild.appendChild(XMLDocument.createTextNode("collection"))
            GroupIdentity.appendChild(XMLDocument.createTextNode("\n\t"))
            GroupIdentity.appendChild(LLGType)
            GroupIdentity.lastElementChild.appendChild(XMLDocument.createTextNode(llgtype))
            GroupIdentity.appendChild(XMLDocument.createTextNode("\n"))

            LLG2012Dataset.appendChild(XMLDocument.createTextNode("\n"))
            LLG2012Dataset.appendChild(GroupIdentity)
            LLG2012Dataset.appendChild(XMLDocument.createTextNode("\n"))
            XMLDocument.appendChild(LLG2012Dataset)

            let file = new File(['<?xml version="1.0" standalone="yes"?>' + "\n" + (new XMLSerializer()).serializeToString(XMLDocument)], { type: 'text/xml' });
            let url = URL.createObjectURL(file);
            let elem = window.document.createElement('a');
            elem.href = url;
            // elem.download = "LLGData-" + document.getElementById("mapinfo_bounds_sw").innerHTML.replace(", ", "_") + "-" + document.getElementById("mapinfo_bounds_ne").innerHTML.replace(", ", "_") + ".xml";
            elem.download = "LLGDATA.xml";
            document.body.appendChild(elem);
            elem.click();
            document.body.removeChild(elem);
            URL.revokeObjectURL(url); //Releases the resources
        }

        XMLSchema();

    }, reason => {
        console.log(reason)
    }).catch(e => {
        console.error(e)
    });

}