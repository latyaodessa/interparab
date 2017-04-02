SELECT xmlroot(xmlelement(name "appointment_data", 
  xmlagg(
    xmlelement(name "appointment", xmlattributes(ap.appointment_id as appointment_id),
                      xmlforest(
                              ap.appointment_type as appointment_type,
                              ap.special_handling as special_handling
                            ),
                      xmlelement(name "appointment_details",
                                   xmlelement(name "customer_info",
                                                     (SELECT xmlagg(
                                                            xmlelement(name "customer_details", xmlattributes(c.customer_id as customer_id, c.age as age),
                                                              xmlforest(
                                                                      c.customer_to_export as customer_to_export
                                                                    )
                                                            )
                                                     )
                                                      FROM customer c where ap.customer_id = c.customer_id
                                                     )
                                             ),
                                    xmlelement(name "appointment_date", xmlattributes(ap.appointment_id as appointment_id),
                                              xmlforest(
                                                  ap.real_date as real_date,
                                                  ap.esimated_date as estimated_date
                                                  )
                                              ),
                                    xmlelement(name "status",
                                              xmlelement(name "symptom", xmlattributes(ap.symptom_type as symptom_type),
                                                        xmlforest(
                                                              ap.symptom_description as symptom_description,
                                                              ap.caused_by as caused_by,
                                                              ap.assumption as assumption,
                                                              ap.symptom_from as symptom_from
                                                            ),
                                                         xmlelement(name "status", xmlattributes(ap.status as status, ap.status_type as status_type),
                                                                   xmlforest(
                                                                          ap.repared as repared,
                                                                          ap.spendet_time as spendet_time,
                                                                          ap.esitmated_time as estimated_time
                                                                          )
                                                                   )
                                                        )
                                              )
                                  )
                  )
    )
                         ),
        version '1.0', standalone yes)
FROM (select distinct ap.appointment_id, ap.appointment_type, ap.special_handling, ap.real_date, ap.esimated_date, ap.customer_id,
              s.symptom_type, s.symptom_description,  s.caused_by, s.assumption, s.symptom_from,
              rep.status, rep.status_type, rep.repared, rep.spendet_time, rep.esitmated_time
      from appointment ap
  JOIN repair_status rep ON ap.appointment_id = rep.appointment_id
    JOIN symptom s ON ap.appointment_id = s.appointment_id LIMIT 30) as ap;
