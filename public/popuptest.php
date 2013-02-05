<?php 
$lang=$_GET["la"];
if (!isset($lang)) {$lang="en";}
include 'include/headhtml.php';
?>
<script>
jQuery(function($)
{
    $.ajax({
        type: 'GET',
        url: "http://ec2-54-243-169-92.compute-1.amazonaws.com/faq/popup.php",
        dataType: "html",
        cache: false,
        success: function(data, status) {
            $('.popup').empty().append(data);
            popupForm();
        }
    });
 
    function popupForm()
    {
        $('.popup form').ajaxForm(function(res) {
            $('.popup').empty().append(res);
            popupForm();
        });
    }
});
</script>
<body>
<div id="wrap">

<div id="top"></div>

<div id="content">

<div class="header">
<h1><a href="#">LPM: Local Package Manager</a></h1>
<h2>Want to install software without root?</h2>
</div>

<div class="breadcrumbs">
<?php include 'include/pan.php'; ?>
</div>

<div class="middle">
<h2>Home</h2>

<?php 
if ($lang == "en") {
  include 'include/engindex.php';
} else { 
  include 'include/japindex.php';
}
?>
</div> <!-- end of main text -->
		
<div class="right">
<h2>Navigation</h2>
		
<?php
  include 'include/menu.php'; 
?>
</div> <!-- end of navigation -->

<div id="clear"></div>

</div>

<div id="bottom"></div>

</div>

<div id="footer">
<?php include 'include/footerhtml.php'; ?>
</div>

</body>
</html>
