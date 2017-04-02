SELECT xmlroot(xmlelement(name "local_facility_data", 
  xmlagg(
    xmlelement(name "local_facility", xmlattributes(lf.facility_id as facility_id, lf.facility_status as facility_status),
                   xmlforest(
                       lf.local_facility_name as local_facility_name,
                       lf.facility_type as facility_type
                       ),
                xmlelement(name "provide_service",
                    xmlelement(name "provide_service_in",
                               (SELECT xmlagg(
                                      xmlelement(name "postal_code", xmlattributes(pc.postal_code as potal_code),
                                            xmlforest(
                                                pc.country as country,
                                                pc.city as city,
                                                pc.continent as continent
                                                    )
                                                   )
                                             )
                               FROM postal_code pc where lf.postal_code = pc.postal_code
                               ),
                    xmlelement(name "provide_service_for",
                               (SELECT xmlagg(
                        xmlelement(name "customer_data", xmlattributes(c.customer_id as customer_id, c.age as age),
                                                    xmlforest(
                                                                    c.last_name as last_name,
                                                                    c.first_name as first_name,
                                                                    c.gender as gender,
                                                                    c.title as title
                                                                ),
                                                              xmlelement(name "customer_address", xmlattributes(ca.street as street),
                                                                              xmlforest(
                                                                                    ca.street as street,
                                                                                    ca.hause as house,
                                                                                    ca.flat as flat,
                                                                                    ca.porch as porch                                                                              
                                                                                        )
                                                                          )
                                                           )
                                             )
                               FROM customer c 
                                JOIN customer_address ca ON c.customer_id = ca.customer_id
                                where c.customer_id = lf.customer_id
                               )
                             )
                       )
                    )
             )
        )
                         ),
        version '1.0', standalone yes)
FROM (select distinct lf.facility_id, lf.local_facility_name, lf.facility_type, lf.facility_status, lf.postal_code, lf.customer_id
      
      from local_facility as lf LIMIT 30) as lf;