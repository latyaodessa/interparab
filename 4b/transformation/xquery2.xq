<farmingbots>
{
for $x in doc("result3.xml")/farmingbotinfo/infos/info
return 
<bot id="{data($x/farmingbot/@FarmingBotID)}">
	 <name>{data($x/farmingbot/Botname)}</name>
	        <customdesign>
              <Appearance>
                <measurements>
                	{for $y in doc("result1.xml")/mininginfo/infos/info[1]/botsetting return <Weight>{data($y/@ActualQuantity)}</Weight>}
                </measurements>
              </Appearance>
            </customdesign>
                  {for $y in doc("result1.xml")/mininginfo/infos/info[1]/player return
                   <owner email="{concat(data($y/@UserID),'@goggles.com')}">
					<materials_wanted>
                    <name>{data($y/Username)}</name>
                  </materials_wanted>
                   </owner>
                   }      
</bot>
}
</farmingbots>