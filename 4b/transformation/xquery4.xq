<farmingbots>
{
for $x in doc("result1.xml")/mininginfo/infos/info
return 
<bot id="{data($x/farmingbot/@FarmingBotID)}">
    <botnumber>{data($x/farmingbot/@FarmingBotID)}</botnumber>
    <name>{data($x/farmingbot/Botname)}</name>
    {for $y in doc("result5.xml")/toolinfo/infos/info[1] 
    return <toolscraftedtotal>{data($y/tool/@ToolID)}</toolscraftedtotal>}
    <resources>
      <resource id="{data($x/botsetting/@ResourceID)}">
        <name>{data($x/Resourcename)}</name>
      </resource>
    </resources>
    <owner id="{concat(data($x/player/@UserID),'@goggles.com')}"/>
</bot>
}
</farmingbots>