<farmingbots>
{
for $x in doc("../4/othercode/result1.xml")/mininginfo/infos/info
return 
<bot botnumber="{data($x/farmingbot/@FarmingBotID)}">
      <resets/>
      {for $y in doc("../4/othercode/result5.xml")/toolinfo/infos/info[1]
    return 
    <materials>
      <material id="{data($y/toolrequire/@ResourceID)}">
        <name>{data($y/toolrequire/Resourcename)}</name>
        <tools_needed>
          <tool id="{data($y/tool/@ToolID)}">
            <name>{data($y/tool/Toolname)}</name>
          </tool>
        </tools_needed>
      </material>
    </materials>

    }
</bot>
}
</farmingbots>