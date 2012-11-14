<?xml version="1.0" encoding="UTF-8"?>
<Module>
  <ModulePrefs title="BigBlueButton Web Conferencing" height="250" thumbnail="{$thumbnail_url}">
    <Require feature="setprefs"/>
  </ModulePrefs>
  <UserPref name="groupContext"></UserPref>
  <Content type="html">
<![CDATA[
	<iframe frameborder="no" id="bigbluebutton_frame" src="{$script_url}?fmt=g" width="100%" height="250"></iframe>
	<script type="text/javascript">
		var prefs = new gadgets.Prefs();
		var groupContext = prefs.getString('groupContext');
		var url = '{$script_url}?fmt=g';
		if(groupContext!="") {
			url += '&groupContext=' + groupContext;
		}
		document.getElementById('bigbluebutton_frame').setAttribute('src', url);
	</script>
]]>
  </Content>
</Module>
