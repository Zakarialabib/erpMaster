(function ($) {
    "use strict";
    /*=================================
      JS Index Here
    ==================================*/
    /*
    01. Print and Download Button
    
    00. Right Click Disable
    00. Inspect Element Disable
    */
    /*=================================
      JS Index End
    ==================================*/

    /*----------- 01. Print and Download Button ----------*/
    $('#download_btn').on('click', function () {
      var downloadSection = $('#download_section');
      var cWidth = downloadSection.width();
      var cHeight = downloadSection.height();
      var topLeftMargin = 40;
      var pdfWidth = cWidth + topLeftMargin * 2;
      var pdfHeight = pdfWidth * 1.5 + topLeftMargin * 2;
      var canvasImageWidth = cWidth;
      var canvasImageHeight = cHeight;
      var totalPDFPages = Math.ceil(cHeight / pdfHeight) - 1;

      html2canvas(downloadSection[0], { allowTaint: true }).then(function (
        canvas
      ) {
        canvas.getContext('2d');
        var imgData = canvas.toDataURL('image/jpeg', 1.0);
        var pdf = new jsPDF('p', 'pt', [pdfWidth, pdfHeight]);
        pdf.addImage(
          imgData,
          'JPG',
          topLeftMargin,
          topLeftMargin,
          canvasImageWidth,
          canvasImageHeight
        );
        for (var i = 1; i <= totalPDFPages; i++) {
          pdf.addPage(pdfWidth, pdfHeight);
          pdf.addImage(
            imgData,
            'JPG',
            topLeftMargin,
            -(pdfHeight * i) + topLeftMargin * 0,
            canvasImageWidth,
            canvasImageHeight
          );
        }
        var pdfUrl = 'th-invoice.pdf';
        pdf.save(pdfUrl);
      });
    });

    // Print Html Document
    $('.print_btn').on('click', function (e) {
      window.print();
    });



    // Background Image
    if ($("[data-bg-src]").length > 0) {
      $("[data-bg-src]").each(function () {
          var src = $(this).attr("data-bg-src");
          $(this).css("background-image", "url(" + src + ")");
          $(this).removeAttr("data-bg-src").addClass("background-image");
      });
    }

    // /*----------- 00. Right Click Disable ----------*/
    //   window.addEventListener('contextmenu', function (e) {
    //     // do something here...
    //     e.preventDefault();
    //   }, false);

    // /*----------- 00. Inspect Element Disable ----------*/
    //   document.onkeydown = function (e) {
    //     if (event.keyCode == 123) {
    //       return false;
    //     }
    //     if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
    //       return false;
    //     }
    //     if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
    //       return false;
    //     }
    //     if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
    //       return false;
    //     }
    //     if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
    //       return false;
    //     }
    //   }
    
})(jQuery);