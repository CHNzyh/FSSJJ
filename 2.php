<?php
$FileAddress='';

$DownloadName='文件下载到客户端的名字。';

if(file_exists($FileAddress) && $file=fopen($FileAddress,”r”)) //首先要判断文件是否存在，如果文件跟本不存在的话，后边的代码也是白费。
{
Header(“content-type:application/octet-stream”); //声明文件类型，这里是为了让客户端下载它，而不是打开它，所以声明为未知二进制文件。否则客户端会根据其文件类型在线打开它。
Header(“content-Length:”.filesize($FileAddress)); //声明文件的大小，告诉客户端这个文件的大小，否则客户端下载的时候看不到进度。
Header(“content-disposition:attachment;filename=”.$DownloadName); //声明文件名，这里就是告诉客户端它要下载的文件的名字，否则名字就会是你php文件的名字。
echo fread($file,filesize($FileAddress)); //这里就是将加载的文件echo出来，因此这个php文件不能出现其他任何的文字，就是说这里若是出现了任何其他的输出的话都会输出到客户端下载的文件里。
fclose($file); //最后关闭句柄。
}
?>