<?php
session_start();
$sid = session_id();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset=utf-8 />
	<title>Client Side Pagination</title>
	<link rel="stylesheet" type="text/css" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="./css/font-awesome.css" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<script   src="https://code.jquery.com/jquery-2.2.4.js"   integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="   crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script src="./plugin/jquery.twbsPagination.js"></script>
	
	
	<!--[if IE]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<style>
       		
	.thumbnail img {
           width: 30%;
		}

        
	</style>
</head>
<body>
<!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Start Bootstrap</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">About</a>
                    </li>
                    <li>
                        <a href="#">Services</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-md-3">
                <p class="lead">Shop Name</p>
                <div class="list-group" id="categoryList">
               <!--     <a href="#" class="list-group-item active">Category 1</a>
                    <a href="#" class="list-group-item">Category 2</a>
                    <a href="#" class="list-group-item">Category 3</a> -->
                </div>
            </div>

            <div class="col-md-9">

                <div class="row carousel-holder">

                    <div class="col-md-12">
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="item active">
                                    <img class="slide-image" src="http://frostbytelan.se/wp-content/uploads/2015/05/csgoBildTillHemsida800x300.jpg" alt="">
                                </div>
                                <div class="item">
                                    <img class="slide-image" src="http://g03.a.alicdn.com/kf/HTB1gqc1JFXXXXawXXXXq6xXFXXXW/110751673/HTB1gqc1JFXXXXawXXXXq6xXFXXXW.jpg" alt="">
                                </div>
                                <div class="item">
                                    <img class="slide-image" src="https://rimblogs.files.wordpress.com/2014/08/prereg-passport-black.png?w=800&h=300" alt="">
                                </div>
                            </div>
                            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </div>
                    </div>

                </div>

                <div class="row" id="products">

 
                </div>
				
            </div>

        </div>

    </div>
    <!-- /.container -->

    <div class="container">

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
            </div>
        </footer>
    </div>
	
	<div class="col-xs-14 col-sm-10"><center>
      <ul id="pagination-demo" class="pagination-sm"></ul>
      </center>
  <div class="col-xs-2 col-sm-1"></div>
</div>
	
    <!-- /.container -->



 
<script>

