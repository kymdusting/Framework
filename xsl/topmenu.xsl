<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" omit-xml-declaration="yes"/>

<xsl:param name="current"/>

<xsl:template match="sitetemplate/sitestructure">
	<xsl:apply-templates select="page[nav_mainnav = '1']"></xsl:apply-templates>
</xsl:template>

<xsl:template match="page">
	<xsl:if test="archived != '1'">
    <xsl:choose>
  		<xsl:when test="@id = $current">
			<li id="current"><a>
                <xsl:attribute name="class">menu<xsl:value-of select="level"/></xsl:attribute>
                <xsl:attribute name="href">index.php?pageid=<xsl:value-of select="@ident"/>&amp;level=<xsl:value-of select="level"/></xsl:attribute>
                <xsl:choose><!-- use the short title if it is set -->
                    <xsl:when test="normalize-space(shorttitle)">
                        <xsl:value-of select="shorttitle"/>
                    </xsl:when>
                    <xsl:otherwise>
                        <xsl:value-of select="title"/>
                    </xsl:otherwise>
                </xsl:choose>
            </a></li>
    	</xsl:when>
        <xsl:otherwise>
            <li><a>
                <xsl:attribute name="class">menu<xsl:value-of select="level"/></xsl:attribute>
                <xsl:attribute name="href">index.php?pageid=<xsl:value-of select="@ident"/>&amp;level=<xsl:value-of select="level"/></xsl:attribute>
                <xsl:choose><!-- use the short title if it is set -->
                    <xsl:when test="normalize-space(shorttitle)">
                        <xsl:value-of select="shorttitle"/>
                    </xsl:when>
                    <xsl:otherwise>
                        <xsl:value-of select="title"/>
                    </xsl:otherwise>
                </xsl:choose>
            </a></li>
        </xsl:otherwise>
    </xsl:choose>    
    
	</xsl:if>
</xsl:template>

</xsl:stylesheet>