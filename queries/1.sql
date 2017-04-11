select xmlroot(xmlelement(name "customer_data", 
                xmlagg(
                    xmlelement(name "customer", xmlattributes(c.customer_id as customer_id, c.age as age),
        xmlforest(
                        c.last_name as last_name,
                        c.first_name as first_name,
                        c.gender as gender,
                        c.age as age,
                        c.title as title
                     ),
                                                xmlelement(name "order_details",
                                                           (case when char_length(c.email)<21 then 
                   xmlforest(
                               c.email as email
                             ) else 
                              xmlforest(
                               c.phone as phone
                             ) 
                                                            end),
                           xmlelement(name "order_address",
                                           xmlforest(
                                            c.street as street,
                                            c.hause as house,
                                            c.flat as flat,
                                            c.gender as gender,
                                            c.porch as porch
                                                  ),
                                           xmlelement(name "detailed_order_data", xmlattributes(c.postal_code as potal_code),
                                                        xmlforest(
                                                            c.country as country,
                                                            c.city as city,
                                                            c.continent as continent
                                                                ),
                                                        xmlelement(name "customer_fridges_on_current_address",
                                                                          (SELECT xmlagg(
                                                                                xmlelement(name "fridge", xmlattributes(f.fridge_id AS fridge_id, f.year_of_prod as year_of_production),
                                                                                        xmlforest(
                                                                                                    f.type AS fridge_type,
                                                                                                    
                                                                                                    f.color as fridge_color,
                                                                                                    f.prod_country as prod_country,
                                                                                                    f.volume as fridge_volume
                                                                                                )
                                                                                           )
                                                                                        )
                                                                           FROM fridge as f WHERE c.fridge_id = f.fridge_id
                                                                          )
                                                                 )
                                                      )
                                           )
                           )
                               
                               )
                 )
                  ),
        version '1.0', standalone yes)
from (select DISTINCT c.fridge_id, c.customer_id, c.last_name, c.first_name, c.gender, c.age, c.title, c.email, c.phone,
              ca.street, ca.hause,ca.flat,ca.porch,
              pc.postal_code, pc.country, pc.city, pc.continent
              from customer as c
              JOIN customer_address as ca ON c.customer_id = ca.customer_id
              JOIN postal_code as pc ON ca.postal_code = pc.postal_code LIMIT 30) as c;