(function($) {
    //http://esimakin.github.io/twbs-pagination/
	
	var myWait;
    myWait = myWait || (function () {
        var waitDiv = $('<div class="modal" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false"><div class="progress"> <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:98%"> LOADING... </div></div></div>');
        return {
            show: function() {
                waitDiv.modal();
            },
            hide: function () {
                waitDiv.modal('hide');
            },

        };
    })();


    myWait.show();

    // Set up some variables for our pagination
    var page = 1;
    var page_size = 12;
    var total_records = 0;
    var total_pages = 0;
    var rows = "";
    var col_head = "";
	
	
	$.get("https://pro-developer.xyz/api/api.php/categories?order=name")
	.done(function(data) {
        
            // Pull the products out of our json object 
            var rows = data.categories.records;
			
			for (var i = 0; i < rows.length; i++) {
				var $category = String(rows[i][1]).trim();				
				var categories = '<a href="#" class="list-group-item">'+$category+'<a>';
				$('#categoryList').append(categories);
			}
			
			$('.list-group-item').click(function(){
					$(this).toggleClass("active");
                    $this = $(this); 
                    console.log($this.text());                    
                    $('#products').empty();
                    loadProductData(page,12,$this.text());
		
                });
	
			
			
			
	});



   
    function loadProductData(page, page_size,category) {
	
		// var category = typeof category !== 'undefined' ?  ","+category : 0;
    
        myWait.show();                
		
		if(category)
			var url = "https://pro-developer.xyz/api/api.php/products?page=" + page + "," + page_size + "&filter=category,eq," + category + "&order=id";
		else
			var url = "https://pro-developer.xyz/api/api.php/products?page=" + page + "," + page_size + "&order=id";
	
			console.log(url);
        $.get(url)
		// The '.done' method fires when the get request completes
        .done(function(data) {
        

            // Pull the products out of our json object 
            var records = data.products.records;

            // Start an empty html string
            for (var i = 0; i < records.length; i++) {
				var item = {};
                //Start a new row for each product and put the product id in a data-element
				item.id = records[i][0];

                // Loop through each item for a product and append a table data tag to our row
                for (var j = 1; j < records[i].length; j++) {
                
                    if(j == 1){
						item.category = records[i][j] ;
					}else if(j == 2){
						item.description = records[i][j] ;
					}else if(j == 3){
						item.price = records[i][j] ;
					}else{
                        var result = records[i][j] .split(' ');
                        var img = result[0].replace("~","100");
                        item.image = "<img width=\"100\" src="+img+">";
                    }
                }
				console.log(item);
				addProductItem(item);
            }

            $('tbody').html(rows);
            
            myWait.hide();
			
		
            $('.fa-shopping-cart').click(function(){
                console.log($(this).closest('tr').data( "id" ));
                
				var item = [];
                $(this).closest('tr').find('td').each(function(){
					console.log($(this).text());
					item.push($(this).html());
				});
				console.log(item);
				addCartItem(item);
            })
    

        });
		
		$('.list-group-item').hover(function () {
		$(this).toggleClass("active");
		});
	
		
    }
	
	function addProductItem(item){
		
		var words = item.description.split(" ");
		var name = words[0]+' '+words[1];
		var desc = item.description.substring(0,40) + '...';
		
		var itemHtml = '';
		itemHtml += '<div class="col-sm-4 col-lg-4 col-md-4">'+
		'	<div class="thumbnail" id='+item.id+'>'+
		'		'+item.image +
		'		<div class="caption">'+
		'			<h4 class="pull-right">$'+item.price+'</h4>'+
		'			<h4><a href="#">'+name+'</a>'+
		'			</h4>'+
		'			<p>'+desc+'</p>'+
		'		</div>'+
		'		<div class="ratings">'+
		'			<p class="pull-right">12 reviews</p>'+
		'			<p>'+
		'				<span class="glyphicon glyphicon-star"></span>'+
		'				<span class="glyphicon glyphicon-star"></span>'+
		'				<span class="glyphicon glyphicon-star"></span>'+
		'				<span class="glyphicon glyphicon-star"></span>'+
		'				<span class="glyphicon glyphicon-star-empty"></span>'+
		'			</p>'+
		'		</div>'+
		'	</div>'+
		'</div>';
		
		$('#products').append(itemHtml);
		
		$('#'+item.id+'').click(function(event){
           
            $this = $(this);
            var url = 'https://pro-developer.xyz/api/api.php/products?filter=id,eq,'+item.id+'&order=id';
           
            event.preventDefault()
			console.log(url);
        $.get(url)
        .done(function(data) {
          
        var records = data.products.records;
        	
            item.id = records[0][0];
            
             var result = records[0][4] .split(' ');
             var img = result[0].replace("~","100");
             item.image = "<img width=\"100\" src="+img+">";
            console.log(item.id);
        var itemHtml = '';
		itemHtml +=  '<div align="bottom" class="col-md-9">'+
                '<div class="thumbnail">'+
                 item.image+
                  '  <div class="caption-full">'+
                   '     <h4 class="pull-right">'+item.price+'</h4>'+
                    '    <h4><a href="#">Product Name</a>'+
                     '   </h4>'+
                    '</div>'+
                    '<p> '+item.description+''+
					'</p>'+
                '</div>'+
				'</div>';
                console.log(item.price);
				console.log(item.image);
		
		$('#products').empty();
		$('#products').append(itemHtml);
        });
       
        });
	}
	
	
	
	
	
	$('#updateCart').click(function(){
		var cartTotal=0;
		$('.cart-item').each(function(){
			var $price=parseFloat($(this).find('.price').text().replace("$", ""));
			var $count=parseInt($(this).find('.count').val());
			cartTotal += parseFloat($price*$count);
			console.log(cartTotal);
		});
		$('#cart-total').text(cartTotal);
		
	});
	
	function updatePrice(){
		var cartTotal=0;
		$('.cart-item').each(function(){
			var $price=parseFloat($(this).find('.price').text().replace("$", ""));
			var $count=parseInt($(this).find('.count').val());
			cartTotal += parseFloat($price*$count);
			console.log(cartTotal);
		});
		$('#cart-total').text(cartTotal);
		
	}
	
    function getTotalPages(){
        $.get("https://pro-developer.xyz/api/api.php/products")

        // The '.done' method fires when the get request completes
        .done(function(data) {

            total_records = data.products.records.length;
            total_pages = parseInt(total_records / page_size);
            loadProductData(1, 12);
            $('#pagination-demo').twbsPagination({
                totalPages: total_pages,
                visiblePages: 10,
                onPageClick: function (event, page) {
                    $('#page-content').text('Page ' + page);
					$('#products').empty();
                    loadProductData(page,12);
                }
            });
			
        });
    }
    
	function addCartItem(item){
		
		var row=''+
		'<div class="rowdelete cart-item">'+
		'<div class="row" id="item-'+item[0]+'">'+
			'<div class="col-xs-2">'+ item[4] +
			'</div>'+
			'<div class="col-xs-3">'+
			'	<h4 class="product-name"><strong>'+item[1]+'</strong></h4>'+
			'</div>'+
			'<div class="col-xs-7">'+
			'	<div class="col-xs-4 text-right">'+
			'		<h6><strong><span class="price">$'+item[3]+'</span><span class="text-muted" style="padding-left: 8px;"> x </span></strong></h6>'+
			'	</div>'+
			'	<div class="col-xs-5" >'+
			'		<input type="textbox" class="form-control input-sm count"  value="1">'+
			'	</div>'+
			'	<div class="col-xs-2">'+
			'		<button type="button" class="btnDelete btn btn-link btn-xs">'+
			'			<span class="glyphicon glyphicon-trash"> </span>'+
			'		</button>'+
			'	</div>'+
			'</div>'+
		'</div>'+
		'<hr>'+
		'</div>';
		
		var postData = {};
		postData['uid']=guid;
		postData['pid']=item[0];
		postData['count']=1;
		postData['description']=item[1];
		postData['price']=item[3];
		postData['time-added']=Math.floor(Date.now() / 1000);
		
		console.log(postData);
		
		var cartTotal = parseFloat($('#cart-total').text());
		var cartPrice= parseFloat(item[3]);
		console.log(cartPrice);								
		if(isNaN(cartTotal))
			cartTotal = 0;
       
		cartTotal += parseFloat(item[3]);
		console.log(cartTotal);
		
		$('#cart-body').append(row);
		$('.btnDelete').click(function()
		{
		console.log('deleteCLICKED');
		$this = $(this);
		var column = $this.closest('.rowdelete');
		column.remove();
		updatePrice();		
		});		
		$('#cart-total').text(cartTotal)
		$.post("http://mwsu-webdev.xyz/api/api.php/shopping_cart/",postData);		

	}	

 
    
	 function guid() {
	  function s4() {
		return Math.floor((1 + Math.random()) * 0x10000)
		  .toString(16)
		  .substring(1);
	  }
	  return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
		s4() + '-' + s4() + s4() + s4();
	}
	
	
	
    getTotalPages();
	
  
}(jQuery));
</script>
</body>
</html>
