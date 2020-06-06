<?php

main();
FileParser("");
GetFiles("");
FileImport("");

function main()
{
	$fileList = GetFiles([])
	PrintCurrentFunction(__FUNCTION__);
}

function FileParser($file)
{
	PrintCurrentFunction(__FUNCTION__);
}

function FileImport($filePathAndName)
{
	PrintCurrentFunction(__FUNCTION__);
}

function GetFiles($ArrayOfDataDirectories)
{
	$outputDirectoryList = array();	
	foreach($ArrayOfDataDirectories as $ary)
	{
	//array push array and 
		$fileList = scandir($ary);
		var_dump($fileList);

	}


	PrintCurrentFunction(__FUNCTION__);
}




function PrintCurrentFunction($funcName)
{
		echo $funcName . " working \n";

}



?>