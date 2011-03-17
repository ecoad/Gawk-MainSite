<?php
require_once("Application/Bootstrap.php");

$application->securityControl->isAllowed("Member Admin");

$application->doNotStorePage();

if (!isset($_POST["Action"])) {
	if (isset($_GET["Action"])) {
		$_POST["Action"] = $_GET["Action"];
	} else {
		exit;
	}
}

$response = "{success:false}";

switch($_REQUEST["Action"]) {
	case "LoadCurrentPrivileges":
		$memberControl = BaseFactory::getMemberControl();
		$securityGroupControl = BaseFactory::getSecurityGroupControl();
		if ($member = $memberControl->item($_POST["MemberId"])) {
			$memberSecurityGroupsControl = $member->getManyToManyControl("SecurityGroup");

			$securityGroups = $securityGroupControl->getResultsAsFieldArray("Id");
			$memberSecurityGroups = $memberSecurityGroupsControl->getResultsAsFieldArray("Id");
			$currentSecurityGroups = array_intersect($securityGroups, $memberSecurityGroups);

			$data = "data:[";
			foreach ($currentSecurityGroups as $currentSecurityGroup) {
				$securityGroup = $securityGroupControl->item($currentSecurityGroup);
				$data .= $securityGroup->toJson() . ",";
			}
			$data = substr($data, 0, -1) . "]";
			$response = "{success:true,{$data}}";
		}
		break;

	case "LoadAvailablePrivileges":
		$securityGroupControl = BaseFactory::getSecurityGroupControl();
		$securityGroups = $securityGroupControl->getResultsAsFieldArray("Id");
		$columnCount = $application->defaultValue($_REQUEST["Columns"], 2);
		$columnPointer = 0;
		$columnData = array_fill(0, $columnCount, "");
		$data = "data:[";
		$count = count($securityGroups);

		$columnLength = ceil($count / $columnCount);

		$counter = 0;
		foreach ($securityGroups as $securityGroup) {
			$availableSecurityGroup = $securityGroupControl->item($securityGroup);
			$columnData[$columnPointer][] = $availableSecurityGroup->toJson() . ",";
			if (++$counter >= $columnLength) {
				$columnPointer++;
				$counter = 0;
			}
		}
		for ($i = 0; $i < $columnLength; $i++) {
			foreach ($columnData as $columnArray) {
				if (isset($columnArray[$i])) {
					$data .= $columnArray[$i];
				}
			}
		}

		$data = substr($data, 0, -1) . "]";
		$response = "{success:true,{$data}}";
		break;

	case "AddPrivelage":
		$application->required($_POST["MemberId"]);
		$application->required($_POST["SecurityGroupId"]);

		$memberControl = BaseFactory::getMemberControl();

		if ($member = $memberControl->item($_POST["MemberId"])) {
			$member->addManyRelation("SecurityGroup", $_POST["SecurityGroupId"]);
			$response = "{success:true}";
		}
		break;

	case "RemovePrivelage":
		$application->required($_POST["MemberId"]);
		$application->required($_POST["SecurityGroupId"]);

		$memberControl = BaseFactory::getMemberControl();

		if ($member = $memberControl->item($_POST["MemberId"])) {
			$member->removeManyRelation("SecurityGroup", $_POST["SecurityGroupId"]);
			$response = "{success:true}";
		}
		break;
}
echo $response;