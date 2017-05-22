<catastrophes>
{
for $x in doc("../4/othercode/result1.xml")/mininginfo/infos/info

return 
<natural_disaster>
	<bot id="{data($x/farmingbot/@FarmingBotID)}">
		<name>{data($x/farmingbot/Botname)}</name>
	<timesresettotal>{data($x/botsetting/@ResourceID)}</timesresettotal>
	 <owner>
                <userdata>
                    <User>
                        <Name>
                            <LastName>{data($x/player/Username)}</LastName>
                        </Name>
                    </User>
                </userdata>
            </owner>
    </bot>
</natural_disaster>
}
</catastrophes>