<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
  <xsl:output method="xml" indent="yes" omit-xml-declaration="yes"/>
  <xsl:variable name="origcode_result1" select="document('../othercode/result1.xml')"/>
  <xsl:variable name="origcode_result3" select="document('../othercode/result3.xml')"/>
  <xsl:variable name="origcode_result1_first" select="$origcode_result1/mininginfo/infos/info[1]"/>
  <xsl:template match="/">
    <xsl:if test="farmingbotinfo/infos">
      <farmingbots>
        <xsl:for-each select="farmingbotinfo/infos/info">
          <bot>
            <xsl:attribute name="id">
              <xsl:value-of select="farmingbot/@FarmingBotID"/>
            </xsl:attribute>
            <name>
              <xsl:value-of select="farmingbot/Botname"/>
            </name>
          <xsl:variable name="ResourceID" select="botsetting/@ResourceID"/>
            <xsl:for-each select="$origcode_result1/mininginfo/infos/info">
              <xsl:if test="botsetting/@ResourceID = $ResourceID">
           <customdesign>
              <Appearance>
                <measurements>
                  <Weight>
                    <xsl:value-of select="botsetting/@ActualQuantity"/>
                  </Weight>
                </measurements>
              </Appearance>
            </customdesign>
                <xsl:variable name="user_id" select="player/@UserID"/>
                <owner>
                  <xsl:attribute name="email">
                    <xsl:value-of select="concat($user_id, '@goggles.com')"/>
                  </xsl:attribute>
                  <materials_wanted>
                    <name>
                      <xsl:value-of select="player/Username"/>
                    </name>
                  </materials_wanted>
                </owner>
              </xsl:if>
            </xsl:for-each>
           <customdesign>
              <Appearance>
                <measurements>
                  <Weight>
                    <xsl:value-of select="$origcode_result1_first/botsetting/@ActualQuantity"/>
                  </Weight>
                </measurements>
              </Appearance>
            </customdesign>
                <xsl:variable name="user_id" select="$origcode_result1_first/player/@UserID"/>
                <owner>
                  <xsl:attribute name="email">
                    <xsl:value-of select="concat($user_id, '@goggles.com')"/>
                  </xsl:attribute>
                  <materials_wanted>
                    <name>
                      <xsl:value-of select="$origcode_result1_first/player/Username"/>
                    </name>
                  </materials_wanted>
                </owner>
          </bot>
        </xsl:for-each>
      </farmingbots>
    </xsl:if>
  </xsl:template>
</xsl:stylesheet>