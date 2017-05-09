<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="xml" indent="yes" omit-xml-declaration="yes"/>
  <xsl:template match="/">
    <xsl:if test="/mininginfo/infos">
    <catastrophes>
       <xsl:for-each select="mininginfo/infos/info">
          <natural_disaster>
            <bot>
                <xsl:attribute name="id">
                       <xsl:value-of select="farmingbot/@FarmingBotID" />
                </xsl:attribute>
                <name>
                      <xsl:value-of select="farmingbot/Botname" />
                </name>
                <timesresettotal>
                  <xsl:value-of select="botsetting/@ResourceID" />
                </timesresettotal>
              <owner>
                <userdata>
                    <User>
                        <Name>
                            <LastName>
                             <xsl:value-of select="player/Username" /> 
                            </LastName>
                        </Name>
                    </User>
                </userdata>
            </owner>
            </bot>
          </natural_disaster>
         </xsl:for-each>
    </catastrophes>
    </xsl:if>
  </xsl:template>
</xsl:stylesheet>