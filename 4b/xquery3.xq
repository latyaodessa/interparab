<users>
{
for $x in doc("../4/othercode/result1.xml")/mininginfo/infos/info
return 
    
      {for $y in doc("../4/othercode/result4.xml")/collectioninfo/infos/info[1] return 
      <user id="{concat(data($x/player/@UserID),'@notsoserioes.com')}">
       <friends>
            <friend id="{concat(data($y/resource/Description/description/mainDescription/name),'@goggles.com')}"/>
        </friends>
            <messages>
              <message>
                <sender>{concat(data($y/resource/Description/description/mainDescription/name),'@goggles.com')}</sender>
                <receiver>{concat(data($y/farmingbot/@ResourceID),'@notsoserioes.com')}</receiver>
                <content>{data($y/resource/Description/description/mainDescription/text)}</content>
              </message>
            </messages>
          <bots>
            <bot id="{data($y/farmingbot/@FarmingBotID)}">
              <name>{data($y/resource/Resourcename)}</name>
            </bot>
          </bots>
          <materials_wanted>
            <name>{data($y/resource/Description/description/additionalInfo)}</name>
          </materials_wanted>
      </user>
      }
}
</users>