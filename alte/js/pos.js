$(function () { 


$('#iteminput').focus();

 $('.details').click(function(){
      var targetId = $(this).attr('data-id');
      $('#details'+targetId).toggle();
    });

//report input modal 
     $('#reportModal').on('show.bs.modal', function (event) {
      var span = $(event.relatedTarget); // Button that triggered the modal
      var formAction = span.data('action'); // Extract info from data-* attributes
      var tokenFrom = span.data('tokenfrom');
      var tokeen = '';
      var modal = $(this)
      $.ajax({         
          url: tokenFrom+"/",
          cache: false          
          }).done(function( msg ) { 
            modal.find('.modal-body #tok').val(msg);
            modal.find('#actionForm').attr('action',formAction);

           });      
    });
});


 function askConfirm(){
  var result = confirm("Want to Execute ?");
  if (result) { return true; }else{ return false; }
 }


function print_this(divarea) {
 var contents = $("#"+divarea).html();
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({ "position": "absolute", "top": "-1000000px" });
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html><head><title>POS</title>');
        frameDoc.document.write('</head><body>');
        frameDoc.document.write('<style>td{font-size:12px;} .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {padding:2px;} </style>');
       
       frameDoc.document.write(contents);
        frameDoc.document.write('</body></html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);
   

}

