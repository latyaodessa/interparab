SELECT xmlroot(xmlelement(name "rates_and_facilities", 
        xmlagg(
    xmlelement(name "rates_of_particular_facility",
                  xmlelement(name "facility_data", xmlattributes(lf.facility_id as facility_id, lf.facility_type as facility_type),
                                  (case when lf.facility_status = 'ACTIVE' then
                                               xmlforest(
                                               lf.local_facility_name as local_facility_name,
                                               lf.facility_type as facility_type
                                               )
                                            else xmlforest(
                                                           lf.local_facility_name as local_facility_name,
                                                           lf.facility_status as facility_status
                                                           )
                                            end),
                                               xmlelement(name "detailed_data",
                                                      (SELECT 
                                                                xmlagg(
                                                          xmlelement(name "appointment", xmlattributes(ap.appointment_id as appointment_id),
                                                                    xmlforest(
                                                                        ap.appointment_data_to_export as appointment_data_to_export
                                                                            )
                                                                               )
                                                                    )
                                                       FROM appointment ap where ap.facility_id = lf.facility_id
                                                       ),
                                                        xmlelement(name "facility_rate",
                                                             (SELECT 
                                                                    xmlagg(
                                                          xmlelement(name "appointment", xmlattributes(fr.rate as rate, fr.rate_type as rate_type),
                                                                        xmlforest(
                                                                                     fr.rate_description as rate_description,
                                                                                     fr.recommend as recommend
                                                                                    )
                                                                            )
                                                                        )
                                                               FROM facility_rate fr JOIN repair_status rep ON lf.appointment_id = rep.appointment_id
                                                              where lf.appointment_id = fr.appointment_id
                                                               )     
                                                                  )
                                              )
                             )
          )
            )
                          ),
        version '1.0', standalone yes)
FROM (SELECT DISTINCT lf.facility_id,  lf.local_facility_name, lf.facility_type, lf.facility_status,
       a.appointment_id
      from local_facility lf JOIN appointment a ON a.facility_id = lf.facility_id
    LIMIT 30) as lf;
