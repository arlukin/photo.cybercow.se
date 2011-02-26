<?xml version="1.0" encoding="ISO-8859-15"?>
<xsl:stylesheet version="1.0"
								xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template match="/">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>ccPhoto Frontend</title>
		<link rel="stylesheet" type="text/css" href="album.css" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="Daniel Lindh, aka Arlukin, aka Master Po" />
		<meta name="robots" content="index, follow" />
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
	</head>
	<body>
		<h2><xsl:value-of select="album/title"/></h2>
		<xsl:for-each select="album/photo">
			<div class="images">
				<div class="imagediv">
					<a href="http://homecow.cybercow.se/photo.cybercow.se/{link}">
						<img src="http://homecow.cybercow.se/photo.cybercow.se/{thumb}"/>
					</a>
					<div class="desc"><xsl:value-of select="title"/></div>
				</div>
			</div>

		</xsl:for-each>
	</body>
</html>
</xsl:template>

</xsl:stylesheet>

