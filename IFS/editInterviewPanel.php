<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Create Interview Panel</title>
<link rel="shortcut icon" type="image/x-icon" href="./images/favicon.ico"/>

<script src="sweetalert/dist/sweetalert.min.js"></script> 
<link rel="stylesheet" type="text/css" href="sweetalert/dist/sweetalert.css">

<script src="js/jquery.min.js"></script>
<script src="js/jquery.js"></script>
<script type="text/javascript" src="js/sortable.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
	.asideLeftIcons {
		margin-left: 9%;
		width: 70%;
		margin-bottom: 5%;
		text-align: left;
	}
	#createInterviewPanelAddMemberBtn {
	background-image: url(images/recruitmentSession/createNew.png);
	padding-top: 11px;
	padding-bottom: 15px;
	background-repeat: no-repeat;
	padding-left: 4%;
	width: 23%;
	background-color: #E9E1E1;
	margin-left: 9%;
	margin-bottom: 3%;
	-webkit-transition: all 0.3s ease;
	-o-transition: all 0.3s ease;
	transition: all 0.3s ease;
	}
	#createInterviewPanelDeleteMemberBtn {
		background-image: url(images/recruitmentSession/Delete.png);
		padding-top: 11px;
		padding-bottom: 15px;
		background-repeat: no-repeat;
		padding-left: 4%;
		width: 12%;
		background-color: #E9E1E1;
		margin-bottom: 3%;
		-webkit-transition: all 0.3s ease;
		-o-transition: all 0.3s ease;
		transition: all 0.3s ease;
	}
	#interviewPanelNameTable{
		margin-bottom: 3%;
		border-style: hidden;
		border-color: #E9E1E1;
		border-collapse: collapse;
		margin-top: 3%;
		text-align: left;
		padding-left: 2%;
		font-size: 1.2em;
	}
	.headingsNormal {
		margin-left: 9%;
		font-size: 1.2em;
	}
	#createInterviewPanelAddMemberBtn:hover {
		background-image: url(images/recruitmentSession/createNew2.png);
	}
	#createInterviewPanelDeleteMemberBtn:hover {
		background-image: url(images/recruitmentSession/Delete1.png);
	}
	.createNewPanelTextBox {
		width: 30%;
		font-family: "OpenSans Regular";
		font-size: 0.85em;
		padding-left: 1%;
		margin-left: 3%;
	}
</style>

<script src="js/editPanel.js"></script>

</head>

<?php
require_once("Sql.php");
require_once("GlobalVariables.php");
$s = new Sql();
$connect = $s->connectToDatabase($databaseName);
$data = mysqli_query($connect, "SELECT employee.EmpID, FirstName, LastName, email, TelNo FROM employee WHERE Designation=1 OR Designation=0");		

$panelID = "";
if(isset($_GET["pid"])){
	$panelID = $_GET["pid"];
}

$pName = mysqli_query($connect, "SELECT IntPanID,IntPanName,status FROM interviewpanel WHERE IntPanID=$panelID");
$pMembers = mysqli_query($connect, "SELECT IntPanID,EmpID FROM interviewpanelmemberdetails WHERE IntPanID=$panelID");

?>

<!-- panelID container -->
<input id="pnlid" type="hidden" value="<?php echo $panelID; ?>">

<body>
<div>
  <header>
    <aside class="asideRight">
      <form action="SearchInterface.php" method="get">
        <input name="Search" type="search" class="searchbox" ><img src="images/searchIcon.png" width="15" height="15" alt=""/>
        <a href="index.php" class="navHome"> Home</a>
        <a href="help.php" class="navHelp">Help </a>
      </form>
    </aside>
    <aside class="asideLeft"></aside> 
  </header>
  <aside class="asideLeftIcons">
	  <nav>
		<a href="interviewPanelHome.php" class="aBack">Back</a> 
		<a href="recruitmentSessionHelp.html" class="aHelp">Help</a>
	  </nav>
  </aside>
  
  <?php 
	$pnamerow = $pName->fetch_row();
  ?>
  
  <strong class="headingsNormal"> Default Interview Panel </strong>
  <?php if($pnamerow[2]=="default"){ ?>
	<input id="11" name="default" type="checkbox" checked>
  <?php }else{?>
	<input id="11" name="default" type="checkbox">
  <?php } ?>
  <br>
  <br>
  <strong class="headingsNormal">Interview Panel Name </strong>
  <input id="panelName" type="text" name="panelName" value="<?php echo $pnamerow[1]; ?>" class="createNewPanelTextBox" placeholder="New Panel">
  
  <table width="83%" border="1" align="center" class="sortable" id="tableCommon">
  <tbody>
    <tr>
	  <th width="3%" scope="col"></th>
      <th width="35%" scope="col">Name</th>
      <th width="35%" scope="col">email</th>
      <th width="30%" scope="col">Contact No</th>	  
    </tr>
	<?php 
	
	while($raw = $data->fetch_row()) { ?>
    <tr>
		<?php
		$flag=0;
			
		while($members = $pMembers->fetch_row()){
			if($members[1]==$raw[0]){
			?>
				<td class="tableData" name="checked" ><input name="empid" class="checked" type="checkbox" id=<?php echo $raw[0] ?> checked /></td>
		<?php $flag=1;break; } }
		mysqli_data_seek($pMembers,0);
		if($flag==0){ ?>
			<td class="tableData" name="checked" ><input name="empid" class="checked" type="checkbox" id=<?php echo $raw[0] ?> /></td>
		<?php } ?>
		<td class="tableData" name="name1" id = <?php echo $raw[0] ?> ><?php echo $raw[1]." ".$raw[2] ?></td>
		<td class="tableData" name="email1" id = <?php echo $raw[0] ?> ><?php echo $raw[3]?></td>
		<td class="tableData" name="contact1" id = <?php echo $raw[0] ?> ><?php echo $raw[4] ?></td>                	
	</tr>
	<?php } ?>
  </tbody>
</table>

  
  <input type="button" id="createInterviewPanelAddMemberBtn" value="Save Interview Panel">
  <a href="interviewPanelHome.php"><input type="button" id="createInterviewPanelDeleteMemberBtn" value="Cancel"></a>
<footer>Copyright 2015 &copy;</footer>

</div>
</body>
</html>
