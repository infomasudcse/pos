
  $(function () { 

     $('.details').click(function(){
      var targetId = $(this).attr('data-id');
      $('#details'+targetId).show();
    });

   $('#from_branch_id').change(function(){
         var selectedOption = $(this).children("option:selected").text();
         $('#from_branch_name').val(selectedOption);

   });
   $('#to_branch_id').change(function(){
      var selectedOption = $(this).children("option:selected").text();
         $('#to_branch_name').val(selectedOption);
   });

    $('#branchTable').DataTable({"ajax":'BranchController/getBranch'});
    $('#categoriesTable').DataTable({"ajax":'CategoryController/getCategory'});
    $('#employeesTable').DataTable({"ajax":'EmployeeController/getEmplopyee'});
    $('#subCategoriesTable').DataTable({"ajax":'SubCategoryController/getSubCategory'});
    $('#variationsTable').DataTable({"ajax":'VariationController/getVariation'});
    $('#variationsvalTable').DataTable({"ajax":'VariationvalController/getVariationval'});
    $('#itemTable').DataTable({"ajax":'ItemController/getItems'});
    $('#inventoriTable').DataTable({"ajax":'InventoryController/getInventory'});
    $('#expenseTypeTable').DataTable({"ajax":'ExpensetypeController/getExpenseType'});
    
    //load item suggestion
    $('#item-category').change(function(){    
        var selectedOption = $(this).children("option:selected").val();
        var actionUrl = $(this).attr('data-find-url');

        console.log(actionUrl);
        console.log(selectedOption);

         $.ajax({         
          url: actionUrl+'/'+selectedOption,
          cache: false          
          }).done(function( msg ) { $('#subcategory').html(msg);  });
    });
    //pad modal
    
     $('#padModal').on('show.bs.modal', function (event) {
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
     //report distribute input modal 
     $('#distributeModal').on('show.bs.modal', function (event) {
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
    //report inventory
    
    $('#inventoryToday').on('show.bs.modal', function (event) {
      var span = $(event.relatedTarget); // Button that triggered the modal
      var formAction = span.data('action'); // Extract info from data-* attributes
      var tokenFrom = span.data('tokenfrom');      
      var modal = $(this)
      $.ajax({         
          url: tokenFrom+"/",
          cache: false          
          }).done(function( msg ) { 
            modal.find('.modal-body #tok').val(msg);
            modal.find('#actionForm').attr('action',formAction);
           });      
    }); 


     $('#inventoryReportModal').on('show.bs.modal', function (event) {
      var span = $(event.relatedTarget); // Button that triggered the modal
      var formAction = span.data('action'); // Extract info from data-* attributes
      var tokenFrom = span.data('tokenfrom');      
      var modal = $(this)
      $.ajax({         
          url: tokenFrom+"/",
          cache: false          
          }).done(function( msg ) { 
            modal.find('.modal-body #tok').val(msg);
            modal.find('#actionForm').attr('action',formAction);

           });      
    }); 
    
    //load modal with sku
    $('#inventoryModal').on('show.bs.modal', function (event) {
      var span = $(event.relatedTarget); // Button that triggered the modal
      var skus = span.data('whatever'); // Extract info from data-* attributes
      var qtys = span.data('qty');
      var datainv = span.data('inv');
      var dataLocation = span.data('location');
      var tokeen = '';
      var modal = $(this)
      $.ajax({         
          url: dataLocation,
          cache: false          
          }).done(function( msg ) { 
            modal.find('.modal-body #tok').val( msg)
            modal.find('.modal-body #data_inv').val( datainv)
            modal.find('.modal-body #sku').val( skus)
            modal.find('.modal-body #quantity').val(qtys)

           });      
    });

    //load modal with branch to transfer
      $('#transferModal').on('show.bs.modal', function (event) {
      var span = $(event.relatedTarget); // Button that triggered the modal
      var origin_code = span.data('origin-code'); // Extract info from data-* attributes
      var origin_qty = span.data('origin-qty');
      var origin_inv_id = span.data('origin_inv_id');
      var origin_branch = span.data('origin-branch');
      var dataLocation = span.data('location');
      var tokeen = '';
      var modal = $(this)
      $.ajax({         
          url: dataLocation,
          cache: false          
          }).done(function( msg ) { 
            modal.find('.modal-body #ttok').val( msg)
            modal.find('.modal-body #data_origin_inv').val( origin_inv_id)
            modal.find('.modal-body #fb').val( origin_branch)
            modal.find('.modal-body #tsku').val(origin_code)
            modal.find('.modal-body #tquantity').val(origin_qty)

           });      
    });

$('#iteminput').focus();
$('#productsearch').focus();

//document ready end
  });

  


 function askConfirm(){
  var result = confirm("Want to Execute ?");
  if (result) { return true; }else{ return false; }
 }

//item suggestionon on inventory create
 $(document).on('keyup','#productsearch', function(){
    var query = $(this).val();   
    var actionUrl = $(this).attr('actionTo');   
    if(query.length>0){
      $('.error-div').html('');  
       $.ajax({
              type: "GET",
              url: actionUrl+"/"+query,          
              dataType: "JSON",
              success:function(resp){
              //console.log(resp);                         
                  if(resp!=''){
                      $('.list-group').html(resp);
                      $('#search_result').show();
                  }else{
                    $('.error-div').html('<div class="alert-danger"><-- Check!</div>');
                    $('#search_result').hide();
                  }
              }
            }); 
    }else{
      $('#search_result').hide();
    }   
});


 //select suggested item
  $(document).on('click','.suggested-item', function(){    
    var suggest_id = $(this).attr('data-id');
    var suggest_val = $(this).text();
    $('#product_id').val(suggest_id);
    $('#productsearch').val(suggest_val);
    $('.error-div').html('<div class="alert-success"><-- Ok </div>');
     $('#search_result').hide();
    
  });


  $(document).on('click','.no-suggestion-found .inventory-form',function(){  $('#search_result').hide(); });
  $(document).on('mouseleave','.list-group-flush',function(){$('#search_result').hide(); });

//sku suggestionon on inventory
 $(document).on('keyup','#searchSku', function(){
    var query = $(this).val();   
    var actionUrl = $(this).attr('actionTo');   
    if(query.length>2){       
       $.ajax({
              type: "GET",
              url: actionUrl+"/"+query,          
              dataType: "JSON",
              success:function(resp){
              //console.log(resp);                         
                  if(resp!=''){
                      $('.list-group').html(resp);
                      $('#search_result').show();
                  }else{                    
                    $('#search_result').hide();
                  }
              }
            }); 
    }else{
      $('#search_result').hide();
    }   
});
//click on suggested sku
  $(document).on('click','.suggested-sku', function(){    
    var suggest_id = $(this).attr('data-id');
    $.ajax({
            type: "GET",
            url: "InventoryController/getInventoryById/"+suggest_id,          
            dataType: "JSON",
            success:function(resp){
            //console.log(resp);                         
                if(resp!=''){
                    $('#tableBody').prepend(resp);
                    $('#search_result').hide();
                }else{                    
                  $('#search_result').hide();
                }
            }
        }); 
    $('#search_result').hide();
    
  });

  $(document).on('mouseleave','.searchDiv',function(){$('#search_result').hide(); });

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
 

