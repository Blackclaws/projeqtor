require({cache:{
'dijit/form/nls/sl/validate':function(){
define(
"dijit/form/nls/sl/validate", //begin v1.x content
({
	invalidMessage: "Vnesena vrednost ni veljavna.",
	missingMessage: "Ta vrednost je zahtevana.",
	rangeMessage: "Ta vrednost je izven območja."
})

//end v1.x content
);

},
'dojo/cldr/nls/sl/gregorian':function(){
define(
"dojo/cldr/nls/sl/gregorian", //begin v1.x content
{
	"field-dayperiod": "Čas dneva",
	"dayPeriods-format-wide-pm": "pop.",
	"field-minute": "Minuta",
	"eraNames": [
		"pred našim štetjem",
		"naše štetje"
	],
	"dateFormatItem-MMMEd": "E., d. MMM",
	"field-day-relative+-1": "Včeraj",
	"field-weekday": "Dan v tednu",
	"field-day-relative+-2": "Predvčerajšnjim",
	"field-day-relative+-3": "Pred tremi dnevi",
	"days-standAlone-wide": [
		"nedelja",
		"ponedeljek",
		"torek",
		"sreda",
		"četrtek",
		"petek",
		"sobota"
	],
	"months-standAlone-narrow": [
		"j",
		"f",
		"m",
		"a",
		"m",
		"j",
		"j",
		"a",
		"s",
		"o",
		"n",
		"d"
	],
	"field-era": "Doba",
	"field-hour": "Ura",
	"dayPeriods-format-wide-am": "dop.",
	"dateFormatItem-y": "y",
	"timeFormat-full": "HH:mm:ss zzzz",
	"months-standAlone-abbr": [
		"jan",
		"feb",
		"mar",
		"apr",
		"maj",
		"jun",
		"jul",
		"avg",
		"sep",
		"okt",
		"nov",
		"dec"
	],
	"dateFormatItem-Ed": "E., d.",
	"dateFormatItem-yMMM": "MMM y",
	"field-day-relative+0": "Danes",
	"field-day-relative+1": "Jutri",
	"days-standAlone-narrow": [
		"n",
		"p",
		"t",
		"s",
		"č",
		"p",
		"s"
	],
	"eraAbbr": [
		"pr. n. št.",
		"po Kr."
	],
	"field-day-relative+2": "Pojutrišnjem",
	"field-day-relative+3": "Čez tri dni",
	"dateFormatItem-yyyyMMMM": "MMMM y",
	"dateFormat-long": "dd. MMMM y",
	"timeFormat-medium": "HH:mm:ss",
	"field-zone": "Območje",
	"dateFormatItem-Hm": "HH:mm",
	"dateFormat-medium": "d. MMM yyyy",
	"dateFormatItem-Hms": "HH:mm:ss",
	"quarters-standAlone-wide": [
		"1. četrtletje",
		"2. četrtletje",
		"3. četrtletje",
		"4. četrtletje"
	],
	"dateFormatItem-ms": "mm:ss",
	"field-year": "Leto",
	"field-week": "Teden",
	"months-standAlone-wide": [
		"januar",
		"februar",
		"marec",
		"april",
		"maj",
		"junij",
		"julij",
		"avgust",
		"september",
		"oktober",
		"november",
		"december"
	],
	"dateFormatItem-MMMd": "d. MMM",
	"dateFormatItem-yyQ": "Q/yy",
	"timeFormat-long": "HH:mm:ss z",
	"months-format-abbr": [
		"jan.",
		"feb.",
		"mar.",
		"apr.",
		"maj",
		"jun.",
		"jul.",
		"avg.",
		"sep.",
		"okt.",
		"nov.",
		"dec."
	],
	"timeFormat-short": "HH:mm",
	"field-month": "Mesec",
	"quarters-format-abbr": [
		"Q1",
		"Q2",
		"Q3",
		"Q4"
	],
	"days-format-abbr": [
		"ned",
		"pon",
		"tor",
		"sre",
		"čet",
		"pet",
		"sob"
	],
	"dateFormatItem-mmss": "mm:ss",
	"days-format-narrow": [
		"n",
		"p",
		"t",
		"s",
		"č",
		"p",
		"s"
	],
	"field-second": "Sekunda",
	"field-day": "Dan",
	"dateFormatItem-MEd": "E., d. MM.",
	"months-format-narrow": [
		"j",
		"f",
		"m",
		"a",
		"m",
		"j",
		"j",
		"a",
		"s",
		"o",
		"n",
		"d"
	],
	"days-standAlone-abbr": [
		"ned",
		"pon",
		"tor",
		"sre",
		"čet",
		"pet",
		"sob"
	],
	"dateFormat-short": "d. MM. yy",
	"dateFormatItem-yyyyM": "M/yyyy",
	"dateFormatItem-yMMMEd": "E., d. MMM y",
	"dateFormat-full": "EEEE, dd. MMMM y",
	"dateFormatItem-Md": "d. M.",
	"dateFormatItem-yMEd": "E., d. M. y",
	"months-format-wide": [
		"januar",
		"februar",
		"marec",
		"april",
		"maj",
		"junij",
		"julij",
		"avgust",
		"september",
		"oktober",
		"november",
		"december"
	],
	"quarters-format-wide": [
		"1. četrtletje",
		"2. četrtletje",
		"3. četrtletje",
		"4. četrtletje"
	],
	"days-format-wide": [
		"nedelja",
		"ponedeljek",
		"torek",
		"sreda",
		"četrtek",
		"petek",
		"sobota"
	],
	"eraNarrow": [
		"pr. n. št.",
		"po Kr."
	]
}
//end v1.x content
);
},
'dijit/nls/sl/loading':function(){
define(
"dijit/nls/sl/loading", //begin v1.x content
({
	loadingState: "Nalaganje ...",
	errorState: "Oprostite, prišlo je do napake."
})
//end v1.x content
);

},
'dojo/nls/sl/colors':function(){
define(
"dojo/nls/sl/colors", //begin v1.x content
({
// local representation of all CSS3 named colors, companion to dojo.colors.  To be used where descriptive information
// is required for each color, such as a palette widget, and not for specifying color programatically.

//Note: due to the SVG 1.0 spec additions, some of these are alternate spellings for the same color e.g. gray vs. gray.
//TODO: should we be using unique rgb values as keys instead and avoid these duplicates, or rely on the caller to do the reverse mapping?
aliceblue: "alice blue modra",
antiquewhite: "antično bela",
aqua: "akva",
aquamarine: "akvamarin",
azure: "azurno modra",
beige: "bež",
bisque: "porcelanasta",
black: "črna",
blanchedalmond: "obledelo mandljeva",
blue: "modra",
blueviolet: "modro vijolična",
brown: "rjava",
burlywood: "peščeno sivo-rjava",
cadetblue: "kadetsko modra",
chartreuse: "chartreuse",
chocolate: "čokoladna",
coral: "koralna",
cornflowerblue: "plavičasto modra",
cornsilk: "koruzna",
crimson: "karminasta",
cyan: "cijan",
darkblue: "temno modra",
darkcyan: "temno cijan",
darkgoldenrod: "temna zlata rozga",
darkgray: "temno siva",
darkgreen: "temno zelena",
darkgrey: "temno siva", // same as darkgray
darkkhaki: "temno kaki",
darkmagenta: "temna magenta",
darkolivegreen: "temna olivno zelena",
darkorange: "temno oranžna",
darkorchid: "temno orhidejasta",
darkred: "temno rdeča",
darksalmon: "temno lososova",
darkseagreen: "temno morsko zelena",
darkslateblue: "temno skrilasto modra",
darkslategray: "temno skrilasto siva",
darkslategrey: "temno skrilasto siva", // same as darkslategray
darkturquoise: "temno turkizna",
darkviolet: "temno vijolična",
deeppink: "temno rožnata",
deepskyblue: "temno nebeško modra",
dimgray: "pepelnato siva",
dimgrey: "pepelnato siva", // same as dimgray
dodgerblue: "dodgersko modra",
firebrick: "opečnata",
floralwhite: "cvetno bela",
forestgreen: "gozdno zelena",
fuchsia: "fuksija",
gainsboro: "gainsboro",
ghostwhite: "senčnato bela",
gold: "zlata",
goldenrod: "zlata rozga",
gray: "siva",
green: "zelena",
greenyellow: "zeleno-rumena",
grey: "siva", // same as gray
honeydew: "medena rosa",
hotpink: "kričeče rožnata",
indianred: "indijansko rdeča",
indigo: "indigo",
ivory: "slonokoščena",
khaki: "kaki",
lavender: "sivka",
lavenderblush: "rožnato sivka",
lawngreen: "travniško zelena",
lemonchiffon: "limonast šifon",
lightblue: "svetlo modra",
lightcoral: "svetlo koralna",
lightcyan: "svetlo cijan",
lightgoldenrodyellow: "svetlo rumena zlata rozga",
lightgray: "svetlo siva",
lightgreen: "svetlo zelena",
lightgrey: "svetlo siva", // same as lightgray
lightpink: "svetlo rožnata",
lightsalmon: "svetlo lososova",
lightseagreen: "svetlo morsko zelena",
lightskyblue: "svetlo nebeško modra",
lightslategray: "svetlo skrilasto siva",
lightslategrey: "svetlo skrilasto siva", // same as lightslategray
lightsteelblue: "svetlo kovinsko modra",
lightyellow: "svetlo rumena",
lime: "limetasta",
limegreen: "apneno zelena",
linen: "lanena",
magenta: "magenta",
maroon: "kostanjeva",
mediumaquamarine: "srednji akvamarin",
mediumblue: "srednje modra",
mediumorchid: "srednje orhidejasta",
mediumpurple: "srednje škrlatna",
mediumseagreen: "srednje morsko zelena",
mediumslateblue: "srednje skrilasto modra",
mediumspringgreen: "srednje pomladno zelena",
mediumturquoise: "srednje turkizna",
mediumvioletred: "srednje vijolično rdeča",
midnightblue: "polnočno modra",
mintcream: "metina krema",
mistyrose: "megleno rožnata",
moccasin: "mokasinasta",
navajowhite: "navajo bela",
navy: "mornarska",
oldlace: "stara čipka",
olive: "olivna",
olivedrab: "umazano olivna",
orange: "oranžna",
orangered: "oranžno-rdeča",
orchid: "orhidejasta",
palegoldenrod: "bleda zlata rozga",
palegreen: "bledo zelena",
paleturquoise: "bledo turkizna",
palevioletred: "bledo vijolično-rdeča",
papayawhip: "papaja",
peachpuff: "breskova",
peru: "perujska",
pink: "rožnata",
plum: "slivova",
powderblue: "kobaltovo modra",
purple: "škrlatna",
red: "rdeča",
rosybrown: "rožnato rjava",
royalblue: "kraljevsko modra",
saddlebrown: "sedlasto rjava",
salmon: "lososova",
sandybrown: "peščeno rjava",
seagreen: "morsko zelena",
seashell: "morska lupina",
sienna: "sienna",
silver: "srebrna",
skyblue: "nebeško modra",
slateblue: "skrilasto modra",
slategray: "skrilasto siva",
slategrey: "skrilasto siva", // same as slategray
snow: "snežena",
springgreen: "pomladno zelena",
steelblue: "kovinsko modra",
tan: "rumeno-rjava",
teal: "modrozelena",
thistle: "osatna",
tomato: "paradižnikova",
transparent: "prosojno",
turquoise: "turkizna",
violet: "vijolična",
wheat: "pšenična",
white: "bela",
whitesmoke: "megleno bela",
yellow: "rumena",
yellowgreen: "rumeno-zelena"
})
//end v1.x content
);

},
'dojo/cldr/nls/sl/number':function(){
define(
"dojo/cldr/nls/sl/number", //begin v1.x content
{
	"group": ".",
	"percentSign": "%",
	"exponential": "e",
	"scientificFormat": "#E0",
	"percentFormat": "#,##0%",
	"list": ";",
	"infinity": "∞",
	"patternDigit": "#",
	"minusSign": "-",
	"decimal": ",",
	"nan": "NaN",
	"nativeZeroDigit": "0",
	"perMille": "‰",
	"decimalFormat": "#,##0.###",
	"currencyFormat": "#,##0.00 ¤",
	"plusSign": "+"
}
//end v1.x content
);
},
'dojox/form/nls/sl/PasswordValidator':function(){
define(
"dojox/form/nls/sl/PasswordValidator", //begin v1.x content
({
        nomatchMessage: "Gesli se ne ujemata.",
		badPasswordMessage: "Neveljavno geslo."
})

//end v1.x content
);
},
'dijit/form/nls/sl/ComboBox':function(){
define(
"dijit/form/nls/sl/ComboBox", //begin v1.x content
({
		previousMessage: "Prejšnje izbire",
		nextMessage: "Dodatne izbire"
})

//end v1.x content
);

},
'dijit/nls/sl/common':function(){
define(
"dijit/nls/sl/common", //begin v1.x content
({
	buttonOk: "V redu",
	buttonCancel: "Prekliči",
	buttonSave: "Shrani",
	itemClose: "Zapri"
})

//end v1.x content
);

}}});
define("dojo/nls/projectorDojo_sl", [], 1);
