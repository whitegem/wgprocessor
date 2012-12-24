<!DOCTYPE HTML>
<html>
<head>
<title>Runtime Error</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body style="margin-left: 5%; margin-right: 10%;">
<div style="margin-left: 5%; margin-right: 5%;">
<span style="color: red; font-size: 18pt; font-weight: bold;">An error occurred when executing the script.</span><br />
<table dir='ltr' border='1' cellspacing='0' cellpadding='1'>
	<tr><th align='left' bgcolor='#f57900' colspan="10" ><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> [{{$level}}]{{$errmsg|escape:'htmlall'}} at {{$errfile}}, line {{$errline}}</th></tr>
	<tr><th align='left' bgcolor='#e9b96e' colspan='10' style="padding-left: 20px; padding-right: 20px;">Call Stack</th></tr>
	<tr><th align='center' bgcolor='#eeeeec' style="padding-left: 20px; padding-right: 20px;">#</th><th align='center' bgcolor='#eeeeec' style="padding-left: 20px; padding-right: 20px;">Function</th><th align='center' bgcolor='#eeeeec' style="padding-left: 20px; padding-right: 20px;">Location</th></tr>
	<tr><td bgcolor='#eeeeec' align='center' style="padding-left: 20px; padding-right: 20px;">0</td><td bgcolor='#eeeeec' align='center' style="padding-left: 20px; padding-right: 20px;">main()</td><td bgcolor='#eeeeec' align='center' style="padding-left: 20px; padding-right: 20px;">{{$smarty.server.SCRIPT_FILENAME}}:0</td></tr>
	{{$cnt = count($stack)}}
	{{for $i = $cnt-1 to 2 step -1}}
	<tr><td bgcolor='#eeeeec' align='center' style="padding-left: 20px; padding-right: 20px;">{{$cnt - $i}}</td><td bgcolor='#eeeeec' align='center' style="padding-left: 20px; padding-right: 20px;">{{WGError::getFunctionName($stack[$i])}}</td><td bgcolor='#eeeeec' align='center' style="padding-left: 20px; padding-right: 20px;">{{WGError::getFunctionLocation($stack[$i])}}</td></tr>
	{{/for}}
</table>
</div>
<hr size="1" />
<div style="margin-top: 20px; color: #ff8c00; font-size: 12px;">
	<p style="text-align: center;">
		Powered By WGProcessor {{$smarty.const.WGPROCESSOR_VERSION}}, written by <a href="http://jackyyf.com/" target="_blank">Jack Yu</a> <br />
		Processed in {{(round($WGCore -> getRuntime(), 6))}} ms, with {{round(memory_get_usage() / 1048576.0, 3)}} MB memory usage.
	</p>
</div>
</body>
</html>