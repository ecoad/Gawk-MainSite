<form enctype="multipart/form-data" action="/api/" method="POST">
	<input type="hidden" name="Action" value="MobileUpload" />
	<input type="hidden" name="WallId" value="clock" />
	<input type="hidden" name="Debug" value="true" />
	<input type="hidden" name="SourceDevice" value="html" />
	Choose a file to upload: <input name="VideoFile" type="file" /><br />
	<input type="submit" value="Upload File" />
</form>
