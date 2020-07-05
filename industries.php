<?php

main();
//FileParser("");
//GetFiles("");
//FileImport("");

function main()
{
	$dataDirs = array();
	array_push($dataDirs, './industries');

	//var_dump($dataDirs);	
	$fileList = GetFiles($dataDirs);

	//print_r($fileList);
	$fileContents = GetFlattenedMDArray($fileList);

	CreateFileOutput($fileContents);

}

function CreateFileOutput($fileContents)
{
	$fileLength = (count($fileContents)-1);
	
	$fileOutput = "";


	for($i = 0; $i<$fileLength; $i++){
		$fileOutput = $fileOutput . "insert into industry(industry_name) VALUES" . " ('" . $fileContents[$i] . "');\n";
	}

	//echo $fileOutput;
	file_put_contents("outputScripts/industryInserts_".gmdate("Y-m-d H:i:s") . ".txt", $fileOutput);
	echo "File write done \n";

}

function GetFlattenedMDArray($fileList)
{
	$fileContents = array();
	foreach($fileList as &$aryElem)
	{
		$singleFileContents = FileImport($aryElem);

		foreach ($singleFileContents as &$fileAryElem) {
			array_push($fileContents, $fileAryElem);
		}
		unset($fileAryElem);

	}
	unset($aryElem);
	return $fileContents;
}

function FileParser($file)
{
	$firstPass = explode("\n", $file);
	$secondPass = array();
	foreach($firstPass as &$fp)
	{
		/*
		if (strpos($fp, 'ABRANCHES	19') !== false) {
		    echo 'ABRANCHES	19'."\n";
		}
		*/
		$explode = explode("\t", $fp);
		$passBack = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $explode[0]); 
		array_push($secondPass, str_replace("'", "", ucfirst(strtolower($passBack))));
		/*
		if (strpos($fp, 'ABRANCHES	19') !== false) {
		    echo $passBack."\n";
		}
		*/
	}
	unset($fp);

//	print_r($secondPass);

	return $secondPass;

	PrintCurrentFunction(__FUNCTION__);
}

//Get the data from the files on the list
function FileImport($filePathAndName)
{
	$myfile = fopen($filePathAndName, "r") or die("Unable to open file!");
	$newFile = fread($myfile,filesize($filePathAndName));
	fclose($myfile);

	//print_r($myfile);

	$fileAry = FileParser($newFile);


	return $fileAry;

	PrintCurrentFunction(__FUNCTION__);
}

//Get the full file path of the files in the data directories.
function GetFiles($ArrayOfDataDirectories)
{	

	$outputFileList = array();

	$fileList = scandir($ArrayOfDataDirectories[0]);

	foreach($fileList as &$files)
	{
		if($files != "." && $files != "..")
		{
			array_push($outputFileList, $ArrayOfDataDirectories[0] . "/" . $files);
		}
	}
	unset($files);

	//PrintCurrentFunction(__FUNCTION__);

	return $outputFileList;
}




function PrintCurrentFunction($funcName)
{
		echo $funcName . " working \n";
}



?>