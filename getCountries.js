const fs = require('fs');
const axios = require('axios');

const COUNTRY_CODES = {
    "AO": {
        "iso2Code": "AO",
        "name": "Angola",
        "capitalCity": "Luanda",
        "longitude": 13.242,
        "latitude": -8.81155
    },
    "BF": {
        "iso2Code": "BF",
        "name": "Burkina Faso",
        "capitalCity": "Ouagadougou",
        "longitude": -1.53395,
        "latitude": 12.3605
    },
    "BI": {
        "iso2Code": "BI",
        "name": "Burundi",
        "capitalCity": "Bujumbura",
        "longitude": 29.3639,
        "latitude": -3.3784
    },
    "BJ": {
        "iso2Code": "BJ",
        "name": "Benin",
        "capitalCity": "Porto-Novo",
        "longitude": 2.6323,
        "latitude": 6.4779
    },
    "BW": {
        "iso2Code": "BW",
        "name": "Botswana",
        "capitalCity": "Gaborone",
        "longitude": 25.9201,
        "latitude": -24.6544
    },
    "CD": {
        "iso2Code": "CD",
        "name": "Congo, Dem. Rep.",
        "capitalCity": "Kinshasa",
        "longitude": 15.3222,
        "latitude": -4.325
    },
    "CF": {
        "iso2Code": "CF",
        "name": "Central African Republic",
        "capitalCity": "Bangui",
        "longitude": 21.6407,
        "latitude": 5.63056
    },
    "CG": {
        "iso2Code": "CG",
        "name": "Congo, Rep.",
        "capitalCity": "Brazzaville",
        "longitude": 15.2662,
        "latitude": -4.2767
    },
    "CI": {
        "iso2Code": "CI",
        "name": "Cote d\'Ivoire",
        "capitalCity": "Yamoussoukro",
        "longitude": -4.0305,
        "latitude": 5.332
    },
    "CM": {
        "iso2Code": "CM",
        "name": "Cameroon",
        "capitalCity": "Yaounde",
        "longitude": 11.5174,
        "latitude": 3.8721
    },
    "DJ": {
        "iso2Code": "DJ",
        "name": "Djibouti",
        "capitalCity": "Djibouti",
        "longitude": 43.1425,
        "latitude": 11.5806
    },
    "DZ": {
        "iso2Code": "DZ",
        "name": "Algeria",
        "capitalCity": "Algiers",
        "longitude": 3.05097,
        "latitude": 36.7397
    },
    "EG": {
        "iso2Code": "EG",
        "name": "Egypt, Arab Rep.",
        "capitalCity": "Cairo",
        "longitude": 31.2461,
        "latitude": 30.0982
    },
    "ER": {
        "iso2Code": "ER",
        "name": "Eritrea",
        "capitalCity": "Asmara",
        "longitude": 38.9183,
        "latitude": 15.3315
    },
    "ET": {
        "iso2Code": "ET",
        "name": "Ethiopia",
        "capitalCity": "Addis Ababa",
        "longitude": 38.7468,
        "latitude": 9.02274
    },
    "GA": {
        "iso2Code": "GA",
        "name": "Gabon",
        "capitalCity": "Libreville",
        "longitude": 9.45162,
        "latitude": 0.38832
    },
    "GH": {
        "iso2Code": "GH",
        "name": "Ghana",
        "capitalCity": "Accra",
        "longitude": -0.20795,
        "latitude": 5.57045
    },
    "GM": {
        "iso2Code": "GM",
        "name": "Gambia",
        "capitalCity": "Banjul",
        "longitude": -16.5885,
        "latitude": 13.4495
    },
    "GN": {
        "iso2Code": "GN",
        "name": "Guinea",
        "capitalCity": "Conakry",
        "longitude": -13.7,
        "latitude": 9.51667
    },
    "GQ": {
        "iso2Code": "GQ",
        "name": "Equatorial Guinea",
        "capitalCity": "Malabo",
        "longitude": 8.7741,
        "latitude": 3.7523
    },
    "GW": {
        "iso2Code": "GW",
        "name": "Guinea-Bissau",
        "capitalCity": "Bissau",
        "longitude": -15.1804,
        "latitude": 11.8037
    },
    "KE": {
        "iso2Code": "KE",
        "name": "Kenya",
        "capitalCity": "Nairobi",
        "longitude": 36.8126,
        "latitude": -1.27975
    },
    "LR": {
        "iso2Code": "LR",
        "name": "Liberia",
        "capitalCity": "Monrovia",
        "longitude": -10.7957,
        "latitude": 6.30039
    },
    "LS": {
        "iso2Code": "LS",
        "name": "Lesotho",
        "capitalCity": "Maseru",
        "longitude": 27.7167,
        "latitude": -29.5208
    },
    "LY": {
        "iso2Code": "LY",
        "name": "Libya",
        "capitalCity": "Tripoli",
        "longitude": 13.1072,
        "latitude": 32.8578
    },
    "MA": {
        "iso2Code": "MA",
        "name": "Morocco",
        "capitalCity": "Rabat",
        "longitude": -6.8704,
        "latitude": 33.9905
    },
    "MG": {
        "iso2Code": "MG",
        "name": "Madagascar",
        "capitalCity": "Antananarivo",
        "longitude": 45.7167,
        "latitude": -20.4667
    },
    "ML": {
        "iso2Code": "ML",
        "name": "Mali",
        "capitalCity": "Bamako",
        "longitude": -7.50034,
        "latitude": 13.5667
    },
    "MR": {
        "iso2Code": "MR",
        "name": "Mauritania",
        "capitalCity": "Nouakchott",
        "longitude": -15.9824,
        "latitude": 18.2367
    },
    "MW": {
        "iso2Code": "MW",
        "name": "Malawi",
        "capitalCity": "Lilongwe",
        "longitude": 33.7703,
        "latitude": -13.9899
    },
    "MZ": {
        "iso2Code": "MZ",
        "name": "Mozambique",
        "capitalCity": "Maputo",
        "longitude": 32.5713,
        "latitude": -25.9664
    },
    "NA": {
        "iso2Code": "NA",
        "name": "Namibia",
        "capitalCity": "Windhoek",
        "longitude": 17.0931,
        "latitude": -22.5648
    },
    "NE": {
        "iso2Code": "NE",
        "name": "Niger",
        "capitalCity": "Niamey",
        "longitude": 2.1073,
        "latitude": 13.514
    },
    "NG": {
        "iso2Code": "NG",
        "name": "Nigeria",
        "capitalCity": "Abuja",
        "longitude": 7.48906,
        "latitude": 9.05804
    },
    "RW": {
        "iso2Code": "RW",
        "name": "Rwanda",
        "capitalCity": "Kigali",
        "longitude": 30.0587,
        "latitude": -1.95325
    },
    "SD": {
        "iso2Code": "SD",
        "name": "Sudan",
        "capitalCity": "Khartoum",
        "longitude": 32.5363,
        "latitude": 15.5932
    },
    "SL": {
        "iso2Code": "SL",
        "name": "Sierra Leone",
        "capitalCity": "Freetown",
        "longitude": -13.2134,
        "latitude": 8.4821
    },
    "SN": {
        "iso2Code": "SN",
        "name": "Senegal",
        "capitalCity": "Dakar",
        "longitude": -17.4734,
        "latitude": 14.7247
    },
    "SO": {
        "iso2Code": "SO",
        "name": "Somalia",
        "capitalCity": "Mogadishu",
        "longitude": 45.3254,
        "latitude": 2.07515
    },
    "SS": {
        "iso2Code": "SS",
        "name": "South Sudan",
        "capitalCity": "Juba",
        "longitude": 31.6,
        "latitude": 4.85
    },
    "SZ": {
        "iso2Code": "SZ",
        "name": "Eswatini",
        "capitalCity": "Mbabane",
        "longitude": 31.4659,
        "latitude": -26.5225
    },
    "TD": {
        "iso2Code": "TD",
        "name": "Chad",
        "capitalCity": "N'Djamena",
        "longitude": 15.0445,
        "latitude": 12.1048
    },
    "TG": {
        "iso2Code": "TG",
        "name": "Togo",
        "capitalCity": "Lome",
        "longitude": 1.2255,
        "latitude": 6.1228
    },
    "TN": {
        "iso2Code": "TN",
        "name": "Tunisia",
        "capitalCity": "Tunis",
        "longitude": 10.21,
        "latitude": 36.7899
    },
    "TZ": {
        "iso2Code": "TZ",
        "name": "Tanzania",
        "capitalCity": "Dodoma",
        "longitude": 35.7382,
        "latitude": -6.17486
    },
    "UG": {
        "iso2Code": "UG",
        "name": "Uganda",
        "capitalCity": "Kampala",
        "longitude": 32.5729,
        "latitude": 0.314269
    },
    "ZA": {
        "iso2Code": "ZA",
        "name": "South Africa",
        "capitalCity": "Pretoria",
        "longitude": 28.1871,
        "latitude": -25.746
    },
    "ZM": {
        "iso2Code": "ZM",
        "name": "Zambia",
        "capitalCity": "Lusaka",
        "longitude": 28.2937,
        "latitude": -15.3982
    },
    "ZW": {
        "iso2Code": "ZW",
        "name": "Zimbabwe",
        "capitalCity": "Harare",
        "longitude": 31.0672,
        "latitude": -17.8312
    },
    "EH": {
        "iso2Code": "EH",
        "name": "Western Sahara"
    }
};

