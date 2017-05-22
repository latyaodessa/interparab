<!-- HOW TO EXECUTE 
xsltproc xslt4.xsl *.xml 
* - means it will take ALL xmls from othercode
assumed all xmls in one folder -->

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
  <xsl:output method="xml" indent="yes" omit-xml-declaration="yes"/>
  <xsl:variable name="origcode_result5" select="document('result5.xml')"/>
    <xsl:variable name="tool" select="$origcode_result5/toolinfo/infos/info[1]"/>
  <xsl:template match="/">
    <xsl:if test="/mininginfo/infos">
      <farmingbots>
        <xsl:for-each select="mininginfo/infos/info">
          <bot>
            <xsl:attribute name="id">
              <xsl:value-of select="farmingbot/@FarmingBotID"/>
            </xsl:attribute>
            <botnumber>
              <xsl:value-of select="farmingbot/@FarmingBotID"/>
            </botnumber>
            <name>
              <xsl:value-of select="farmingbot/Botname"/>
            </name>
            <toolscraftedtotal>
              <xsl:value-of select="$tool/tool/@ToolID"/>
            </toolscraftedtotal>
            <resources>
              <resource>
                <xsl:attribute name="id">
                <xsl:value-of select="botsetting/@ResourceID"/>
              </xsl:attribute>
                <name>
              <xsl:value-of select="Resourcename"/>
                </name>
              </resource>
            </resources>
            <owner>
              <xsl:variable name="user_id" select="player/@UserID"/>
              <xsl:attribute name="id">
                <xsl:value-of select="concat($user_id, '@goggles.com')"/>
              </xsl:attribute>
            </owner>
          </bot>
        </xsl:for-each>
      </farmingbots>
    </xsl:if>
  </xsl:template>
</xsl:stylesheet>