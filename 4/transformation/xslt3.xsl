<!-- HOW TO EXECUTE 
xsltproc xslt3.xsl *.xml 
* - means it will take ALL xmls from othercode
assumed all xmls in one folder -->

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
  <xsl:output method="xml" indent="yes" omit-xml-declaration="yes"/>
  <xsl:variable name="origcode_result4" select="document('result4.xml')"/>
  <xsl:variable name="friend_bot" select="$origcode_result4/collectioninfo/infos/info[1]"/>
  <xsl:template match="/">
    <xsl:if test="/mininginfo/infos">
      <users>
        <xsl:for-each select="mininginfo/infos/info">
          <xsl:variable name="user_id" select="player/@UserID"/>
          <user>
            <xsl:attribute name="id">
              <xsl:value-of select="concat($user_id, '@notsoserioes.com')"/>
            </xsl:attribute>
            <friends>
              <friend>
                <xsl:attribute name="id">
                  <xsl:value-of select="concat($friend_bot/resource/Description/description/mainDescription/name, '@goggles.com')"/>
                </xsl:attribute>
              </friend>
            </friends>
            <messages>
              <message>
                <sender>
                  <xsl:value-of select="concat($friend_bot/resource/Description/description/mainDescription/name, '@goggles.com')"/>
                </sender>
                <receiver>
                  <xsl:value-of select="concat($friend_bot/farmingbot/@ResourceID, '@notsoserioes.com')"/>
                </receiver>
                <content>
                  <xsl:value-of select="$friend_bot/resource/Description/description/mainDescription/text"/>
                </content>
              </message>
            </messages>
            <bots>
              <bot>
                <xsl:attribute name="id">
                  <xsl:value-of select="$friend_bot/farmingbot/@FarmingBotID"/>
                </xsl:attribute>
                <name>
                  <xsl:value-of select="$friend_bot/resource/Resourcename"/>
                </name>
              </bot>
            </bots>
            <materials_wanted>
              <name>
                <xsl:value-of select="$friend_bot/resource/Description/description/additionalInfo"/>
              </name>
            </materials_wanted>
          </user>
        </xsl:for-each>
      </users>
    </xsl:if>
  </xsl:template>
</xsl:stylesheet>