const FILE_PATH = 'resources/js/modules/africanCountries.js';


const forEachCountry = async (handler) => {
    for (let i = 0; i < COUNTRY_CODES.length; ++i) {
        try {
            const info = await getCountryInfo(COUNTRY_CODES[i]);
            handler(info);
        } catch (err) {
            console.error(`There is an error here for ${COUNTRY_CODES[i].id}`, err);
        }
    }
};

const getCountries = async () => {
    return JSON.stringify(COUNTRY_CODES, null, '\t');
};

const getCountryNames = async () => {
    const countries = [];

    Object.keys(COUNTRY_CODES).forEach(key => {
        countries.push(COUNTRY_CODES[key].name);
    });

    return JSON.stringify(countries, null, '\t');
};

const generateAfricanCountriesJS = async (json) => {
    const text = `/**
 * This file is autogenerated by getCountries.js. DO NOT modify directly.
 */
import { Map } from "immutable";

const countries = ${json};

export default Map(countries);
`;

    fs.writeFileSync(FILE_PATH, text);
    console.log(`Done: Written data to ${FILE_PATH}`);
}

if (process.argv.length === 2) {
    console.error('expected output format parameter');
    process.exit(1);
}

const format = process.argv[2];

if (format === "names") {
    getCountryNames()
        .then((json) => process.stdout.write(json));

} else if (format === "js") {
    getCountries()
        .then(generateAfricanCountriesJS);
}
