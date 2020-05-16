jQuery(document).ready(function () {
    $('ul#my-menu ul').each(function (index) {
        $(this).prev().addClass('collapsible').click(function () {
            if ($(this).next().css('display') == 'none') {
                $(this).next().slideDown(200, function () {
                    $(this).prev().removeClass('collapsed').addClass('expanded');
                });
            } else {
                $(this).next().slideUp(200, function () {
                    $(this).prev().removeClass('expanded').addClass('collapsed');
                    $(this).find('ul').each(function () {
                        $(this).hide().prev().removeClass('expanded').addClass('collapsed');
                    });
                });
            }
            return false;
        });
    });
});

function print_doc() {
    window.print();
}


function doMouseEvt() {
    var elm = document.getElementById("styler");
    var ram = 120;
    if (elm) {
        if (elm.style.height == ram + "px") {
            elm.style.height = 50 + "px";
        } else {
            elm.style.height = ram + "px";
        }
    }
}
window.setInterval("doMouseEvt();", 1000);

function CallPrint(strid, nameus, data) {
    var prtContent = document.getElementById(strid);
    var prtCSS = '<style type="text/css">body {color: #000; font-size: 14px;} .diagnostic {width: 810px; height: 700px; margin: 20px auto;} .diagrama {width: 480px; height: 480px; float: left;} .shifr {float: right; width: 200px; height: 50px; color: #fff; margin: 5px; padding: 13px 5px; text-align: center;} .a {background: #71BF44;} .b {background: #F0DFAC;} .c {background: #00AEEF;} .d {background: #FBB040;} .e {background: #B88BBF;} .j {background: #F6A8CA;} .z {background: #1C75BC;} .comentdiagramm {width: 200px; float: right;}</style>';
    var WinPrint = window.open('', '', 'left=50,top=50,width=800,height=640,toolbar=0,scrollbars=1,status=0');
    WinPrint.document.write('<head>');
    WinPrint.document.write(prtCSS);
    WinPrint.document.write('</head><h1 style="text-align: center; font-size: 16px;">Диаграмма оценки систем организма:<br>' + nameus + '<br>' + data + '</h1><div id="print" class="contentpane">');
    WinPrint.document.write(prtContent.innerHTML);
    WinPrint.document.write('</div>');
    WinPrint.document.write('<br><div style="font-size: 16px; padding: 10px; margin-top: 100px; width: 500px; float: left;">Чем ближе выделенный сектор находится к периферии круга, тем более выражены нарушения в секторе соответствующей системы организма</div>');
    WinPrint.document.close();
    WinPrint.focus();
    WinPrint.print();
    WinPrint.close();
    // prtContent.innerHTML = strOldOne;

}
function ChetPrintTablet(strid) {
    var prtContent = document.getElementById(strid);
    var prtCSS = '<style type="text/css">body {color: #000; font-size: 14px; font-family: "Roboto", sans-serif;} .recept_ogl1 {float: left; width: 100%; padding: 10px;} .content {width: 1200px; font-size: 20px; margin: 0 auto; padding: 10px 0 10px 0; overflow: hidden;} .tblet_chet {width: 1298px;	height: 40px; background: #eaeaea; border: solid 1px #999; overflow: hidden;} .tblet_chet_print {width: 1198px; height: 40px; background: #eaeaea; border: solid 1px #999; overflow: hidden;} .chet {float: left; padding: 3px; text-align: center; font-size: 14px; font-weight: 800; color: #333; text-shadow: 1px 1px 5px #999;} .tblet_chet1, .tblet_chet1>div {bottom: 0;} .tblet_chet1 {width: 1298px; height: 40px; overflow: hidden; border-right: solid 1px #ddd; border-bottom: solid 1px #ddd; border-left: solid 1px #ddd; display: table;} .tblet_chet1_print {width: 1198px; height: 40px; overflow: hidden; border-right: solid 1px #ddd; border-bottom: solid 1px #ddd; border-left: solid 1px #ddd; display: table;} .chet1 {float: left; padding: 3px; text-align: center; font-size: 14px; color: #333;} .chet_pp {width: 22px;} .chet_data {width: 262px;} .chet_data1_ {width: 80px;} .chet_data2_ {width: 91px;} .chet_operation {width: 78px;} .chet_oplata {width: 75px;} .chet_dolg {width: 105px;} .chet_ostatoc {width: 99px;} .chet_limit {width: 100px;} .chet_limit1_ {width: 77px;} .chet_bes {width: 133px;} .chet_delete {width: 93px;} .chet_ostatoc_print {width: 99px; font-size: 10px;} .chet_limit1_, .chet_ostatoc, .chet_dolg, .chet_oplata, .chet_operation, .chet_data2_, .chet_data1_, .chet_data, .chet_pp, .chet_limit, .chet_bes {border-right: 1px solid #666; height: 100%; font-size: 10px;} .chet_pp1 {width: 22px;} .chet_data1 {width: 262px;} .chet_data11_ {width: 80px;} .chet_data12_ {width: 91px;} .chet_operation1 {width: 78px;} .chet_oplata1 {width: 75px;} .chet_dolg1 {width: 105px;} .chet_ostatoc1 {width: 100px;} .chet_ostatoc12 {width: 99px;} .chet_ostatoc12_print {width: 99px;} .chet_limit1 {width: 131px;} .chet_limit11_ {width: 77px;} .chet_bes1 {width: 133px;} .chet_edit {border: none; height: 34px; margin: 0; overflow: hidden;} .chet_bes1, .chet_limit11_, .chet_limit1, .chet_ostatoc12, .chet_ostatoc1, .chet_dolg1, .chet_oplata1, .chet_operation1, .chet_data12_, .chet_data11_, .chet_data1, .chet_pp1 {border-right: 1px solid #ddd; display: table-cell;}</style>';
    var WinPrint = window.open('', '', 'left=50,top=50,width=800,height=640,toolbar=0,scrollbars=1,status=0');
    WinPrint.document.write('<head>');
    WinPrint.document.write(prtCSS);
    WinPrint.document.write('</head><div id="print" class="contentpane">');
    WinPrint.document.write(prtContent.innerHTML);
    WinPrint.document.write('</div>');
    WinPrint.document.close();
    WinPrint.focus();
    WinPrint.print();
    WinPrint.close();
    // prtContent.innerHTML = strOldOne;
}

function CallPrintTablet(strid) {
    var prtContent = document.getElementById(strid);
    var prtCSS = '<style type="text/css">body {color: #000; font-size: 14px; font-family: "Roboto", sans-serif;} .recept_ogl1 {float: left; width: 100%; padding: 10px;} .content {width: 1200px; font-size: 20px; margin: 0 auto; padding: 10px 0 10px 0; overflow: hidden;} .recept_ogl2 {overflow: hidden; float: left; width: 100%; border-top: 1px solid #999; border-bottom: 1px solid #999;} .date_table {width: 136px; float: left; min-height: 18px; text-align: center; border-bottom: 1px solid #eee; padding: 0;} .table_block2 {width: 100%; overflow: hidden;}</style>';
    var WinPrint = window.open('', '', 'left=50,top=50,width=800,height=640,toolbar=0,scrollbars=1,status=0');
    WinPrint.document.write('<head>');
    WinPrint.document.write(prtCSS);
    WinPrint.document.write('</head><div id="print" class="contentpane">');
    WinPrint.document.write(prtContent.innerHTML);
    WinPrint.document.write('</div>');
    WinPrint.document.close();
    WinPrint.focus();
    WinPrint.print();
    WinPrint.close();
    // prtContent.innerHTML = strOldOne;
}