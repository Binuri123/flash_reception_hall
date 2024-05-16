function printReport(divid) {
    var divToPrint = document.getElementById(divid);

    var newWin = window.open('', 'Print-Window');
    newWin.document.open();
    newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');
    newWin.document.close();
    setTimeout(function () {
        newWin.close();
    }, 10);
}


function exportReport(divId, title) {
  var doc = new jsPDF();
   doc.fromHTML('<html><head><title>'+title+'</title></head><body>' + document.getElementById(divId).innerHTML + '</body></html>');
   doc.save('div.pdf');
}