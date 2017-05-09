<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
  <xsl:output method="xml" indent="yes" omit-xml-declaration="yes"/>
  <xsl:variable name="origcode_result5" select="document('../othercode/result5.xml')"/>
  <xsl:variable name="tool" select="$origcode_result5/toolinfo/infos/info[1]"/>
  <xsl:template match="/">
    <xsl:if test="/mininginfo/infos">
      <farmingbots>
        <xsl:for-each select="mininginfo/infos/info">
          <bot>
            <xsl:attribute name="botnumber">
              <xsl:value-of select="farmingbot/@FarmingBotID"/>
            </xsl:attribute>
            <resets>
        </resets>
            <materials>
              <material>
                <xsl:attribute name="id">
                  <xsl:value-of select="$tool/toolrequire/@ResourceID"/>
                </xsl:attribute>
                <name>
                  <xsl:value-of select="$tool/toolrequire/Resourcename"/>
                </name>
                <tools_needed>
                  <tool>
                    <xsl:attribute name="id">
                      <xsl:value-of select="$tool/tool/@ToolID"/>
                    </xsl:attribute>
                    <name>
                      <xsl:value-of select="$tool/tool/Toolname"/>
                    </name>
                  </tool>
                </tools_needed>
              </material>
            </materials>
          </bot>
        </xsl:for-each>
      </farmingbots>
    </xsl:if>
  </xsl:template>
</xsl:stylesheet>