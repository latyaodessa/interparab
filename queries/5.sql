SELECT xmlroot(xmlelement(name "rates_and_facilities", 
        xmlagg(
    xmlelement(name "rates_of_particular_facility",
                  xmlelement(name "facility_data",
                                               xmlforest(
                                               lf.facility_id as facility_id,
                                               lf.local_facility_name as local_facility_name,
                                               lf.facility_type as facility_type,
                                               lf.facility_status as facility_status
                                               ),
                                               xmlelement(name "detailed_data",
                                                      (SELECT 
                                                                xmlagg(
                                                                    xmlforest(
                                                                        ap.appointment_data_to_export as appointment_data_to_export
                                                                            )
                                                                    )
                                                       FROM appointment ap where ap.facility_id = lf.facility_id
                                                       ),
                                                        xmlelement(name "facility_rate",
                                                             (SELECT 
                                                                    xmlagg(
                                                                        xmlforest(
                                                                                fr.rate as rate,
                                                                                     fr.rate_description as rate_description,
                                                                                     fr.rate_type as rate_type,
                                                                                     fr.recommend as recommend
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