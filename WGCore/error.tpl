<!DOCTYPE HTML>
<html>
<head>
<title>Runtime Error | 运行时错误</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<span style="color: red; font-size: 18pt; font-weight: bold;">系统在运行时发生错误.</span><br />
<table dir='ltr' border='1' cellspacing='0' cellpadding='1'>
	<tr><th align='left' bgcolor='#f57900' colspan="10" ><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> {{{$errmsg}}}</th></tr>
	<tr><th align='left' bgcolor='#e9b96e' colspan='10' style="padding-left: 20px; padding-right: 20px;">调用栈</th></tr>
	<tr><th align='center' bgcolor='#eeeeec' style="padding-left: 20px; padding-right: 20px;">#</th><th align='center' bgcolor='#eeeeec' style="padding-left: 20px; padding-right: 20px;">调用函数</th><th align='center' bgcolor='#eeeeec' style="padding-left: 20px; padding-right: 20px;">位置</th></tr>
	<tr><td bgcolor='#eeeeec' align='center' style="padding-left: 20px; padding-right: 20px;">0</td><td bgcolor='#eeeeec' align='center' style="padding-left: 20px; padding-right: 20px;">main()</td><td bgcolor='#eeeeec' align='center' style="padding-left: 20px; padding-right: 20px;">{{{$smarty.server.SCRIPT_FILENAME}}}:0</td></tr>
	{{{$cnt = count($stack)}}}
	{{{for $i = $cnt-1 to 0 step -1}}}
	<tr><td bgcolor='#eeeeec' align='center' style="padding-left: 20px; padding-right: 20px;">{{{$cnt - $i}}}</td><td bgcolor='#eeeeec' align='center' style="padding-left: 20px; padding-right: 20px;">{{{Misc::getFunctionName($stack[$i])}}}</td><td bgcolor='#eeeeec' align='center' style="padding-left: 20px; padding-right: 20px;">{{{Misc::getFunctionLocation($stack[$i])}}}</td></tr>
	{{{/for}}}
</table>
{{{if $config['site']['debug']}}}
{{{include 'debug.tpl'}}}
{{{/if}}}
</body>
</html>