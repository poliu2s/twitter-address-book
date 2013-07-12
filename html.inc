<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>I am an Address Book</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js">
    </script>

    <!-- Le styles -->
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 20px;
        padding-bottom: 40px;
      }

      /* Custom container */
      .container-narrow {
        margin: 0 auto;
        max-width: 700px;
      }
      .container-narrow > hr {
        margin: 30px 0;
      }

      /* Main marketing message and sign up button */
      .jumbotron {
        margin: 60px 0;
        text-align: center;
      }
      .jumbotron h1 {
        font-size: 72px;
        line-height: 1;
      }
      .jumbotron .btn {
        font-size: 21px;
        padding: 14px 24px;
      }

      /* Supporting marketing content */
      .marketing {
        margin: 60px 0;
      }
      .marketing p + h4 {
        margin-top: 28px;
      }
    </style>

    <script type="text/javascript">
    $(document).ready(
        function () {
            $('#error').hide()
        });
    </script>

    

    <link href="../assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="../assets/ico/favicon.png">
  </head>

  <body>
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-42419340-1', 'co.nf');
  ga('send', 'pageview');

  </script>  

    <div class="container-narrow">

      <div class="masthead">
        <ul class="nav nav-pills pull-right">
          <li class="active"><a href="#">Address Book</a></li>
          <li><a href="mailto:opl20@hotmail.com">Contact</a></li>
        </ul>
        <h3 class="muted">Po Liu</h3>
      </div>

      <hr>

      <div class="jumbotron">
        <h3>I am an address book...</h3>
        <p><img src="./images/duck.jpg" /></p>
        <h1>Hear me ROAR!</h1>
        <p class="lead">This is a simple web-based address book that can help store information about contacts and display the data so that you don't have to keep it in your head. If you are having issues try <a href='./clearsessions.php'>clearing your session</a>.</p>
        <?php print_r($sign_in_button); ?>
      </div>

      <?php
        
        if ($sign_in == 0) {
          if ($num_results == 0) {
            echo $no_friends_msg;
          } else {

            for($i = 0; $i < $num_results; $i++) {
              echo $entries[$i];
            }

          }
          
          // Basic error handling code for adding/editing entries
          echo '
            <div class="alert alert-error" id="error">
              <a class="close" data-dismiss="alert" onClick="$(\'#error\').hide();">×</a>
              <strong>Wow!</strong> Looks like you didn\'t fill in something right. Don\'t give up!
            </div>
          

          <script type=\'text/javascript\'>
            function validateEditForm(){
                
                if($("#edit_name_field").val() == \'\' || $("#edit_t_handle_field").val() == \'\' || $("#edit_phone_field").val() == \'\') {
                  $("#error").show();
                  return false;

                }else{
                  return true;

                }
            }
            function validateAddForm(){
                
                if($("#add_name_field").val() == \'\' || $("#add_t_handle_field").val() == \'\' || $("#add_phone_field").val() == \'\') {
                  $("#error").show();
                  return false;

                } 
                return true;
            }
          </script> ';
          echo $edit_entry;
          echo $add_entry;

        }
      ?>

      <hr>

      <div class="footer">
        <p>&copy; PoMart Inc. 2013. Build with PHP/MySQL with OAuth for Twitter's REST API v1.1 by Abraham Williams.</p>
      </div>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap-transition.js"></script>
    <script src="../assets/js/bootstrap-alert.js"></script>
    <script src="../assets/js/bootstrap-modal.js"></script>
    <script src="../assets/js/bootstrap-dropdown.js"></script>
    <script src="../assets/js/bootstrap-scrollspy.js"></script>
    <script src="../assets/js/bootstrap-tab.js"></script>
    <script src="../assets/js/bootstrap-tooltip.js"></script>
    <script src="../assets/js/bootstrap-popover.js"></script>
    <script src="../assets/js/bootstrap-button.js"></script>
    <script src="../assets/js/bootstrap-collapse.js"></script>
    <script src="../assets/js/bootstrap-carousel.js"></script>
    <script src="../assets/js/bootstrap-typeahead.js"></script>

  </body>
</html>
