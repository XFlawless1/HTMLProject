<?php
session_start();
//error_reporting(0);
session_regenerate_id(true);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{
header('location:index.php');
}
$sql = "SELECT * from  users ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{
}
$salary=$result->income;
?>
<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">

	<title>Tax Calculation</title>

	<!-- Font awesome -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Sandstone Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Bootstrap Datatables -->
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<!-- Bootstrap select -->
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<!-- Bootstrap file input -->
	<link rel="stylesheet" href="css/fileinput.min.css">
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<!-- Admin Stye -->
	<link rel="stylesheet" href="css/style.css">
  <style>

	.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
	background: #dd3d36;
	color:#fff;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
	background: #5cb85c;
	color:#fff;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}

		</style>

</head>
<body>
  <?php include('includes/header.php');?>
  <div class="ts-main-content">
  <?php include('includes/leftbar.php');?>
    <div class="content-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-12">
                <div class="panel panel-default">
                  <div class="panel-heading">Tax Calculation for <b><?php echo htmlentities($result->name); ?></b></div>
<div class="panel-body">
  <img src="images/<?php echo htmlentities($result->image);?>" style="width:100px; border-radius:50%; margin:10px;">
  <p><b>Name: <?php echo htmlentities($result->name);?></b>
  <p><b>PAN Number: <?php echo htmlentities($result->panno);?></b>
  <p><b>Income: <?php echo htmlentities($result->income);?></b>
    <?php
    function getTax($salary)
    {
    $band1_top=250000;
    $band2_top=500000;
    $band3_top=1000000;
    $band1_rate=0;
    $band2_rate=0.05+0.2;
    $band3_rate=10000+0.2;
    $band4_rate=112000+0.3;
    $band1 = $band2 = $band3 = $band4 = 0;
    $starting_income = $income;
    if($income > $band3_top) {
        $band4 = ($income - $band3_top) * $band4_rate;
        $income = $band3_top;
    }

    if($income > $band2_top) {
        $band3 = ($income - $band2_top) * $band3_rate;
        $income = $band2_top;
    }

    if($income > $band1_top) {
        $band2 = ($income - $band1_top) * $band2_rate;
        $income = $band1_top;
    }
    $band1 = $income * $band1_rate;
    $total_tax_paid = $band1 + $band2 + $band3 + $band4;
    $sql = "UPDATE `users` SET `taxtbp` = taxtbp=(:taxtbp)";
    $query = $dbh->prepare($sql);
    $query-> bindParam(':taxtbp', $taxtbp, PDO::PARAM_STR);
    $query->execute();
    echo "Tax paid on $income is $total_tax_paid";
    }
    ?>
</div>
<div class="faq-table">
							<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
								<tbody>
									<tr>
										<b><th class="faq-table-title">Male/Female</th></b>
										<th></th>
									</tr>
									<tr>
										<b><td class="faq-table-title">Income</td></b>
										<b><td class="faq-table-title">Tax Rate</td></b>
									</tr>
										<tr><td>Upto Rs. 2,50,000</td>
										<td>Nil.</td>
									</tr><tr>
										<td>Rs. 2,50,001 to Rs. 5,00,000</td>
										<td>5%</td>
									</tr>
									<tr>
										<td>Rs. 5,00,001 to Rs. 10,00,000 </td>
										<td>Rs. 12,500 + 20% of Income exceeding Rs. 500,000.</td>
									</tr>
									<tr>
										<td>Above Rs. 10,00,000 </td>
										<td>Rs. 1,12,500 + 30%  of Income exceeding of Rs 10,00,000.</td>
									</tr>
									<!-- <tr>
										<td></td>
										<td></td>
									</tr> -->
									<tr>
										<b><td class="faq-table-title">Senior citizen</td></b>
										<td></td>
									</tr>
									<!-- <tr>
										<td></td>
										<td></td>
									</tr> -->
									<tr>
										<b><td class="faq-table-title">Income</td></b>
										<b><td class="faq-table-title">Tax Rate</td></b>
									</tr>
									<tr>
										<td>Upto Rs.3,00,000 </td>
										<td>Nil.</td>
									</tr>
									<tr>
										<td>Rs. 3,00,001 to Rs. 5,00,000</td>
										<td>5%</td>
									</tr>
									<tr>
										<td>Rs. 5,00,001 to Rs. 10,00,000 </td>
										<td>Rs.10,000 + 20% of Income exceeding Rs. 500,000.</td>
									</tr><tr>
										<td>Above Rs. 10,00,000 </td>
										<td>Rs. 1,10,000 + 30%  of Income exceeding of Rs 10,00,000.</td>
									</tr>
									<!-- <tr>
										<td></td>
										<td></td>
									</tr> -->
									<tr>
										<b><td class="faq-table-title">Very senior citizen</td></b>
										<td></td>
									</tr>
									<!-- <tr>
										<td></td>
										<td></td>
									</tr> -->
									<tr>
										<b><td class="faq-table-title">Income </td></b>
										<b><td class="faq-table-title">Tax Rate </td></b>
									</tr>
									<tr>
										<td>Upto Rs. 5,00,000 </td>
										<td>Nil.</td>
									</tr>
									<tr>
										<td>Rs. 5,00,001 to Rs. 10,00,000 </td>
										<td>20%</td>
									</tr>
									<tr>
										<td>Above Rs. 10,00,000 </td>
										<td>Rs. 1,00,000 + 30%  of Income exceeding of Rs 10,00,000.</td>
									</tr>
									<!-- <tr>
										<td></td>
										<td></td>
									</tr> -->
								</tbody>
							</table>
						</div>
  <!-- Loading Scripts -->
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap-select.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.dataTables.min.js"></script>
  <script src="js/dataTables.bootstrap.min.js"></script>
  <script src="js/Chart.min.js"></script>
  <script src="js/fileinput.js"></script>
  <script src="js/chartData.js"></script>
  <script src="js/main.js"></script>
  <script type="text/javascript">
         $(document).ready(function () {
          setTimeout(function() {
            $('.succWrap').slideUp("slow");
          }, 3000);
          });
    </script>
</body>
</html>
<?php } ?>
