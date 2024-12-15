<?php
	require_once("Config.php");

	$inData = getRequestInfo();

	$conn = new mysqli(DB_HOSTNAME, DB_USER, DB_PASSWORD, DB_NAME);
	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		$stmt = $conn->prepare("UPDATE Contacts SET Name=?, Phone=?, Email=? WHERE ID=?");
		$stmt->bind_param("ssss", $inData["contactName"], $inData["contactPhone"], $inData["contactEmail"], $inData["contactId"]);
		$stmt->execute();
		$stmt->close();
		$conn->close();
		returnWithError("");
	}

	function getRequestInfo()
	{
		return json_decode(file_get_contents("php://input"), true);
	}

	function sendResultInfoAsJson( $obj )
	{
		header("Content-type: application/json");
		echo $obj;
	}

	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

?>
