SELECT xmlroot(xmlelement(name "rate_data", 
  xmlagg(
      xmlelement(name "rate", xmlattributes(ap.appointment_id AS appointment_id),
                               xmlforest(
                              ap.appointment_type AS appointment_type,
                              ap.special_handling AS special_handling
                            ),
                  xmlelement(name "rate_details",
                             xmlelement(name "status", xmlattributes(ap.status AS status,ap.status_type AS status_type, ap.rate AS rate, ap.rate_type AS rate_type),
                                         xmlforest(
                                               ap.repared AS repared,
                                               ap.spendet_time AS spendet_time,
                                               ap.esitmated_time AS estimated_time
                                              )
                                       ),
                             xmlforest(
                                 ap.rate_description AS rate_description,
                                 ap.recommend AS recommend
                                   ),
                      xmlelement(name "customer_data",
                                          (SELECT xmlagg(
                                                    xmlforest(
                                                      c.customer_to_export AS customer_to_export
                                                               )
                                                  )
                                           FROM customer c WHERE c.customer_id = ap.customer_id 
                                        )
                                  )
                        )
                  ))),
        version '1.0', standalone yes)
FROM (SELECT DISTINCT ap.appointment_id, ap.appointment_type, ap.special_handling, ap.customer_id,
                rep.status, rep.status_type, rep.repared, rep.spendet_time, rep.esitmated_time,
                fr.rate, fr.rate_description, fr.rate_type, fr.recommend 
      FROM appointment ap
  JOIN facility_rate fr ON ap.appointment_id = fr.appointment_id 
    JOIN repair_status rep ON ap.appointment_id = rep.appointment_id
    LIMIT 30) AS ap;
 
