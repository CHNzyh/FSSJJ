<?php

namespace Admin\Model;
use Think\Model;

class SysDataModel extends Model
{
	static 	public $sqlFilesSize = 0;
	public $tableName = "admin";

	public function getAllTableName()
	{
		$tabs = M()->query("SHOW TABLE STATUS");
		$arr = array();

		foreach ($tabs as $tab ) {
			$arr[] = $tab["Name"];
		}

		unset($tabs);
		return $arr;
	}

	public function bakupTable($table_list)
	{
		M()->query("SET SQL_QUOTE_SHOW_CREATE = 1");
		$outPut = "";
		if (!is_array($table_list) || empty($table_list)) {
			return false;
		}

		foreach ($table_list as $table ) {
			$outPut .= "# 数据库表：$table 结构信息\n";
			$outPut .= "DROP TABLE IF EXISTS `$table`;\n";
			$tmp = M()->query("SHOW CREATE TABLE $table");
			$outPut .= $tmp[0]["Create Table"] . " ;\n\n";
		}

		return $outPut;
	}

	public function getSqlFilesList()
	{
		$list = array();
		$size = 0;
		$handle = opendir(DatabaseBackDir);

		while ($file = readdir($handle)) {
			if (preg_match("#\.sql$#i", $file)) {
				$fp = fopen(DatabaseBackDir . "/$file", "rb");
				$bakinfo = fread($fp, 2000);
				fclose($fp);
				$detail = explode("\n", $bakinfo);
				$bk = array();
				$bk["name"] = $file;
				$bk["url"] = substr($detail[2], 7);
				$bk["type"] = substr($detail[3], 8);
				$bk["description"] = substr($detail[4], 14);
				$bk["time"] = substr($detail[5], 8);
				$_size = filesize(DatabaseBackDir . "/$file");
				$bk["size"] = byteformat($_size);
				$size += $_size;
				$bk["pre"] = substr($file, 0, strrpos($file, "_"));
				$bk["num"] = substr($file, strrpos($file, "_") + 1, strrpos($file, ".") - 1 - strrpos($file, "_"));
				$mtime = filemtime(DatabaseBackDir . "/$file");
				$list[$mtime][$file] = $bk;
			}
		}

		closedir($handle);
		krsort($list);
		$newArr = array();

		foreach ($list as $k => $array ) {
			ksort($array);

			foreach ($array as $arr ) {
				$newArr[] = $arr;
			}
		}

		unset($list);
		return array("list" => $newArr, "size" => byteformat($size));
	}

	public function getZipFilesList()
	{
		$list = array();
		$size = 0;
		$handle = opendir(DatabaseBackDir . "Zip/");

		while ($file = readdir($handle)) {
			if (($file != ".") && ($file != "..")) {
				$tem = array();
				$tem["file"] = $file;
				$_size = filesize(DatabaseBackDir . "Zip/$file");
				$tem["size"] = byteformat($_size);
				$tem["time"] = date("Y-m-d H:i:s", filectime(DatabaseBackDir . "Zip/$file"));
				$size += $_size;
				$list[] = $tem;
			}
		}

		return array("list" => $list, "size" => byteformat($size));
	}

	public function zip($files, $filename, $outDir = WEB_CACHE_PATH, $path = DatabaseBackDir)
	{
		$zip = new \ZipArchive();
		makedir($outDir);
		$res = $zip->open($outDir . "\\" . $filename, \ZipArchive::CREATE);

		if ($res === TRUE) {
			foreach ($files as $file ) {
				$zip->addFile($path . $file, str_replace("/", "", $file));
			}

			$zip->close();
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	public function unzip($file, $outDir = DatabaseBackDir)
	{
		$zip = new \ZipArchive();

		if ($zip->open(DatabaseBackDir . "Zip/" . $file) !== TRUE) {
			return FALSE;
		}

		$zip->extractTo($outDir);
		$zip->close();
		return TRUE;
	}
}


?>
