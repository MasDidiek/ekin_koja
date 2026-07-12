<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>Sipuspa - Puskesmas Cakung</title>

	<link href="<?php echo base_url();?>assets/css/app.css" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	
	<style>
	  .badge-warning-light{
	      background:#fcf7ea;
	      color:#e0730d;
	  }
	  
	  .badge-success-light{
	      background:#eafaed;
	      color:#2aa23d;
	  }
	  
	  
	  .badge-danger-light{
	      background:#fbeeee;
	      color:#d74343;
	  }
	  
	  
	  .modal{
	      width:100%;
	      height:100%;
	      position:fixed;
	      background:rgba(0,0,0,0.5);
	      top:0;
	      display:none;
	      left:0;
	      z-index:999;
	  }
	  
	  .modal-dialog{
	       background-color: #FFF;
          color: #333;
          width:70%;
          margin:50px auto;
          padding:20px;
          max-height:600px;
          overflow:auto;
          
	  }

    .alert{
      padding: 10px ;
    }
	  
    .alert-success{
      background-color: #e5fbe8;
      color: #2aa23d;
    }
	  
	  #snackbar {
          visibility: hidden;
          min-width: 250px;
          margin-left: -125px;
          background-color: #FFF;
          color: #333;
          text-align: left;
          border-radius: 2px;
          padding: 16px;
          position: fixed;
          z-index: 1;
          right: 30px;
          top: 30px;
          font-size: 14px;
          box-shadow: 3px 0px 17px 0px rgba(168,168,168,0.75);
            -webkit-box-shadow: 3px 0px 17px 0px rgba(168,168,168,0.75);
            -moz-box-shadow: 3px 0px 17px 0px rgba(168,168,168,0.75);
            border-bottom:5px solid #439ed9;
     }
        
        #snackbar.show {
          visibility: visible;
          -webkit-animation: fadein 0.6s, fadeout 0.6s 2.5s;
          animation: fadein 0.6s, fadeout 0.6s 2.5s;
        }
        
        @-webkit-keyframes fadein {
          from {right: 0; opacity: 0;} 
          to {right: 30px; opacity: 1;}
        }
        
        @keyframes fadein {
          from {right: 0; opacity: 0;}
          to {right: 30px; opacity: 1;}
        }
        
        @-webkit-keyframes fadeout {
          from {right: 30px; opacity: 1;} 
          to {right: 0; opacity: 0;}
        }
        
        @keyframes fadeout {
          from {right: 30px; opacity: 1;}
          to {right: 0; opacity: 0;}
        }

	</style>
</head>